<?php

declare(strict_types=1);

namespace App\Model;

use Exception;
use Nette\Database\Table\Selection;

class BrandManager
{
    const Table =  'brand';

    public function __construct(
        private  DbManager $dbManager,
    ) {
    }

    /**
     * Undocumented function
     *
     * @return Selection
     * @throws Exception
     */
    public function items(): Selection
    {
        try{
            return $this->dbManager->db()->table(self::Table);
        }catch(Exception $e)
        {
            throw new Exception();
        }
        
    }
}
