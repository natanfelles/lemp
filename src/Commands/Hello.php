<?php

class Hello extends Command
{
	protected $name        = 'hello';
	protected $description = 'Hello description.';

	/**
	 * @param  Symfony\Component\Console\Input\InputInterface   $input
	 * @param  Symfony\Component\Console\Output\OutputInterface $output
	 */
	protected function exec($input, $output)
	{
		$output->writeln('Hello!');

		$name = $this->prompt('What is your name? ');

		$template = $this->template('hello', ['name' => $name]);
		$output->writeln('Template: ' . $template);
	}
}
