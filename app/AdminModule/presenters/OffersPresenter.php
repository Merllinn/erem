<?php

namespace App\AdminModule\Presenters;

use 	TH\Form,
		Nette\Utils\Html;
use     Ublaboo\DataGrid\DataGrid;

class OffersPresenter extends BasePresenter
{
	public $editedId = false;



	public function startup(){
		parent::startup();
		$this->addBreadcrumbs("Nabídky", $this->link(":Admin:Offers:default"));

	}

	public function renderDefault(){
	}

	public function actionAdd(){
		$this->addBreadcrumbs("Přidání nabídky");
		$this->setView("addEdit");
	}

	public function actionEdit($id){
		$this->editedId = $id;
		$details = $this->commonManager->findOffer($id);
		$this["offerForm"]->setDefaults($details);
		$this->addBreadcrumbs("Editace nabídky ".$details->name);
		$this->setView("addEdit");
	}

	public function handleDelete($id){
		$this->commonManager->deleteOffer($id);
		$this->redirect("this");
	}

	public function handleDeactivate($id){
		$this->commonManager->updateOffer(array("active"=>0), $id);
		$this->redirect("this");
	}

	public function handleActivate($id){
		$this->commonManager->updateOffer(array("active"=>1), $id);
        $this->redirect("this");
	}

    /**
     * Make table of customers
     *
     * @return \Addons\Tabella
     */
    public function createComponentOffers($name)
    {
        $presenter = $this;

        $source = $this->commonManager->getOffer();

        $grid = new DataGrid($this, $name);
        $grid->setDataSource($source);

        $grid->addColumnText('name', 'Název');
        $grid->addColumnText('duration', 'Platnost');
        $grid->addColumnDateTime('expiry', 'Vyprší');
        /*
        $grid->addColumnText('role', 'Role')
            ->setRenderer(function($row) use ($presenter) {
                    return $presenter->roles[$row->role];
        });
        */

        $grid->addColumnText('active', 'Aktivní')
            ->setRenderer(function($row) use ($presenter) {
                if($row->active){
					if($this->user->identity->role==9){
                    	return Html::el("a")->href($presenter->link("deactivate!", $row->id))->setHtml(html::el("img")->src(FOLDER."/images/active.png")->class("action"));
					}
					else{
                    	return Html::el("img")->src(FOLDER."/images/active.png")->class("action");
					}
                }
                else{
					if($this->user->identity->role==9){
                    	return Html::el("a")->href($presenter->link("activate!", $row->id))->setHtml(html::el("img")->src(FOLDER."/images/deactive.png")->class("action"));
					}
					else{
                    	return Html::el("img")->src(FOLDER."/images/active.png")->class("deactive");
					}
                }
        });

		if($this->user->identity->role==9){
        $grid->addColumnText('tools', 'Nástroje')
            ->setRenderer(function($row) use ($presenter) {
                $el = Html::el("span");
                $el->insert(0, html::el("a")->class("btn btn-mini btn-light")->href($presenter->link("edit", $row->id))->setHtml(html::el("i")->class("fas fa-edit"))->title("Upravit"));
                $el->insert(1, " ");
                $el->insert(4, html::el("a")->class("btn btn-mini btn-danger")->href($presenter->link("delete!", $row->id))->setHtml(html::el("i")->class("fas fa-trash-alt"))->title("Smazat"));
                return $el;
        });
		}

        $this->localiseGrid($grid);

        return $grid;
    }

    /* FORMS */

	public function createComponentOfferForm(){
		$form = new Form(null);

		$form ->addText("name", "Název")
				->addRule(Form::FILLED, "Vyplňte název");
		$form ->addText("description", "Popis")
				->addRule(Form::FILLED, "Vyplňte popis");
		$form ->addText("duration", "Platnost");
		$form ->addText("link", "Odkaz")
				->addRule(Form::FILLED, "Vyplňte odkaz nabídky");
		$form ->addDatepicker("expiry", "Vyprší");
        /*
        $form->addSelect("role", "Role", $this->roles)
                ->setPrompt("vyberte roli")
				->addRule(Form::FILLED, "Vyberte roli")
                ->getControlPrototype()->class("form-control");
        $form->addSelect("branch", "Pobočka", $this->branchesSimple)
                ->setPrompt("bez přiřazení pobočky")
                ->getControlPrototype()->class("form-control");
		*/
		$form->addSubmit("submit", "Uložit nabídku")
				->getControlPrototype()->class("btn btn-success");

		$form->onSuccess[] = [$this, 'saveOffer'];

		return $form;
	}

	public function saveOffer(Form $form){

		// security
		//$this->isAllowed(array(1,3));

		$values = $form->getValues();

		if($form->isValid()){
			try{

				if($this->editedId){
					//update existing
					$this->commonManager->updateOffer($values, $this->editedId);
				}
				else{
					//add new
					$this->commonManager->addOffer($values);
				}

				$this->flashMessage("Nabídky byla uložena");
				$this->redirect("default");
			}
			catch(DibiDriverException $e){
				$this->flashMessage($e->getMessage(), "error");
			}
		}
	}


}
