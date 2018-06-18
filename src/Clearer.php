<?php namespace Morrislaptop\LaravelQueueClear;

use Illuminate\Queue\QueueManager;
use Illuminate\Contracts\Queue\Factory as FactoryContract;
use Morrislaptop\LaravelQueueClear\Contracts\Clearer as ClearerContract;

class Clearer implements ClearerContract
{
	/**
	 * @var QueueManager
	 */
	protected $manager;

	/**
	 * {@inheritDoc}
	 */
	function __construct(FactoryContract $manager)
	{
		$this->manager = $manager;
	}

	/**
	 * {@inheritDoc}
	 */
	public function clear($connection, $queue)
	{
		$count = 0;
		$connection = $this->manager->connection($connection);

		while ($job = $connection->pop($queue)) {
			if($jobName == $job->getName()) {
				$job->delete();
				$count++;
			}
		}

		return $count;
	}

	public function count($connection, $queue, $jobName)
	{
		$count = 0;
		$connection = $this->manager->connection($connection);

		while ($job = $connection->pop($queue)) {
			if($jobName == '') {
                		$count++;
                		continue;
            		}
		    	if($jobName == $job->getName()) {
			    $count++;
            		}
		}

		return $count;
	}

}
