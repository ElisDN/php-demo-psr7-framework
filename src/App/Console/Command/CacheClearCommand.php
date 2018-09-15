<?php

namespace App\Console\Command;

class CacheClearCommand
{
    private $paths = [
        'twig' => 'var/cache/twig',
        'db' => 'var/cache/db',
    ];

    public function execute($args): void
    {
        echo 'Clearing cache' . PHP_EOL;

        $alias = $args[0] ?? '';

        if (empty($alias)) {
            $options = array_merge(['all'], array_keys($this->paths));
            do {
                fwrite(\STDOUT, 'Choose path [' . implode(',', $options) . ']: ');
                $choose = trim(fgets(\STDIN));
            } while (!\in_array($choose, $options, true));
            $alias = $choose;
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
                echo 'Remove ' . $path . PHP_EOL;
                $this->delete($path);
            } else {
                echo 'Skip ' . $path . PHP_EOL;
            }
        }

        echo 'Done!' . PHP_EOL;
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
