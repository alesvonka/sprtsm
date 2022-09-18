<?php

declare(strict_types=1);

namespace App\Control;

use Nette;

use Nette\Application\UI\Control;
use App\Model\BrandManager;
use Nette\Application\Attributes\Persistent;
use Nette\Application\UI\Form;
use Nette\Database\UniqueConstraintViolationException;
use Nette\Utils\ArrayHash;
use Nette\Utils\Strings;

class BrandGridControl extends Control
{

    use Nette\SmartObject;

    #[Persistent]
    public $page = 1;

    #[Persistent]
    public $parePage = 5;

    #[Persistent]
    public $sort = 'asc';

    #[Persistent]
    public $id;
    public $item;

    public function __construct(
        private BrandManager $brandManager,
    ) {
    }

    public function createComponentBrandForm(): Form
    {
        $form = new Form();
        $form->getElementPrototype()->class('ajax');
        $form->addHidden('id', null)
            ->setNullable();
        $form->addText('name', 'Název značky')
            ->setRequired('Vyplňte prosím toto pole!');

        $this->item = $this->brandManager->items()->get($this->id);

        if ($this->item) {
            $form['id']->value = $this->item->id;
            $form['name']->value = $this->item->name;

            $form->addSubmit('submit', 'Editovat')
                ->setHtmlAttribute('class', 'modal-close');
        } else {
            $form->addSubmit('submit', 'Uložit')
                ->setHtmlAttribute('class', 'modal-close');
        }

        $form->onSuccess[] = [$this, 'brandFormSuccess'];

        return $form;
    }
    public function brandFormSuccess(Form $form, ArrayHash $values): void
    {
        if ($this->item) {
            try {
                $this->item->update([
                    'name' => $values->name,
                ]);
            } catch (UniqueConstraintViolationException $e) {
                $form->addError($values->name . ' už existuje. Zadejte jiný název značky.');
            }
        } else {
            try {
                $this->brandManager->items()->insert($values);
            } catch (UniqueConstraintViolationException $e) {
                $form->addError($values->name . ' už existuje. Zadejte jiný název značky.');
            }
        }

        $form->reset();

        $this->presenter->payload->postGet = true;
        $this->presenter->payload->url = $this->link('this');
        $this->redrawControl('grid');
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
        $this->presenter->payload->postGet = true;
        $this->presenter->payload->url = $this->link('this');
        $this->redrawControl('brandForm');
    }

    public function handleEdit($id)
    {
        if ($id) {
            $this->id = $id;
            $this->redrawControl('brandForm');
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
        $this->id = null;
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
