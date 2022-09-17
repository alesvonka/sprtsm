<?php

declare(strict_types=1);

namespace App\Model;

use Nette\Database\Connection;
use Nette\Database\Explorer;

class DbManager
{
    private $db;

    public function __construct(Explorer $db)
    {
        $this->db = $db;
    }

    public function db(): Explorer
    {
        return $this->db;
    }
}
