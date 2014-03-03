<?php namespace Rtablada\LiterateLaravel\Console;

use Rtablada\LiterateLaravel\DirectoryCompiler;
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class LiterateCompilerCommand extends Command
{

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'literate:compile';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Compiles literate PHP into source.';

	protected $compiler;

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct(DirectoryCompiler $compiler)
	{
		$this->compiler = $compiler;

		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{
		$inDirectory = $this->argument('in_path') ?: base_path('lit');
		$outDirectory = $this->argument('out_path') ?: app_path();

		$this->info('Compiling Literate Files');
		$this->compiler->compile($inDirectory, $outDirectory);
	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return array(
			array('in_path', InputArgument::OPTIONAL, 'Path to literate input directory.'),
			array('out_path', InputArgument::OPTIONAL, 'Path to output directory.'),
		);
	}

	/**
	 * Get the console command options.
	 *
	 * @return array
	 */
	protected function getOptions()
	{
		return array(
		);
	}

}
