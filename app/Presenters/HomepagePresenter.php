<?php

declare(strict_types=1);

namespace App\Presenters;

use App\Control\BrandFormControl;
use App\Model\BrandManager;
use Nette;
use Nette\Application\Attributes\Persistent;
use Nette\DI\Attributes\Inject;
use Nette\Utils\Strings;
use Traits\TModal;
use App\Control\BrandFormControlFactory;

final class HomepagePresenter extends Nette\Application\UI\Presenter
{
    use Nette\SmartObject;
    use TModal;

    #[Inject]
    public BrandManager $brandManager;

    #[Inject]
    public BrandFormControlFactory $brandFormControlFactory;

    #[Persistent]
    public $page = 1;

    #[Persistent]
    public $parePage = 5;

    #[Persistent]
    public $sort = 'asc';

    #[Persistent]
    public $id;


    public function beforeRender()
    {
        if ($this->isAjax()) {
            $this->redrawControl('grid');
        }
    }

    public function handleSort($sort): void
    {
        if ($sort) {
            $this->sort = Strings::lower($sort);

            if ($this->isAjax()) {
                $this->redrawControl('grid');
            }
        }
    }

    public function handleAdd(): void
    {
        $this->handleModal('addBrandModal');
    }

    public function handleEdit($id): void
    {
        if ($id) {
            $this->handleModal('editBrandModal');
        }
    }

    public function handleDelete($id): void
    {
        if ($id) {

            $item = $this->brandManager->items()->get($id);

            if ($item) {
                $item->delete();
            }

            if ($this->isAjax()) {
                $this->payload->postGet = true;
                $this->payload->url = $this->link('this');
                $this->redrawControl('grid');
            }
        }
    }

    public function createComponentAddBrandForm(): BrandFormControl
    {
        $control = $this->brandFormControlFactory->create();

        $control->onFormSuccess[] = function () {
            $this->payload->hideModal = true;
            $this->payload->postGet = true;
            $this->payload->url = $this->link('this');
            $this->redrawControl('grid');
        };

        return $control;
    }

    public function createComponentEditBrandForm(): BrandFormControl
    {
        $control = $this->brandFormControlFactory->create((int) $this->id);

        $control->onFormSuccess[] = function () {
            $this->id = null;
            $this->payload->hideModal = true;
            $this->payload->postGet = true;
            $this->payload->url = $this->link('this');
            $this->redrawControl('grid');
        };

        return $control;
    }

    public function renderDefault($page, $parePage, $id): void
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
    }
}
