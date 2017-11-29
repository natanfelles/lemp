<?php

class Start extends Command
{
	protected $name        = 'start';
	protected $description = 'Start services.';
	protected $arguments   = [
		'service' => [
			'mode' => 2,
		],
	];

	/**
	 * @param  Symfony\Component\Console\Input\InputInterface   $input
	 * @param  Symfony\Component\Console\Output\OutputInterface $output
	 */
	protected function exec($input, $output)
	{
		$service = $input->getArgument('service');

		$service = new SystemCtl\Service($service);
		//$service::sudo(false);

		if (in_array($service, ['nginx', 'mysql']))
		{
			if ($service->isRunning())
			{
				$output->writeln("The service {$service} already is running.");
			}
			else
			{
				$service->start();
			}
		}
		else
		{
			$output->writeln("The service {$service} is not allowed.");
		}
	}
}
