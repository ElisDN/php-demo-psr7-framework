<?php

namespace App\Console\Command;

use App\Service\FileManager;
use Framework\Console\Command;
use Framework\Console\Input;
use Framework\Console\Output;

class CacheClearCommand extends Command
{
    private $paths;
    private $files;

    public function __construct(array $paths, FileManager $files)
    {
        $this->paths = $paths;
        $this->files = $files;
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->setName('cache:clear')
            ->setDescription('Clear cache');
    }

    public function execute(Input $input, Output $output): void
    {
        $output->writeln('<comment>Clearing cache</comment>');

        $alias = $input->getArgument(1);

        if (empty($alias)) {
            $alias = $input->choose('Choose path', array_merge(['all'], array_keys($this->paths)));
        }

        if ($alias === 'all') {
            $paths = $this->paths;
        } else {
            if (!array_key_exists($alias, $this->paths)) {
                throw new \InvalidArgumentException('Unknown path alias "' . $alias . '"');
            }
            $paths = [$alias => $this->paths[$alias]];
        }

        foreach ($paths as $path) {
            if ($this->files->exists($path)) {
                $output->writeln('Remove ' . $path);
                $this->files->delete($path);
            } else {
                $output->writeln('Skip ' . $path);
            }
        }

        $output->writeln('<info>Done!</info>');
    }
}
