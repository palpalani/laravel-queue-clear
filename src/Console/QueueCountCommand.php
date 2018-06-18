<?php namespace Morrislaptop\LaravelQueueClear\Console;

use Illuminate\Console\Command;
use Illuminate\Contracts\Config\Repository;
use Illuminate\Queue\QueueManager;
use Morrislaptop\LaravelQueueClear\Contracts\Clearer as ClearerContract;
use Symfony\Component\Console\Input\InputArgument;

class QueueCountCommand extends Command {


	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'queue:count';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Count of queued jobs.';

	/**
	 * @var
	 */
	protected $config;

	/**
	 * @var QueueManager
	 */
	protected $queue;

	/**
	 * @var Clearer
	 */
	protected $clearer;

	/**
	 * @param Repository $config
	 * @param Clearer $clearer
	 */
	function __construct(Repository $config, ClearerContract $clearer)
	{
		$this->config = $config;
		$this->clearer = $clearer;
		parent::__construct();
	}

	/**
	 * Defines the arguments.
	 *
	 * @return array
	 */
	public function getArguments()
	{
		return array(
			array('connection', InputArgument::OPTIONAL, 'The connection of the queue driver to clear.'),
			array('queue', InputArgument::OPTIONAL, 'The name of the queue / pipe to clear.'),
		);
	}

	/**
	 * Execute the console command.
	 *
	 * @return void
	 */
	public function handle()
	{
		$connection = $this->argument('connection') ?: $this->config->get('queue.default');
		$queue = $this->argument('queue') ?: $this->config->get('queue.connections.' . $connection  . '.queue');

		$this->info(sprintf('Counting queue "%s" on "%s"', $queue, $connection));
		$cleared = $this->clearer->count($connection, $queue);
		$this->info(sprintf('Count: %d jobs', $cleared));
	}

}
