<?php

declare(strict_types=1);

namespace App\Model;

use Nette\Database\Table\Selection;

class BrandManager
{
    const Table =  'brand';

    public function __construct(
        private  DbManager $dbManager,
    ) {
    }

    public function items(): Selection
    {
        return $this->dbManager->db()->table(self::Table);
    }
}
