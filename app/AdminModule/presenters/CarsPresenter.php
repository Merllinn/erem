<?php

namespace App\AdminModule\Presenters;

use 	TH\Form,
		Nette\Utils\Html;
use     Ublaboo\DataGrid\DataGrid;

class CarsPresenter extends BasePresenter
{
	public $edited = false;
	public $productId = false;
	public $attrId = false;
	public $pa = false;
	public $fullCats;
    public $categories;
    public $productType = 3;

	 /** @persistent */
	public $search = "";

	public $filter;

	public function startup(){
		parent::startup();
		$this->addBreadcrumbs("Vozidla", $this->link(":Admin:Cars:default"));
		$this->categories = $this->categoryManager->getActiveList($this->productType);

		if(!isset($this->filter)){
			$this->filter = $this->getSession("productsFilter");
		}

	}

	public function actionDefault($search="", array $items = null){
		$this->search = $search;
	}
	public function renderDefault($search="", array $items = null){
		if(!empty($items)){
			foreach($items as $index=>$item){
				$this->productManager->update(array("order"=>$index+1), $item);
			}
			$this->flashMessage("Pořadí vozidel bylo uloženo");
			$this->redirect(":Admin:Cars:default", array("search"=>$search));
		}

	}



	/*
	public function renderAttributes($id){
		$this->productId = $id;
		$this->template->product = $pageDetails = $this->productManager->getOne($id);

	}

	public function actionEditAttributeValues($id, $attrId, $pa){
		$this->productId = $id;
		$this->attrId = $attrId;
		$this->pa = $pa;
		$this->template->product = $pageDetails = $this->productManager->getOne($id);
		$this->template->attribute = $attibute = $this->productManager->getProductAttribute($id, $attrId);
		$this->template->values = $this->models->attributes->fetchValues($attrId, $pa);
	}
	*/

	public function actionAdd(){
		$this->setView("addEdit");
		$this->addBreadcrumbs("Přidání vozidla", $this->link(":Admin:Cars:add"));
	}

	public function actionEdit($id){
		$details = $this->productManager->find($id);
		$details = $this->rowToArray($details);
		$attributes = explode("|", $details->attributes);
		$prodAttribs = array();
		foreach($attributes as $attr){
			if(!empty($attr)){
				list($attrId, $attrVal) = explode("-", $attr);
				$prodAttribs[$attrId] = $attrVal;
			}
		}
		$details->category = array();
		foreach(explode("|", $details->categories) as $cat){
			if(!empty($cat)){
				$details->category[] = (int)$cat;
			}
		}
		$details->attributes = $prodAttribs;
		$this["productForm"]->setDefaults($details);
		$this->edited = $id;
		$this->setView("addEdit");
		$this->addBreadcrumbs("Úprava vozidla ".$details->name, $this->link(":Admin:Cars:edit", $id));
	}

	public function actionPrices($id){
		$this->template->details = $this->productManager->find($id);
		$this->edited = $id;
		$prices = $this->productManager->getPrices($id);
		$details = array();
		if($prices){
			foreach($prices as $prRow){
				if(empty($details[$prRow->attributeValue])){
					$details[$prRow->attributeValue] = array();
				}
				$details[$prRow->attributeValue]["koef"] = $prRow->koef;
				$details[$prRow->attributeValue]["used"] = $prRow->type;
				$details[$prRow->attributeValue]["text"] = $prRow->text;
				$details[$prRow->attributeValue]["priceFrom"] = $prRow->priceFrom;
				$details[$prRow->attributeValue]["priceTo"] = $prRow->priceTo;
			}
		}
		$this["productPriceForm"]->setDefaults($details);
		$this->addBreadcrumbs("Správa cen materiálu ".$this->template->details->name, $this->link(":Admin:Cars:prices", $id));
	}

	public function actionDelete($id){
		try{
			$this->productManager->delete($id);
			$this->flashMessage("Vozidlo bylo smazáno");
			$this->redirect(":Admin:Cars:default");
		}
		catch(DibiDriverException $e){
			$this->flashMessage($e->getMessage());
		}
	}

