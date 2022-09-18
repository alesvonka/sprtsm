<?php

declare(strict_types=1);

namespace App\Presenters;

use App\Control\BrandGridControl;
use App\Control\BrandGridControlFactory;
use Nette;
use Nette\DI\Attributes\Inject;

final class HomepagePresenter extends Nette\Application\UI\Presenter
{
    #[Inject]
    public BrandGridControlFactory $brandControlFactory;

    public function createComponentBrand(): BrandGridControl
    {
        $control = $this->brandControlFactory->create();
        return $control;
    }

    public function renderDefault()
    {
    }
}
