<?php

use Symfony\Component\Console\Command\Command as SymfonyCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Templating\PhpEngine;
use Symfony\Component\Templating\TemplateNameParser;
use Symfony\Component\Templating\Loader\FilesystemLoader;
use SystemCtl\Service;

class Command extends SymfonyCommand
{
	protected $name = 'command';
	protected $description;
	/**
	 * mode:
	 * 		const REQUIRED = 1;
	 *		const OPTIONAL = 2;
	 *		const IS_ARRAY = 4;
	 * @var array
	 */
	protected $arguments = [];
	protected $help;

	protected function configure()
	{
		$this->config();
	}

	protected function config()
	{
		$this->setName($this->name)
			 ->setDescription($this->description)
			 ->setHelp($this->help);

		foreach ($this->arguments as $name => $options)
		{

			$this->addArgument(
				$name,
				$options['mode'] ?? null,
				$options['description'] ?? '',
				$options['default'] ?? null
			);
		}
	}

	protected function execute(InputInterface $input, OutputInterface $output)
	{
		$this->input  = $input;
		$this->output = $output;
		$this->exec($this->input, $this->output);
	}

	/**
	 * Execute the command.
	 *
	 * Normally this is the only method to ovewrite.
	 *
	 * @param InputInterface  $input
	 * @param OutputInterface $output
	 */
	protected function exec($input, $output)
	{
	}

	/**
	 * Prompt a question to the user
	 *
	 * @param string      $question
	 * @param null|string $default  Default value
	 *
	 * @return mixed The user answer
	 */
	protected function prompt(string $question, $default = null)
	{
		$helper   = $this->getHelper('question');
		$question = new Question($question, $default);

		return $helper->ask($this->input, $this->output, $question);
	}

	/**
	 * Render a template
	 *
	 * @param string $name
	 * @param array  $parameters
	 *
	 * @return string
	 */
	protected function template(string $name, array $parameters = [])
	{
		$loader     = new FilesystemLoader(__DIR__ . '/Templates/%name%.php');
		$templating = new PhpEngine(new TemplateNameParser(), $loader);

		return $templating->render($name, $parameters);
	}
}
