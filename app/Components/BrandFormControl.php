<?php

declare(strict_types=1);

namespace App\Control;

use Nette\Application\UI\Control;
use App\Model\BrandManager;
use Nette\Application\UI\Form;
use Nette\Database\UniqueConstraintViolationException;
use Nette\Utils\ArrayHash;
use Nette\SmartObject;

class BrandFormControl extends Control
{
    use SmartObject;

    public $onFormSuccess;
    public $id;
    public $item;

    public function __construct(
        private BrandManager $brandManager,
        $id
    ) {
        $this->id = $id;
    }

    public function createComponentForm(): Form
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
                ->setHtmlAttribute('class', 'waves-effect blue white-text btn');
        } else {
            $form->addSubmit('submit', 'Uložit')
                ->setHtmlAttribute('class', 'waves-effect blue white-text btn');
        }

        $form->onSuccess[] = [$this, 'formSuccess'];

        return $form;
    }

    public function formSuccess(Form $form, ArrayHash $values): void
    {
        if ($this->item) {
            try {
                $this->item->update([
                    'name' => $values->name,
                ]);
                
                $this->onFormSuccess();
            } catch (UniqueConstraintViolationException $e) {
                $form->addError($values->name . ' už existuje. Zadejte jiný název značky.');
                $this->redrawControl('form');
            }
        } else {
            try {

                $this->brandManager->items()->insert($values);
                $this->onFormSuccess();
            } catch (UniqueConstraintViolationException $e) {
                $form->addError($values->name . ' už existuje. Zadejte jiný název značky.');
                $this->redrawControl('form');
            }
        }
    }

    public function render(): void
    {
        $this->template->render(__DIR__ . '/BrandFormControl.latte');
    }
}

interface BrandFormControlFactory
{
    /**
     * BrandFormControlFactory
     *
     * @param null|int $id
     * @return BrandFormControl
     */
    public function create($id = null): BrandFormControl;
}
