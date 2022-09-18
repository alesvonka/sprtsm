<?php

declare(strict_types=1);

namespace App\Control;

use Nette;

use Nette\Application\UI\Control;
use App\Model\BrandManager;
use Nette\Application\Attributes\Persistent;
use Nette\Utils\Strings;

class BrandGridControl extends Control
{

    #[Persistent]
    public $page = 1;

    #[Persistent]
    public $parePage = 5;

    #[Persistent]
    public $sort = 'asc';

    public function __construct(
        private BrandManager $brandManager,
    ) {
    }


    public function handleSort($sort)
    {
        if ($sort) {
            $this->sort = Strings::lower($sort);

            if ($this->presenter->isAjax()) {
                $this->redrawControl('grid');
            }
        }
    }

    public function handleAdd()
    {
        bdump(__FUNCTION__);
        if ($this->presenter->isAjax()) {
            $this->redrawControl('grid');
        }
    }

    public function handleEdit($id)
    {
        if ($id) {
            bdump(__FUNCTION__);
            bdump($id);

            if ($this->presenter->isAjax()) {
                $this->redrawControl('grid');
            }
        }
    }

    public function handleDelete($id)
    {
        if ($id) {
            bdump(__FUNCTION__);
            bdump($id);

            if ($this->presenter->isAjax()) {
                $this->redrawControl('grid');
            }
        }
    }

    public function handleP($page, $parePage)
    {
        $this->page = $page;
        $this->parePage = $parePage;
        if ($this->presenter->isAjax()) {
            $this->redrawControl('grid');
        }
    }

    public function render()
    {
        $this->sort = Strings::lower($this->sort);
        $this->sort = $this->sort === 'desc' ? 'desc' : 'asc';

        $brands = $this->brandManager->items()->order('name ' . Strings::upper($this->sort));
        $lastPage = 0;

        $this->template->brands = $brands->page($this->page, $this->parePage, $lastPage);
        $this->template->page = $this->page;
        $this->template->parePage = $this->parePage;
        $this->template->lastPage = $lastPage;
        $this->template->sort = $this->sort;
        $this->template->render(__DIR__ . '/BrandGridControl.latte');
    }
}

interface BrandGridControlFactory
{
    public function create(): BrandGridControl;
}
