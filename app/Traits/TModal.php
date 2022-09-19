<?php

declare(strict_types=1);

namespace Traits;

trait TModal
{
	public function handleModal(string $modal): void
	{
		$this->payload->showModal = true;
		$this->template->modal = $modal;
		if ($this->isAjax()) {
			$this->redrawControl('modal');
			$this->payload->postGet = true;
			$this->payload->url = $this->link('this');
		}
	}
}
