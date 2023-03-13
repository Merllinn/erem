<?php

namespace App\AdminModule\Presenters;

use 	TH\Form,
		Nette\Utils\Html;
use     Ublaboo\DataGrid\DataGrid;

class SliderPresenter extends BasePresenter
{
	public $editedId = false;



	public function startup(){
		parent::startup();
		$this->addBreadcrumbs("Videa", $this->link(":Admin:Slider:default"));

	}

	public function actionDefault(array $items = null){
		if(!empty($items)){
			foreach($items as $index=>$item){
				$this->commonManager->updateSlide(array("order"=>$index+1), $item);
			}
			$this->flashMessage("Pořadí videí bylo uloženo");
			$this->redirect("this");
		}
	}

	public function actionAdd(){
		$this->setView("addEdit");
	}

	public function actionEdit($id){
		$this->editedId = $id;
		$details = $this->commonManager->findSlide($id);
		$this["slideForm"]->setDefaults($details);
		$this->setView("addEdit");
	}

	public function handleDelete($id){
		$this->commonManager->deleteSlide($id);
		$this->redirect("this");
	}

    /**
     * Make table of customers
     *
     * @return \Addons\Tabella
     */
    public function createComponentSlides($name)
    {
        $presenter = $this;

        $source = $this->commonManager->getSlider()->order("order");

        $grid = new DataGrid($this, $name);
        $grid->setDataSource($source);

        $grid->addColumnText('name', 'Název');
        
        $grid->addColumnText('link', 'Odkaz')
            ->setRenderer(function($row) use ($presenter) {
                	if($row->link){
                        return html::el("a")->href($row->link)->target("_blank")->setHtml("Zobrazit " . html::el("i")->class("fas fa-external-link-alt"))->title("Zobrazit");
                    }
                    else{
                        return "";
                    }
        });

        $grid->addColumnText('tools', 'Nástroje')
            ->setRenderer(function($row) use ($presenter) {
                $el = Html::el("span");
                $el->insert(0, html::el("a")->class("btn btn-mini btn-light")->href($presenter->link("edit", $row->id))->setHtml(html::el("i")->class("fas fa-edit"))->title("Upravit"));
                $el->insert(1, " ");
                $el->insert(4, html::el("a")->class("btn btn-mini btn-danger")->href($presenter->link("delete!", $row->id))->setHtml(html::el("i")->class("fas fa-trash-alt"))->title("Smazat"));
                return $el;
        });

        $this->localiseGrid($grid);

        return $grid;
    }

    /* FORMS */

	public function createComponentSlideForm(){
		$form = new Form(null);

		$form ->addText("name", "Název")
				->addRule(Form::FILLED, "Vyplňte název");
		$form ->addText("link", "Odkaz")
				->addRule(Form::FILLED, "Vyplňte odkaz");
		$form ->addTextarea("embed", "Iframe kód", 10, 5)
				->addRule(Form::FILLED, "Vyplňte kód");
		$form->addSubmit("submit", "Uložit video")
				->getControlPrototype()->class("btn btn-success");

		$form->onSuccess[] = [$this, 'saveSlide'];

		return $form;
	}

	public function saveSlide(Form $form){

		// security
		//$this->isAllowed(array(1,3));

		$values = $form->getValues();

		if($form->isValid()){
			try{

				if($this->editedId){
					//update existing
					$this->commonManager->updateSlide($values, $this->editedId);
				}
				else{
					//add new
					$this->editedId = $this->commonManager->addSlide($values);
				}

				$this->flashMessage("Video bylo uloženo");
				$this->redirect("default");
			}
			catch(DibiDriverException $e){
				$this->flashMessage($e->getMessage(), "error");
			}
		}
	}

	public function handleSort(array $items = null){
		if(!empty($items)){
			foreach($items as $index=>$item){
				$this->commonManager->updateSlide(array("order"=>$index+1), $item);
			}
			$this->flashMessage("Pořadí videí bylo uloženo");
			$this->redirect("this");
		}

	}


}
