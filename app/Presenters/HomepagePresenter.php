<?php

declare(strict_types=1);

namespace App\Presenters;

use App\Model\DbManager;
use Nette;
use Nette\DI\Attributes\Inject;

final class HomepagePresenter extends Nette\Application\UI\Presenter
{
    #[Inject]
    public DbManager $dbManager;

    public function handleTest()
    {
        $this->flashMessage(__DIR__, 'light-green accent-3');
        $this->flashMessage(__DIR__);

        if ($this->isAjax()) {
            $this->redrawControl('flashes');
            $this->payload->postGet = true;
            $this->payload->url = $this->link('this');
        } else {
            $this->redirect('this');
        }
    }

    public function renderDefault()
    {
        $this->template->brands = $this->dbManager->db()->table('brand')->order('name ASC')->limit(5);
    }
}
