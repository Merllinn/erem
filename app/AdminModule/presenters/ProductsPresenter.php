<?php

namespace App\AdminModule\Presenters;

use 	TH\Form,
		Nette\Utils\Html;
use     Ublaboo\DataGrid\DataGrid;

class ProductsPresenter extends BasePresenter
{
	public $edited = false;
	public $productId = false;
	public $attrId = false;
	public $pa = false;
	public $fullCats;
    public $categories;
    public $productType = 1;

	 /** @persistent */
	public $search = "";

	public $filter;

	public function startup(){
		parent::startup();
		$this->addBreadcrumbs("Produkty", $this->link(":Admin:Products:default"));
		$this->categories = $this->categoryManager->getList($this->productType);

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
			$this->flashMessage("Pořadí produktů bylo uloženo");
			$this->redirect(":Admin:Products:default", array("search"=>$search));
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
		$this->addBreadcrumbs("Přidání produktu", $this->link(":Admin:Products:add"));
	}

	public function actionPricelist(){
		$this->addBreadcrumbs("Nahrání ceníku", $this->link(":Admin:Products:pricelist"));
	}

	public function actionEdit($id){
		$details = $this->productManager->find($id);
		$details = $this->rowToArray($details);
		$cats = explode("|", $details->categories);
		$newCats = array();
		foreach($cats as $cat){
			if(!empty($cat))
				$newCats[] = (int)$cat;
		}
		$details->category = $newCats;
		if(!empty($details->availableFrom)){
			$details->fromDate = $details->availableFrom->format("d. m. Y");
			$details->fromTime = $details->availableFrom->format("H:i");
		}
		$this["productForm"]->setDefaults($details);
		$this->edited = $id;
		$this->setView("addEdit");
		$this->addBreadcrumbs("Úprava produktu ".$details->name, $this->link(":Admin:Products:edit", $id));
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
				$details[$prRow->attributeValue]["used"] = $prRow->type;
				$details[$prRow->attributeValue]["text"] = $prRow->text;
				for($i=1;$i<=$this->zones;$i++){
					$key = "price".$i;
					$details[$prRow->attributeValue][$i] = $prRow->$key;
				}
				for($i=1;$i<=$this->zones;$i++){
					$key = "price".$i."Old";
					$details[$prRow->attributeValue]["old".$i] = $prRow->$key;
				}
			}
		}
		$this["productPriceForm"]->setDefaults($details);
		$this->addBreadcrumbs("Správa cen produktu ".$this->template->details->name, $this->link(":Admin:Products:prices", $id));
	}

	public function actionDelete($id){
		try{
			$this->productManager->delete($id);
			$this->flashMessage("Produkt byl smazán");
			$this->redirect(":Admin:Products:default");
		}
		catch(DibiDriverException $e){
			$this->flashMessage($e->getMessage());
		}
	}

	public function createComponentProductForm(){
		$form = new Form();
		
		$productAttributes = $this->attributeManager->getForCont(1);

		$form->addGroup("Základní údaje");
		//$form ->addHidden("id");
		$form ->addText("name", "Jméno")
				->addRule(Form::FILLED, "Vyplňte jméno produktu");
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
        $form ->addMultiSelect("category", "Kategorie", $this->categories)
				->addRule(Form::FILLED, "Vyberte kategorii")
				//->setPrompt("Vyberte kategorie")
				;
		$form->addGroup("Cena");
		$form ->addText("price", "Základní cena");
		$form ->addText("expense", "Náklady");
		$form ->addText("sale", "Sleva [%]");
		
		$form->addGroup("Dostupnost");
		$form ->addText("amount", "Množství skladem");
		$form ->addDatepicker("fromDate", "Dostupné od (datum)")
			->getControlPrototype()->class("form-control date");
		$form ->addText("fromTime", "Dostupné od (čas)")
			->getControlPrototype()->placeholder("00:00");
		//$form->addCheckbox("turbo", "Turbokontejner");
		//$form->addCheckbox("noOnlineOrder", "Nelze objednat online");
        /*
        $form ->addTextArea("technical", "Technická specifikace")
				->getControlPrototype()
					->class("wysiwyg");
		$form->addGroup("SEO");
		$form ->addText("alias", "Alias");
		$form ->addTextArea("seo_description", "SEO description");
		$form ->addText("seo_keywords", "SEO keywords");
        */

		/*
		$form->addGroup("Atributy");
		$attributes = $form->addContainer("attributes");
		foreach($productAttributes as $pa){
			$paValues = $this->attributeManager->getValuesArr($pa->id);
			$attrName = $pa->name;
			if(!empty($pa->unit)){
				$attrName.=" [".strip_tags($pa->unit)."]";
			}
			$attributes->addSelect($pa->id, $attrName, $paValues);
		}
		*/

		$form->addGroup("SEO (pro vyhledávače)");
		$form ->addText("alias", "Alias (do adresy)");
		$form ->addText("title", "Titulek stránky");
		$form ->addTextArea("seo_description", "SEO popis");

		$form->addGroup(NULL);
		$form->addSubmit("submit", "Uložit produkt")->getControlPrototype()->class("btn btn-primary");

		$form->onSuccess[] = [$this, 'saveProduct'];

		return $form;
	}


	public function saveProduct(Form $form){
		$values = $form->getValues();

		if($form->isValid()){
			try{
				$categories = $values->category;
				unset($values->category);
				$categoriesString = implode("|", $categories);
				$values->categories = "|".$categoriesString."|";
				$values->price = (float)$values->price;
				$values->expense = (float)$values->expense;
				$values->sale = (float)$values->sale;
				$values->amount = (float)$values->amount;
				if(empty($values->title)){
					$values->title = $values->name;
				}
				if(!empty($values->fromDate)){
					$startDate = $values->fromDate;
					if(!empty($values->fromTime)){
						$times = explode(":", $values->fromTime);
						$startDate->setTime($times[0], $times[1]);
					}
					else{
						$startDate->setTime(0,0);
					}
				}
				else{
					$startDate = null;
				}
				$values->availableFrom = $startDate;
				unset($values->fromDate);
				unset($values->fromTime);
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
				$this->redirect(":Admin:Products:default");


			}
			catch(DibiDriverException $e){
				$this->flashMessage($e->getMessage(), "error");
			}
		}
	}

	public function createComponentProductPriceForm(){
		$form = new Form();
		
		$productAttributes = $this->attributeManager->getForCont(2);

		foreach($productAttributes as $pa){
			$paValues = $this->attributeManager->getValuesArr($pa->id);
			foreach($paValues as $paValId=>$paValVal){
				$form->addGroup($pa->name." - ".$paValVal);
				$container = $form->addContainer($paValId);
				$container->addRadioList("used", "", array("" =>"Nepoužívá se", "1"=>"Ceny", "2"=>"Text"))->getControlPrototype()->class("isUsed");
				for($i=1;$i<=$this->zones;$i++){
					$container->addText("old".$i, "Zóna ".$i." [Kč] původní");
				}
				$container->addText("text", "Text")->getControlPrototype()->class("priceText");
				for($i=1;$i<=$this->zones;$i++){
					$container->addText($i, "Zóna ".$i." [Kč]");
				}
			}
		}

		$form->addGroup(NULL);
		$form->addSubmit("submit", "Uložit ceny")->getControlPrototype()->class("btn btn-primary");

		$form->onSuccess[] = [$this, 'saveProductPrices'];

		$renderer = $form->getRenderer();
		$renderer->wrappers['controls']['container'] = 'div class=row';
		$renderer->wrappers['pair']['container'] = 'div class=col-1';

		return $form;
	}


	public function saveProductPrices(Form $form){
		$values = $form->getValues();

		if($form->isValid()){
			try{
				$this->productManager->deletePrices($this->edited);
				$productAttributes = $this->attributeManager->getForCont(2);
				foreach($productAttributes as $pa){
					$paValues = $this->attributeManager->getValuesArr($pa->id);
					foreach($paValues as $paValId=>$paValVal){
						$prices = $values->$paValId;
						if($prices["used"]){
							$minPrice = 999999;
							$maxPrice = 000000;
							$priceOld = 0;
							$dataPrices = array(
								"product" => $this->edited,
								"attributeValue" => $paValId,
								"type" => $prices["used"],
							);
							if($prices["used"]==1){
								for($i=1;$i<=$this->zones;$i++){
									if($prices[$i]>0){
										$newPrice = str_replace(" ", "", $prices[$i]);
										$dataPrices["price".$i] = $newPrice;
										$minPrice = min($minPrice, $newPrice);
										$maxPrice = max($maxPrice, $newPrice);
									}
									if($prices["old".$i]>0){
										$newPrice = str_replace(" ", "", $prices["old".$i]);
										$dataPrices["price".$i."Old"] = $newPrice;
										$priceOld = max($priceOld, $newPrice);
									}
								}
								$dataPrices["priceFrom"] = $minPrice;
								$dataPrices["priceTo"] = $maxPrice;
								$dataPrices["priceOld"] = $priceOld;
							}
							if($prices["used"]==2){
								$dataPrices["text"] = $prices["text"];
							}
							$this->productManager->savePrices($dataPrices);
						}
					}

				}
				
				
				$this->flashMessage("Ceny produktu byly uloženy.");
				$this->redirect(":Admin:Products:default");


			}
			catch(DibiDriverException $e){
				$this->flashMessage($e->getMessage(), "error");
			}
		}
	}

	/** Create product form
	*
	* @return Form
	*/
	/*
	public function createComponentAttributeValuesForm(){
		$form = new Form();

		$values = $this->models->attributes->fetchValuesPairs($this->attrId);

		$form->addSubmit("submit", "Uložit hodnoty")->getControlPrototype()->class("btn btn-primary");

		$form->onSuccess[] = [$this, 'saveAttrValues'];

		return $form;
	}

	public function saveAttrValues(Form $form){
	   $httpRequest = $this->getService('httpRequest');
	   $checkboxes = $httpRequest->getPost("value");
	   $prices = $httpRequest->getPost("price");
	   $values = $this->productManager->getProductAttributeValues($this->pa);
	   foreach($checkboxes as $av=>$value){
		   if($value="on"){
			   if(empty($prices[$av]))
			   	$prices[$av] = null;
			   if(empty($values[$av])){
			   	//add
				   $data = array(
			   			"products_attribute_id"	=>$this->pa,
			   			"attribute_value_id"	=>$av,
			   			"price"					=>$prices[$av]
				   );
			   	$this->productManager->addAttributeValue($data);

			   }
			   else{
			   	//update
				   $data = array(
			   			"price"					=>$prices[$av]
				   );
			   	$this->productManager->updateAttributeValue($data, $values[$av]);
			   	unset($values[$av]);
			   }
		   }
	   }
	   //delete removed values
	   foreach($values as $value){
		   $this->productManager->deleteAttributeValue($value);
	   }
	   $this->flashMessage("Hodnoty parametrů byly aktualizovány", "success");
	   $this->redirect("this");
	}
	*/


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
        
        //$grid->addColumnText('perex', 'Podnázev');

        $grid->addColumnText('price', 'Cena');
        
        $grid->addColumnText('expense', 'Náklady');
        
        $grid->addColumnText('amount', 'Skladem');

        $grid->addColumnText("category","Kategorie")
        ->setRenderer(function($row) use ($presenter) {
            if($row->categories){
            	$cats = explode("|", trim($row->categories, "|"));
            	$ret = "";
            	foreach($cats as $cat){
					$ret .= $this->categories[$cat].Html::el("br");
            	}
                return Html::el("span")->insert(0, $ret);
            }
            else{
            	return "";
            }
		});

        // add columns
        $grid->addColumnText("alias", "Alias");

        /*
        $grid->addColumnText('turbo', 'Turbokontejner')
            ->setRenderer(function($row) use ($presenter) {
                if($row->turbo){
                	return "ano";
                }
                else{
                	return "ne";
                }
        });
        */

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

        $grid->addColumnText('onHome', 'Na hlavní')
            ->setRenderer(function($row) use ($presenter) {
                $el = Html::el("span");
                if($row->onHome){
                	$el->insert(0, Html::el("a")->class("tabella_ajax")->href($presenter->link("setHome!", $row->id, 0))->setHtml(html::el("img")->src(FOLDER."/images/active.png")->class("action")));
                	$el->insert(1, Html::el("a")->class("tabella_ajax")->style("display: none;")->href($presenter->link("setHome!", $row->id))->setHtml(html::el("img")->src(FOLDER."/images/deactive.png")->class("action")));
                }
                else{
                	$el->insert(0, Html::el("a")->class("tabella_ajax")->style("display: none;")->href($presenter->link("setHome!", $row->id, 0))->setHtml(html::el("img")->src(FOLDER."/images/active.png")->class("action")));
                	$el->insert(1, Html::el("a")->class("tabella_ajax")->href($presenter->link("setHome!", $row->id))->setHtml(html::el("img")->src(FOLDER."/images/deactive.png")->class("action")));
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
                $el->insert(2, html::el("a")->class("btn btn-mini")->href($presenter->link(":Admin:Products:edit", $row->id))->setHtml(html::el("i")->class("fas fa-edit"))->title(" Upravit"));
                $el->insert(3, " ");
                $el->insert(4, html::el("a")->class("btn btn-mini btn-info")->href($presenter->link(":Admin:Products:prices", $row->id))->setHtml(html::el("i")->class("fas fa-dollar-sign"))->title(" Ceny"));
                $el->insert(5, " ");
                $el->insert(6, html::el("a")->class("btn btn-mini btn-danger")->href($presenter->link(":Admin:Products:delete", $row->id))->setHtml(html::el("i")->class("fas fa-trash-alt"))->setHtml(html::el("i")->class("fas fa-trash-alt"))->title("Smazat"));
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

	public function handleSetHome($id, $v=true){
		try{
			$this->productManager->update(array("onHome"=>$v), $id);
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



	public function createComponentPricelistForm(){
		$form = new Form();

		$form->getElementPrototype()->class("form-inline");

		$form->addCheckbox("showPricelist", "Zobrazit v menu");

		$form->addUpload("pricelistFile", "Nahrát nový ceník");
		
		$form->addSubmit("submit", "Uložit")->getControlPrototype()->class("btn btn-primary");

		$form->setDefaults($this->settings);

		$form->onSuccess[] = [$this, 'savePricelist'];

		return $form;
	}

	/** callback for seo form
	*
	* @param Form data from page form
	* @return void
	*/
	public function savePricelist(Form $form, $values){
		if($form->isValid()){
			try{
				$img = $values->pricelistFile;
				unset($values->pricelistFile);

				$this->commonManager->saveSettings($values);
				
				//upload image
	            if (!empty($img) && $img->isOk()) {
            		$image = $img;
					$ext = pathinfo($img->getSanitizedName(), PATHINFO_EXTENSION);
					$name = "cenik-".date("YmdHi");
					$fileName = $name.".".$ext;
					$origFile = BASE_DIR."/data/original/".$fileName;
					$image->move($origFile);

    				$this->commonManager->saveSettings(array("pricelistFile"=>$fileName));

	            }

				$this->flashMessage("Ceník byl uložen.");
				$this->redirect("this");


			}
			catch(DibiDriverException $e){
				$this->flashMessage($e->getMessage(), "error");
			}
		}
	}




}