	public function createComponentProductForm(){
		$form = new Form();
		
		$productAttributes = $this->attributeManager->getForMaterial(1);

		$form->addGroup("Základní údaje");
		//$form ->addHidden("id");
		$form ->addText("name", "Název")
				->addRule(Form::FILLED, "Vyplňte název vozidla");
		$form ->addText("perex", "Podnázev");
		$form ->addTextArea("description", "Popis")
				->getControlPrototype()
					->class("wysiwyg");
		/*
		$form ->addText("width", "Šířka [m]")
				->addRule(Form::FILLED, "Vyplňte šířku");
		$form ->addText("length", "Délka [m]")
				->addRule(Form::FILLED, "Vyplňte dělku");
		$form ->addText("height", "Výška [m]")
				->addRule(Form::FILLED, "Vyplňte výšku");
		*/
        $form ->addMultiSelect("category", "Kategorie", $this->categories);
				//->addRule(Form::FILLED, "Vyberte kategorii")
				//->setPrompt("Vyberte kategorie")
				;
        /*
        $form ->addTextArea("technical", "Technická specifikace")
				->getControlPrototype()
					->class("wysiwyg");
		$form->addGroup("SEO");
		$form ->addText("alias", "Alias");
		$form ->addTextArea("seo_description", "SEO description");
		$form ->addText("seo_keywords", "SEO keywords");
        */

		$form->addGroup(NULL);
		$form->addSubmit("submit", "Uložit vozidlo")->getControlPrototype()->class("btn btn-primary");

		$form->onSuccess[] = [$this, 'saveProduct'];

		return $form;
	}


	public function saveProduct(Form $form){
		$values = $form->getValues();

		if($form->isValid()){
			try{
				$attrs = array();
				$categories = $values->category;
				unset($values->category);
				$categoriesString = implode("|", $categories);
				$values->categories = "|".$categoriesString."|";
				if(empty($values->title)){
					$values->title = $values->name;
				}
				if($this->edited){
					$this->productManager->update($values, $this->edited);
				}
				else{
					if(empty($values->alias)){
						$values->alias = $this->makeAlias("products", $values->name, $this->edited);
					}
					$values->created = new \nette\utils\DateTime();
                    //$values->vat_id = 1;
					$values->type = $this->productType;
					$id = $this->productManager->add($values);

				}
				$this->flashMessage("Produkt byl uložen.");
				$this->redirect(":Admin:Cars:default");


			}
			catch(DibiDriverException $e){
				$this->flashMessage($e->getMessage(), "error");
			}
		}
	}


