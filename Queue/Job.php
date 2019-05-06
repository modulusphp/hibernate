<?php

namespace Modulus\Hibernate\Queue;

use Carbon\Carbon;
use Modulus\Hibernate\Encrypt\AES;
use Modulus\Framework\Hashids\Hashids;
use Illuminate\Database\Eloquent\Model;
use Modulus\Hibernate\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Builder;
use Modulus\Hibernate\Queue\QueueInstance;

class Job extends Model
{
  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    'queueid', 'queue', 'processed', 'tries'
  ];

  /**
   * Get the current connection name for the model
   *
   * @return string
   */
  public function getConnectionName()
  {
    $connection = config('queue.default');

    return (array_key_exists($connection, config("queue.connections")) ? $connection : 'queue');
  }

  /**
   * Encrypt on Set Queue Attribute
   *
   * @param mixed $value
   * @return string
   */
  public function setQueueAttribute($value) : string
  {
    return $this->attributes['queue'] = AES::encrypt($value);
  }

  /**
   * Decrypt on Get Queue Attribute
   *
   * @param mixed $value
   * @return QueueInstance
   */
  public function getQueueAttribute($value) : QueueInstance
  {
    return new QueueInstance($value);
  }

  /**
   * Create job
   *
   * @param ShouldQueue $queue The dispatchable job
   * @param Carbon|null $delay Set the desired delay for the job
   * @return Job
   */
  public static function add(ShouldQueue $queue, ?Carbon $delay = null) : Job
  {
    $queueObject = ['class' => $queue, 'delay' => ($delay ?? null)];

    $job = Job::create(['queue' => $queueObject, 'tries' => (is_numeric($queue->getTries()) ? $queue->getTries() : 3)]);

    $job->update(['queueid' => Hashids::encode($job->id, null, null, 40)]);

    return $job;
  }

  /**
   * Find job where queue id is [?]
   *
   * @param string $queueId
   * @return Builder
   */
  public static function whereQueueId(string $queueId) : Builder
  {
    return Job::where('queueid', $queueId);
  }

  /**
   * Find job where queue id is [?]
   *
   * @param string $queueId
   * @return Job|null
   */
  public static function firstWhereQueueId(string $queueId)
  {
    return Job::where('queueid', $queueId)->first();
  }

  /**
   * Check if job has been process
   *
   * @return bool
   */
  public function hasBeenProcessed() : bool
  {
    return $this->processed == $this->tries;
  }

  /**
   * Check if Queue should be processed
   *
   * @return bool
   */
  public function shouldRun() : bool
  {
    $delay = ($this->queue->delay ?? Carbon::now())->startOfMinute();

    $now   = Carbon::now()->startOfMinute();

    return $delay < $now || $delay == $now;
  }

  /**
   * Increment processed count
   *
   * @return bool
   */
  public function isRunning() : bool
  {
    $this->processed++;

    return $this->save();
  }

  /**
   * Get when job will run
   *
   * @return string
   */
  public function monitor() : string
  {
    return ($this->queue->delay ?? Carbon::now())->startOfMinute()->diffForHumans();
  }
}
