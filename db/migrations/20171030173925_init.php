<?php

use Phinx\Migration\AbstractMigration;

class Init extends AbstractMigration
{
    public function change(): void
    {
        $this->table('posts')
            ->addColumn('date', 'datetime')
            ->addColumn('title', 'string')
            ->addColumn('content', 'text')
            ->create();
    }
}