    /**
     * Make table of products
     *
     * @return \Addons\Tabella
     */
    public function createComponentProducts($name)
    {
        $presenter = $this;

        $source = $this->productManager->fetchDS($this->productType, $this->filter);

        //$this->fullCats = $this->models->categories->fetchFullInfo();

        $grid = new DataGrid($this, $name);
        //if(!empty($this->filter->category)){
            $source->order("order");
        //}
        $grid->setDataSource($source);


        $grid->addColumnText('img', 'Obrázek')
            ->setRenderer(function($row) use ($presenter) {
                $photo = $presenter->productManager->getMainPhoto($row->id);
                if($photo){
                        return html::el("img")->src($presenter->thumb($photo, 150, null));
                    }
                    else{
                        return "";
                    }
        });
        $grid->addColumnText('name', 'Název');
        
        $grid->addColumnText('perex', 'Podnázev');
        
        $grid->addColumnText("category","Kategorie")
        ->setRenderer(function($row) use ($presenter) {
            if($row->categories){
            	$cats = explode("|", trim($row->categories, "|"));
            	$ret = "";
            	foreach($cats as $cat){
            		if(!empty($cat)){
						$ret .= $this->categories[$cat].Html::el("br");
            		}
            	}
                return Html::el("span")->insert(0, $ret);
            }
            else{
            	return "";
            }
		});

        // add columns

        $grid->addColumnText('active', 'Aktivní')
            ->setRenderer(function($row) use ($presenter) {
                $el = Html::el("span");
                if($row->active){
                	$el->insert(0, Html::el("a")->class("tabella_ajax")->href($presenter->link("deactivate!", $row->id))->setHtml(html::el("img")->src(FOLDER."/images/active.png")->class("action")));
                	$el->insert(1, Html::el("a")->class("tabella_ajax")->style("display: none;")->href($presenter->link("activate!", $row->id))->setHtml(html::el("img")->src(FOLDER."/images/deactive.png")->class("action")));
                }
                else{
                	$el->insert(0, Html::el("a")->class("tabella_ajax")->style("display: none;")->href($presenter->link("deactivate!", $row->id))->setHtml(html::el("img")->src(FOLDER."/images/active.png")->class("action")));
                	$el->insert(1, Html::el("a")->class("tabella_ajax")->href($presenter->link("activate!", $row->id))->setHtml(html::el("img")->src(FOLDER."/images/deactive.png")->class("action")));
                }
                return $el;
        });

		if($this->user->identity->role==9){
        $grid->addColumnText('tools', 'Nástroje')
            ->setRenderer(function($row) use ($presenter) {
                $photos = $presenter->productManager->countPhotos($row->id);
                $el = Html::el("span");
                $el->insert(0, html::el("a")->class("btn btn-mini btn-primary")->href($presenter->link(":Admin:ProductGallery:default", $row->id))->setHtml(html::el("i")->class("fas fa-images")." ".$photos->count)->title(" Galerie"));
                $el->insert(1, " ");
                $el->insert(2, html::el("a")->class("btn btn-mini")->href($presenter->link(":Admin:Cars:edit", $row->id))->setHtml(html::el("i")->class("fas fa-edit"))->title(" Upravit"));
                $el->insert(3, " ");
                $el->insert(6, html::el("a")->class("btn btn-mini btn-danger")->href($presenter->link(":Admin:Cars:delete", $row->id))->setHtml(html::el("i")->class("fas fa-trash-alt"))->setHtml(html::el("i")->class("fas fa-trash-alt"))->title("Smazat"));
                return $el;
        });
		}

        $this->localiseGrid($grid);

        return $grid;

    }


	public function handleActivate($id){
		try{
			$this->productManager->update(array("active"=>1), $id);
			//$this->redirect("this");
		}
		catch(DibiDriverException $e){
			$this->flashMessage($e->getMessage());
		}
	}

	public function handleDeactivate($id){
		try{
			$this->productManager->update(array("active"=>0), $id);
            //$this->redirect("this");
		}
		catch(DibiDriverException $e){
			$this->flashMessage($e->getMessage());
		}
	}

	public function createComponentFilterForm(){
		$form = new Form();

		$form->getElementPrototype()->class("form-inline");

		$form->addText("fulltext")
			->getControlPrototype()->class("form-control")->placeholder("hledaný výraz");

        $form->addSelect("active", "", array("1"=>"pouze aktivní","9"=>"pouze neaktivní"))
            ->setPrompt(" - aktivní i neaktivní - ")
            ->getControlPrototype()->class("form-control");

		//$form->addCheckbox("noPhoto", "bez fotky")->setDefaultValue(false);

		$form->addSubmit("submit", "Filtruj")->getControlPrototype()->class("btn btn-primary");
		$form->addSubmit("reset", "Zobraz vše")->getControlPrototype()->class("btn btn-light");

		$form->setDefaults($this->filter);

		$form->onSuccess[] = [$this, 'filter'];

		return $form;
	}

	/** callback for seo form
	*
	* @param Form data from page form
	* @return void
	*/
	public function filter(Form $form){
		$values = $form->getValues();

		if($form["reset"]->isSubmittedBy()){
            $this->filter->fulltext = null;
			$this->filter->active = null;
			//$this->filter->noPhoto = false;
			$this->redirect("this");
		}
		else{
            $this->filter->fulltext = $values->fulltext;
			$this->filter->active = $values->active;
			//$this->filter->noPhoto = $values->noPhoto;
			$this->redirect("this");
		}
	}

    public function handleSort(array $items){
        foreach($items as $index=>$item){
            $this->productManager->update(array("order"=>$index+1), $item);
        }
        $this->flashMessage("Pořadí produktů bylo uloženo");
        $this->redirect("this");
    }



}
