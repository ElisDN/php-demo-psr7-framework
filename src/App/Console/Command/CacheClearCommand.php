<?php

namespace App\Console\Command;

use Framework\Console\Input;
use Framework\Console\Output;

class CacheClearCommand
{
    private $paths;

    public function __construct(array $paths)
    {
        $this->paths = $paths;
    }

    public function execute(Input $input, Output $output): void
    {
        $output->writeln('<comment>Clearing cache</comment>');

        $alias = $input->getArgument(0);

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
            if (file_exists($path)) {
                $output->writeln('Remove ' . $path);
                $this->delete($path);
            } else {
                $output->writeln('Skip ' . $path);
            }
        }

        $output->writeln('<info>Done!</info>');
    }

    private function delete(string $path): void
    {
        if (!file_exists($path)) {
            throw new \RuntimeException('Undefined path ' . $path);
        }

        if (is_dir($path)) {
            foreach (scandir($path, SCANDIR_SORT_ASCENDING) as $item) {
                if ($item === '.' || $item === '..') {
                    continue;
                }
                $this->delete($path . DIRECTORY_SEPARATOR . $item);
            }
            if (!rmdir($path)) {
                throw new \RuntimeException('Unable to delete directory ' . $path);
            }
        } else {
            if (!unlink($path)) {
                throw new \RuntimeException('Unable to delete file ' . $path);
            }
        }
    }
}
