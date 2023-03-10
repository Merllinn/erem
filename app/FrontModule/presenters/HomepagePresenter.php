<?php

namespace App\FrontModule\Presenters;

use \TH\Form;
use \Nette\Mail\Message;
use Nette\Mail\SendmailMailer;
use Nette\Utils\Html;
use Nette\Http\Response;

final class HomepagePresenter extends HomepageForms
{
    
    public function actionProduct($id){
    	$this->template->product = $product = $this->productManager->findByAlias($id);
    	/*
    	$this->template->attVals = $this->attributeManager->getAllValues();
    	$this->template->paVals = $this->getProductAttributeValues($container->attributes);
    	*/
    	$this->template->mainImg = $this->productManager->getMainPhoto($product->id);
    	$this->template->images = $this->productManager->getSidePhotos($product->id);
	    $this->template->title = $product->title;
	    $this->template->description = $product->seo_description;
	}
	
    public function renderProducts($cat = ""){
    	if(empty($cat)){
    		$this->template->products = $this->productManager->getActive();
			
    	}
    	else{
    		$this->template->activeCat = $catDetails = $this->categoryManager->findByAlias($cat);
    		$this->template->products = $this->productManager->findByCategory($catDetails->id);
    	}
	}
	
    public function actionApprove($id, $branch=1){
    	$this->orderManager->update(array("branch"=>$branch), $id);
		$this->approveOrder($id);
        $this->redirect(":Front:Homepage:page", "");
	}
	
	public function renderSubpages(){
		$this->template->subpages = $this->pageManager->getInSubpagesByParent($this->template->page->id);
	}

	public function renderHomepage(){
		$this->template->products = $this->productManager->findForHomepage();
	}

	public function renderTrashTypes(){
		$this->template->subpagesYes = $this->pageManager->getInSubpagesByParent($this->template->page->id)->where("liquidate = ?", true);
		$this->template->subpagesNo = $this->pageManager->getInSubpagesByParent($this->template->page->id)->where("liquidate = ?", false);
	}

	public function renderFaq(){
		$this->template->subpages = $this->pageManager->getInSubpagesByParent($this->template->page->id);
	}

	public function renderSubpagesText(){
		$this->template->bodyClassPage = "page";
		$this->template->subpages = $this->pageManager->getInSubpagesByParent($this->template->page->id);
	}

	public function renderSubpagesText2(){
		$this->template->bodyClassPage = "page";
		$this->template->subpages = $this->pageManager->getInSubpagesByParent($this->template->page->id);
	}

	public function renderExcavation(){
		$this->template->subpages = $this->pageManager->getInSubpagesByParent($this->template->page->id);
		$this["orderForm"]["type"]->setValue(8);
		$this["orderForm"]["usertype"]->setValue(1);
	}

	public function renderBlackDump(){
		$this->template->subpages = $this->pageManager->getInSubpagesByParent($this->template->page->id);
		$this["orderForm"]["type"]->setValue(7);
		$this["orderForm"]["usertype"]->setValue(1);
	}

    public function renderMap(){
		$this->template->basket = $this->basketMap;
		$this->template->address = $this->basketMap->address;
		$this->template->zones = $this->commonManager->getActiveZones();
	}
	
    public function renderPartners(){
		$this->template->basket = $this->basketMap;
		$this->template->address = $this->basketMap->address;
		$this->template->zones = $this->commonManager->getActiveZones();
	}
	
    public function renderOrder(){
		$this->template->basket = $this->basket;
		$this->template->address = $this->basket->address;

		$containers = $this->basket->containers;
		if(count($containers)==0){
			$container = new \Nette\Utils\ArrayHash();
			$container->amount = 1;
			$containers[] = $container;
			$this->basket->containers = $containers;
			$this->recalculateBasket("basket");
		}

		$this->template->containers = $this->basket->containers;
		$this->template->materials = $this->basket->materials;
		$this->template->attVals = $this->attributeManager->getAllValues();
		$this->template->zones = $this->commonManager->getActiveZones();
        if(!empty($this->basket->order)){
        	$this["orderForm"]->setDefaults($this->basket->order);
		}
		$this["orderForm"]["type"]->setValue("1");
	}

	public function renderOrder3(){
		$this->template->basket = $this->basket;
		$this->template->address = $this->basket->address;

		$containers = $this->basket->containers;
		if(count($containers)==0){
			$container = new \Nette\Utils\ArrayHash();
			$container->amount = 1;
			$containers[] = $container;
			$this->basket->containers = $containers;
			$this->recalculateBasket("basket");
		}

		$this->template->containers = $this->basket->containers;
		$this->template->materials = $this->basket->materials;
		$this->template->attVals = $this->attributeManager->getAllValues();
		$this->template->zones = $this->commonManager->getActiveZones();
        if(!empty($this->basket->order)){
        	$this["orderForm"]->setDefaults($this->basket->order);
		}
		$this["orderForm"]["type"]->setValue("1");
	}
	
    public function renderOrderMaterial(){
		$this->template->basket = $this->basketM;
		$this->template->address = $this->basketM->address;
		$this->template->containers = $this->basketM->containers;
		$this->template->materials = $this->basketM->materials;
		$this->template->attVals = $this->attributeManager->getAllValues();
		$this->template->zones = $this->commonManager->getActiveZones();
        if(!empty($this->basketM->order)){
        	$this["orderForm"]->setDefaults($this->basketM->order);
		}
		$this["orderForm"]["type"]->setValue("2");
	}
	
    public function renderDemand(){
		$this->template->basket = $this->basketD;
		$this->template->address = $this->basketD->address;
		$this->template->containers = $this->basketD->containers;
		$this->template->materials = $this->basketD->materials;
		$this->template->attVals = $this->attributeManager->getAllValues();
		$this->template->zones = $this->commonManager->getActiveZones();
        if(!empty($this->basketD->order)){
        	$this["orderForm"]->setDefaults($this->basketD->order);
		}
		$this["orderForm"]["type"]->setValue("9");
	}
	
    public function renderDemandMaterial(){
		$this->template->basket = $this->basketD;
		$this->template->address = $this->basketD->address;
		$this->template->containers = $this->basketD->containers;
		$this->template->materials = $this->basketD->materials;
		$this->template->attVals = $this->attributeManager->getAllValues();
		$this->template->zones = $this->commonManager->getActiveZones();
        if(!empty($this->basketD->order)){
        	$this["orderForm"]->setDefaults($this->basketD->order);
		}
		$this["orderForm"]["type"]->setValue("9");
	}
	
	public function renderPersons(){
		$this->template->persons = $this->userManager->getActivePersons();
	}
	
	public function handleAddNextContainer($basket="basket"){
		$containers = $this->$basket->containers;
		$container = new \Nette\Utils\ArrayHash();
		$container->amount = 1;
		$containers[] = $container;
		$this->$basket->containers = $containers;
		$this->recalculateBasket($basket);
		$this->redrawControl("orderContainers");
		$this->redrawControl("addmaterial");
		$this->redrawControl("materialterm");
		//$this->redirect("this");
	}

	public function handleSetMaterial($mat, $basket="basket"){
		$materials = $this->$basket->materials;
		if(empty($materials[0]) || $materials[0]->product != $mat){
			$material = new \Nette\Utils\ArrayHash();
			$material->product = $mat;
			$materials[0] = $material;
			$this->$basket->materials = $materials;
			$this->recalculateBasket($basket);
		}
		$this->redrawControl("matamount");
		$this->redrawControl("orderContainers");
		$this->redrawControl("materialterm");
		//$this->redirect("this");
	}

	public function handleUnuseMaterial($basket="basketD"){
		$this->$basket->materials = array();
		$this->recalculateBasket($basket);
		$this->redrawControl("matamount");
		$this->redrawControl("materialterm");
		//$this->redirect("this");
	}

	public function handleUnuseContainers($basket="basketM"){
		$this->$basket->containers = array();
		$this->recalculateBasket($basket);
		$this->redrawControl("orderContainers");
		//$this->redirect("this");
	}

	public function handleSetMaterialVariant($var, $basket="basket"){
		$materials = $this->$basket->materials;
		$material = $materials[0];
		$material->price = $var;
		$priceObj = $this->productManager->findPrice($var);
		$material->priceObj = $this->rowToArray($priceObj);
		$material->amount = 1;
		unset($material->stone);
		unset($material->consistence);
		/*
		if($material->product==$this->settings->betonProduct){
			$material->amount = 1/$priceObj->koef;
		}
		else{
		}
		*/
		$materials[0] = $material;
		$this->$basket->materials = $materials;
		$this->recalculateBasket($basket);
		$this->redrawControl("matamount");
		$this->redrawControl("orderContainers");
		$this->redrawControl("materialterm");
		//$this->redirect("this");
	}
	public function handleSetMaterialVariantD($var, $basket="basketD"){
		$priceObj = $this->rowToArray($this->productManager->findPrice($var));
		$materials = $this->$basket->materials;
		if(!isset($materials[$priceObj->product])){
			$materials[$priceObj->product] = array();
		}
		$material = $materials[$priceObj->product];
		if(!isset($material[$var])){
			$material[$var] = new \Nette\Utils\ArrayHash();
		}
		$variant = $material[$var];
		$variant->priceObj = $priceObj;
		$variant->amount = 1;
		$material[$var] = $variant;
		$materials[$priceObj->product] = $material;
		$this->$basket->materials = $materials;
		$this->recalculateBasket($basket);
		//$this->redrawControl("matamount");
		//$this->redirect("this");
	}
	public function handleUnsetMaterialVariantD($var, $basket="basketD"){
		$priceObj = $this->rowToArray($this->productManager->findPrice($var));
		$materials = $this->$basket->materials;
		if(!isset($materials[$priceObj->product])){
			$materials[$priceObj->product] = array();
		}
		$material = $materials[$priceObj->product];
		if(isset($material[$var])){
			unset($material[$var]);
		}
		if(empty($material)){
			unset($materials[$priceObj->product]);
		}
		else{
			$materials[$priceObj->product] = $material;
		}
		$this->$basket->materials = $materials;
		$this->recalculateBasket($basket);
		//$this->redrawControl("matamount");
		//$this->redirect("this");
	}
	public function handleSetMaterialAmount($basket="basket", $amount){
		$materials = $this->$basket->materials;
		if(!empty($materials[0])){
			$material = $materials[0];
			$material->amount = $amount;
			$materials[0] = $material;
			$this->$basket->materials = $materials;
		}
		if($basket=="basketM" && $amount>6 && !empty($this->$basket->containers[0]->product) && $this->$basket->containers[0]->product != $this->settings->bigContainer){
			$this->$basket->containers[0]->product = null;
			$this->$basket->containers[0]->price = null;
			$this->$basket->containers[0]->priceObj = null;
		}
		$this->recalculateBasket($basket);
		$this->redrawControl("orderContainers");
		$this->redrawControl("materialterm");
		//$this->redirect("this");
	}
	public function handleSetMaterialVal($index, $basket="basket", $name, $val){
		$materials = $this->$basket->materials;
		if(!empty($materials[$index])){
			$material = $materials[$index];
			$material->$name = $val;
			$materials[$index] = $material;
			$this->$basket->materials = $materials;
		}
		//$this->redirect("this");
	}
	public function handleSetMaterialsVal($index, $priceId, $basket="basket", $name, $val){
		$materials = $this->$basket->materials;
		if(!empty($materials[$index][$priceId])){
			$material = $materials[$index][$priceId];
			$material->$name = $val;
			$materials[$index][$priceId] = $material;
			$this->$basket->materials = $materials;
		}
		//$this->redirect("this");
	}
	public function handleSetMaterialAmountD($product, $variant, $amount){
		$materials = $this->basketD->materials;
		if(!empty($materials[$product][$variant])){
			$var = $materials[$product][$variant];
			$var->amount = $amount;
			$materials[$product][$variant] = $var;
			$this->basketD->materials = $materials;
		}
		$this->recalculateBasket("basketD");
		//$this->redirect("this");
	}
	public function handleSetMaterialAmountM($product, $variant, $amount){
		$materials = $this->basketM->materials;
		if(!empty($materials[$product][$variant])){
			$var = $materials[$product][$variant];
			$var->amount = $amount;
			$materials[$product][$variant] = $var;
			$this->basketM->materials = $materials;
		}
		$this->recalculateBasket("basketM");
		$this->redrawControl("orderContainers");
		//$this->redirect("this");
	}
	public function handleSetAddress($basket="basket", $a, $ll){
		$this->$basket->address = $a;
		$this->$basket->location = $ll;
		$this->redrawControl("deliveryTerm");
		//$this->template->basket = $this->$basket;
		$this->recalculateBasket($basket);
		//$this->redirect("this");
	}
    public function handleSetBasketZone($basket="basket", $z){
		$this->$basket->zone = $z;
		$zoneObj = $this->commonManager->findZone($z);
		if($zoneObj){
			$this->$basket->zoneObj = $this->rowToArray($zoneObj);
		}
		$this->redrawControl("orderContainers");
		$this->redrawControl("realizationterm");
		$this->redrawControl("deliveryTerm");
		$this->recalculateBasket($basket);
    }
    
    public function handleSetBasketNote($basket="basket", $val){
		$this->$basket->description = $val;
    }

	public function handleRemoveFromOrder($index, $basket="basket"){
		$containers = $this->$basket->containers;
		unset($containers[$index]);
		$this->$basket->containers = $containers;
		if(count($containers)==0 && $basket=="basket"){
			$this->$basket->materials = null;
			$this->redrawControl("addmaterial");
		}
		$this->recalculateBasket($basket);
		$this->redrawControl("orderContainers");
		$this->redrawControl("matamount");
		$this->redrawControl("materialterm");
		//$this->redirect("this");
	}

    public function handleSetBasketVal($index, $name, $basket="basket", $val){
		$items = $this->$basket->containers;
		$items[$index]->$name = $val;
		if($name=="product"){
			unset($items[$index]->term);
			unset($items[$index]->time);
		}
		if($name=="type"){
			unset($items[$index]->product);
			unset($items[$index]->price);
		}
		if($name=="term"){
			unset($items[$index]->time);
		}
		if(!empty($items[$index]->product) && !empty($items[$index]->type)){
			$price = $this->productManager->findActualPrice($items[$index]->product, $items[$index]->type);
			if($price){
				$items[$index]->price = $this->rowToArray($price);
			}
			else{
				$items[$index]->price = null;
			}
		}
		$this->$basket->containers = $items;
		$this->recalculateBasket($basket);
		if(in_array($name, array("term","product","type"))!==false){
			$this->redrawControl("orderContainers");
		}
		$this->redrawControl("matamount");
		$this->redrawControl("materialterm");
    }

    public function handleSetOrderVal($name, $basket="basket", $val){
		$this->$basket->$name = $val;
		if($name=="termFrom"){
			$this->redrawControl("realizationterm");
			$this->redrawControl("orderContainers");
			$this->redrawControl("matamount");
		}
		$this->recalculateBasket($basket);
    }

    public function handleSetMoreToDemand($val){
		if(empty($this->basketD->more)){
			$more = array();
		}
		else{
			$more = $this->basketD->more;
		}
		$more[$val] = true;
		$this->basketD->more = $more;
		//$this->recalculateBasket();
    }

    public function handleUnsetMoreToDemand($val){
		if(empty($this->basketD->more)){
			$more = array();
		}
		else{
			$more = $this->basketD->more;
		}
		unset($more[$val]);
		$this->basketD->more = $more;
		//$this->recalculateBasket();
    }

    public function renderOrder2(){
		$this->template->items = $this->basket->items;
	}

    public function renderSummary(){
		$this->template->items = $this->basket->items;
		$this->template->products = $this->basket->products;
		$this->template->sizesS = $this->basket->sizes;
		$this->template->materialsS = $this->basket->materials;
		$this->template->amountsS = $this->basket->amounts;
		$this->template->borders = $this->basket->borders;
		$this->template->order = $this->basket->order;
    	$totalPhotos = 0;
    	if(!empty($this->basket->amounts)){
            foreach($this->basket->amounts as $amount){
                $totalPhotos += $amount;
            }
        }
    	$this->template->totalPhotos = $totalPhotos;
    	//$this->template->minPhotos = MIN_PHOTOS_TO_PRINT;
	}

    public function actionFinishOrder($p=false){

    	$items = 0;
    	foreach($this->basket->amounts as $amount){
			$items += $amount;
    	}
    	/*
    	if($items<MIN_PHOTOS_TO_PRINT){
			$this->flashMessageError("Objedn??vka tisku mus?? obsahovat alespo?? ".MIN_PHOTOS_TO_PRINT." fotek");
			$this->redirect("this");
    	}
    	*/

		$this->basket->order->delivery = $this->deliveries[$this->basket->order->delivery];
		$this->basket->order->payment = $this->payments[$this->basket->order->payment];
		$orderId = $this->orderManager->saveOrder($this->basket, $this->sizes);

        if(!empty($this->basket->voucher) && !$this->basket->voucher->unlimited){
            $this->voucherManager->update(array("used"=>new \Nette\Utils\DateTime()), $this->basket->voucher->id);
        }

		$this->basket->remove();

		$order = $this->orderManager->find($orderId);

		$items = $this->orderManager->findOrderItems($orderId);
		$products = $this->orderManager->findOrderProducts($orderId);
		$albums = array();
		foreach($items as $item){
			if(empty($albums[$item->folderId])){
				$album = $this->projectManager->findByHash($item->folderId);
				$albums[$item->folderId] = new \nette\utils\arrayHash();
				$albums[$item->folderId]->branch = $album->branch;
				$albums[$item->folderId]->id = $album->id;
				$albums[$item->folderId]->custom = $album->custom;
				$folder = $this->getGfile($item->folderId);
				$albums[$item->folderId]->folder = $folder->name;
			}
		}

		$data = array(
			"order" => $order,
			"items" => $items,
			"products" => $products,
			"albums" => $albums,
			"branches" => $this->branchesSimple,
			"sizes" => $this->sizes,
			"materials" => $this->materials,
			"deliveries" => $this->deliveries,
			"payments" => $this->payments,
		);

		//TODO generate mail
		$this->sendMailFromTemplate("orderStatus1.latte", $data, $order->email, "Potvrzen?? objedn??vky tisku fotek");
		$this->sendMailFromTemplate("orderConfirmEshop.latte", $data, $this->settings->email, "Nov?? objedn??va tisku fotek");
        
        //cleanup user album
        $this->cleanupUserAlbumAfterOrder($orderId);

		if(!$p){
			$this->redirect(":Front:Homepage:page", "dekujeme-za-objednavku");
		}
		else{
			$this->payOrder($orderId);
			//$this->redirect(":Front:Homepage:payment", $orderId);
		}
	}
    
    public function cleanupUserAlbumAfterOrder($orderId){
       $orderedCustomPhotos = $this->orderManager->findOrderCustomPhotos($orderId); 
       foreach($orderedCustomPhotos as $folrderId=>$orderedItems){
           $folderItems = $this->getGfiles($folrderId);
           foreach($folderItems as $folderItem){
            if(array_search($folderItem->getId(), $orderedItems)===false){
                //delete file from folder
                $this->deleteGfolder($folderItem->getId());
            }
           }
       }
       $albumSes = $this->getSession("album");
       $albumSes->album = null;
    }


    public function actionPage($id=""){
        //detect product or category
        $product = $this->productManager->findByAlias($id);
        $category = $this->categoryManager->findByAlias($id);
        if($product && $product->type==1){
			$this->setview("container");
        }
        else if($category){
			if($category->type==1){
				$this->setview("containers");
			}
			else{
				$this->setview("materials");
			}
        }
        else{
	        $page = $this->template->page = $this->pageManager->findByAlias($id);
	        if(!$page){
				$page = $this->template->page = $this->pageManager->findByAlias("stranka-nenalezena");
				$httpResponse = $this->getHttpResponse();
				$httpResponse->setCode(Response::S404_NOT_FOUND);

				//$this->redirect(":Front:Homepage:page", "stranka-nenalezena");
	        }
	        $this->template->title = $page->title;
	        $this->template->keywords = $page->seo_keywords;
	        $this->template->description = $page->seo_description;
	        $this->setview($page->view);
	        if($page->parent){
	            $parent = $this->pageManager->find($page->parent);
	            //$this->addBreadcrumbs($parent->name, $this->link(":Front:Homepage:page", $parent->alias));
	        }
	        //$this->addBreadcrumbs($page->name, $this->link(":Front:Homepage:page", $id));
	        $this->template->images = $this->pageManager->getPhotos($page->id);
        }
    }
    
    public function renderContainers($id=""){
	    $page = $this->template->page = $this->pageManager->findByLayout(8);
	    $this->template->title = $page->title;
	    $this->template->keywords = $page->seo_keywords;
	    $this->template->description = $page->seo_description;

    	$containers = $this->productManager->getByType(1);
	    if(!empty($id)){
			$category = $this->categoryManager->findByAlias($id);
		    if($category){
			    $this->template->title = $category->title;
			    $this->template->catName = $category->name_long;
			    $this->template->catDesc = $category->description;
			    $this->template->catAttrib = $category->attVal;
			    $this->template->description = $category->seo_description;
				$containers->where("categories LIKE '%|".$category->id."|%'");
		    }
			if(!empty($category->attVal)){
				$_GET["a1"] = $category->attVal;
			}
	    }
    	
    	$allowedAttrs = array();
    	$containersFilter = $this->productManager->getByType(1);
	    if(!empty($_GET["a1"])){
			$containersFilter->where("id IN (SELECT product FROM product_prices WHERE attributeValue=".$_GET["a1"]." AND priceFrom>0)");
    		$allowedWeights = array();
    		$allowedVolumes = array();
			foreach($containersFilter as $cont){
				$attrs = $cont->attributes;
				$attrsArr = explode("|", $attrs);
				foreach($attrsArr as $attrPair){
					$attrPairArr = explode("-", $attrPair);
					$attrId = $attrPairArr[0];
					$attrVal = $attrPairArr[1];
					if($attrId==3){
						$allowedWeights[] = $attrVal;
					}
					if($attrId==2){
						$allowedVolumes[] = $attrVal;
					}
				}
			}
			$allowedAttrs["2"] = $allowedVolumes;
			$allowedAttrs["3"] = $allowedWeights;
	    }
	    if(!empty($_GET["a2"])){
			$attrPair = "2-".$_GET["a2"];
			$containersFilter->where("attributes LIKE '%".$attrPair."%'");
    		$allowedWeights = array();
			foreach($containersFilter as $cont){
				$attrs = $cont->attributes;
				$attrsArr = explode("|", $attrs);
				foreach($attrsArr as $attrPair){
					$attrPairArr = explode("-", $attrPair);
					$attrId = $attrPairArr[0];
					$attrVal = $attrPairArr[1];
					if($attrId==3){
						$allowedWeights[] = $attrVal;
					}
				}
			}
			$allowedAttrs["3"] = $allowedWeights;
	    }
		$this->template->allowedAttrs = $allowedAttrs;
	    
	    if(!empty($_GET["a2"]) && array_search($_GET["a2"], $allowedVolumes)===false){
			unset($_GET["a2"]);
	    }
	    if(!empty($_GET["a3"]) && array_search($_GET["a3"], $allowedWeights)===false){
			unset($_GET["a3"]);
	    }
	    
    	foreach($_GET as $key=>$val){
			if(!empty($val) && $key[0]=="a"){
				$attr = substr($key, 1, 9);
				if($attr==1){
				}
				else{
					$attrPair = $attr."-".$val;
					$containers->where("attributes LIKE '%".$attrPair."%'");
				}
			}
			if($key=="t" && $val=="on"){
				$containers->where("turbo = ?", true);
			}
    	}
    	$this->template->containers = $containers;
    	$this->template->attVals = $this->attributeManager->getAllValues();
    	
    }
    public function renderMaterials($id=""){
	    $page = $this->template->page = $this->pageManager->findByLayout(9);
	    $this->template->title = $page->title;
	    $this->template->keywords = $page->seo_keywords;
	    $this->template->description = $page->seo_description;

    	$containers = $this->productManager->getByType(2);
	    if(!empty($id)){
			$category = $this->categoryManager->findByAlias($id);
		    if($category){
			    $this->template->title = $category->title;
			    $this->template->catName = $category->name_long;
			    $this->template->catDesc = $category->description;
			    $this->template->catAttrib = $category->attVal;
			    $this->template->description = $category->seo_description;
				$containers->where("categories LIKE '%|".$category->id."|%'");
		    }
	    }
    	$this->template->containers = $containers;
    	$this->template->attVals = $this->attributeManager->getAllValues();
    }
    public function getProductAttributeValues($source){
		$values = $this->attributeManager->getAllValues();
		$return = array();
		$pairs = explode("|", $source);
		foreach($pairs as $pair){
			if(!empty($pair)){
				list($attr, $val) = explode("-", $pair);
				$return[$attr] = $values[$val];
			}
		}
		return $return;
    }


	public function actionPayment($id = null, $pay = null, $paymentSessionId=null, $targetGoId=null, $orderNumber=null, $encryptedSignature=null)
	{
        if(!empty($pay)){
            //$this->orderManager->update(array("pay_status"=>5), $id);
            $order = $this->orderManager->findByPaymentId($paymentSessionId);
            if($pay = 1){
                $payment = $this->paymentService->restorePayment([
                    'sum'         => $order->price,
                    'variable'    => $order->id,
                    'productName' => "Objedn??vka tisku",
                ], [
                    'paymentSessionId'   => $paymentSessionId,
                    'targetGoId'         => $targetGoId,
                    'orderNumber'        => $orderNumber,
                    'encryptedSignature' => $encryptedSignature,
                ]);
                if($payment->isPaid()){
                    $this->orderManager->update(array("paid"=>true), $order->id);
                    //generate invoice
                    $invoiceId = $this->makeInvoice($order->id);
	                //send invoice
	                $invoicePdfData = $this->getInvoicePdf($invoiceId);
	                $template = $this->createTemplate();
	                $template->setFile(APP_DIR . '/FrontModule/templates/Mails/sendInvoice.latte');


	                $mail = new Message;
	                $mail->setFrom($this->settings->email)
	                    ->addTo($order->email)
	                    ->setSubject("Da??ov?? doklad za tisk fotek")
	                    ->setHtmlBody($template);
	                $mail->addAttachment('faktura.pdf', $invoicePdfData);
	                $mailer = new SendmailMailer;
	                $mailer->send($mail);

	                $this->orderManager->updateByInvoiceId(array("sended"=>true), $invoiceId);

                    $this->template->status = 1;
                    $this->redirect("paymentDone");
                }
                else{
                    $this->template->order = $order;
                    $this->template->status = 9;
                }
            }
            else{
                $this->template->order = $order;
                $this->template->status = 9;
            }
        }
        $this->template->order = $this->orderManager->find($id);
	}

    public function handlePayOrder($orderId){
        $this->payOrder($orderId);
    }

    public function createComponentOrderForm(){
        $form = new Form();

        //SYSTEM
        $form ->addHidden("type");
        $form ->addHidden("usertype")->setDefaultValue(0);
        $form ->addCheckbox("payment", "Hotov?? ??idi??i p??i p??istaven?? kontejneru *")
        	->getControlPrototype()->class("form-check-input");
        //$form["payment"]->addRule($form::FILLED, "Je nutn?? potvrdit zp??sob platby. Platba je mo??n?? pouze hotov?? ??idi??i.");
        //$form ->addCheckbox("agree", "Souhlas??m s obchodn??mi podm??nkami *")
        $agreeText = Html::el(null)
        	->addText("Souhlas??m s ")
        	->addHtml(Html::el('a')
        		->href($this->link(":Front:Homepage:page", 'obchodni-podminky'))
        		->target("_blank")
        		->setText('obchodn??mi podm??nkami'))
        	->addText(" *");
        $form ->addCheckbox("agree", $agreeText)
        	->getControlPrototype()->class("form-check-input");
        //$form["agree"]->addRule($form::FILLED, "Je nutn?? potvrdit souhlas s obchodn??mi podm??nkami.");
        
        //PERSONAL
        $form ->addText("name", "Jm??no *")
                ->getControlPrototype()->class("form-control required");
        $form ->addText("surname", "P????jmen?? *")
                ->getControlPrototype()->class("form-control required");
        $form ->addText("email", "E-mail *")
                ->getControlPrototype()->class("form-control required");
        $form ->addText("phone", "Telefon *")
                ->getControlPrototype()->class("form-control required");
		
		//PERSONAL valudations
        $form["name"]
        	->addConditionOn($form['usertype'], Form::EQUAL, 1)
        	->addRule(Form::FILLED, "Vypl??te jm??no");
        $form["surname"]
        	->addConditionOn($form['usertype'], Form::EQUAL, 1)
        	->addRule(Form::FILLED, "Vypl??te p????jmen??");
        $form["email"]
        	->addConditionOn($form['usertype'], Form::EQUAL, 1)
        	->addRule(Form::FILLED, "Vypl??te e-mail")
        	->addRule(Form::EMAIL, "Vypl??te platn?? e-mail");
        $form["phone"]
        	->addConditionOn($form['usertype'], Form::EQUAL, 1)
        	->addRule(Form::FILLED, "Vypl??te telefonn?? ????slo");

        $form ->addTextArea("note", "Pozn??mka", 30, 5)
                ->getControlPrototype()->class("form-control");

		//different delivery personal
        $form -> addCheckbox("different_delivery", "Adresa trval??ho bydli??t?? je jin?? ne?? adresa p??istaven??")
                ->getControlPrototype()->class("differentDelivery form-check-input");
        $form["different_delivery"]->getLabelPrototype()->class("form-check-label");

        $form ->addText("delivery_street", "Ulice a ????slo popisn?? *")
                ->getControlPrototype()->class("form-control required");
        $form["delivery_street"]
        	->addConditionOn($form['different_delivery'], Form::EQUAL, TRUE)
        	->addRule(Form::FILLED, "Vypl??te ulici a ????slo popisn??");
        $form ->addText("delivery_city", "M??sto *")
                ->getControlPrototype()->class("form-control required");
        $form["delivery_city"]
        	->addConditionOn($form['different_delivery'], Form::EQUAL, TRUE)
        	->addRule(Form::FILLED, "Vypl??te m??sto");
        $form ->addText("delivery_zip", "PS?? *")
                ->getControlPrototype()->class("form-control required");
        $form["delivery_zip"]
        	->addConditionOn($form['different_delivery'], Form::EQUAL, TRUE)
        	->addRule(Form::FILLED, "Vypl??te PS??");

        //COMPANY
        $form ->addText("ic", "I?? *")
                ->getControlPrototype()->class("form-control idField required");
        $form ->addText("bussiness_name", "Jm??no *")
                ->getControlPrototype()->class("form-control required");
        $form ->addText("bussiness_surname", "P????jmen?? *")
                ->getControlPrototype()->class("form-control required");
        $form ->addText("bussiness_email", "E-mail *")
                ->getControlPrototype()->class("form-control required");
        $form ->addText("bussiness_phone", "Telefon *")
                ->getControlPrototype()->class("form-control required");
        $form ->addTextArea("bussiness_note", "Pozn??mka", 30, 5)
                ->getControlPrototype()->class("form-control");
        $form ->addText("bussiness_company", "N??zev firmy")
                ->getControlPrototype()->class("form-control");

		//COMPANY valudations
        $form["ic"]
        	->addConditionOn($form['usertype'], Form::EQUAL, 0)
        	->addRule(Form::FILLED, "Vypl??te I??");
        $form["bussiness_name"]
        	->addConditionOn($form['usertype'], Form::EQUAL, 0)
        	->addRule(Form::FILLED, "Vypl??te jm??no");
        $form["bussiness_surname"]
        	->addConditionOn($form['usertype'], Form::EQUAL, 0)
        	->addRule(Form::FILLED, "Vypl??te p????jmen??");
        $form["bussiness_email"]
        	->addConditionOn($form['usertype'], Form::EQUAL, 0)
        	->addRule(Form::FILLED, "Vypl??te e-mail")
        	->addRule(Form::EMAIL, "Vypl??te platn?? e-mail");
        $form["bussiness_phone"]
        	->addConditionOn($form['usertype'], Form::EQUAL, 0)
        	->addRule(Form::FILLED, "Vypl??te telefonn?? ????slo");


		//different delivery company
        $form -> addCheckbox("bussiness_different_delivery", "Faktura??n?? adresa je jin?? ne?? adresa p??istaven??")
                ->getControlPrototype()->class("differentDeliveryBussiness form-check-input");
        $form["bussiness_different_delivery"]->getLabelPrototype()->class("form-check-label");

        $form ->addText("bussiness_delivery_street", "Ulice a ????slo popisn?? *")
                ->getControlPrototype()->class("form-control required");
        $form["bussiness_delivery_street"]
        	->addConditionOn($form['bussiness_different_delivery'], Form::EQUAL, TRUE)
        	->addRule(Form::FILLED, "Vypl??te ulici a ????slo popisn??");
        $form ->addText("bussiness_delivery_city", "M??sto *")
                ->getControlPrototype()->class("form-control required");
        $form["bussiness_delivery_city"]
        	->addConditionOn($form['bussiness_different_delivery'], Form::EQUAL, TRUE)
        	->addRule(Form::FILLED, "Vypl??te m??sto");
        $form ->addText("bussiness_delivery_zip", "PS?? *")
                ->getControlPrototype()->class("form-control required");
        $form["bussiness_delivery_zip"]
        	->addConditionOn($form['bussiness_different_delivery'], Form::EQUAL, TRUE)
        	->addRule(Form::FILLED, "Vypl??te PS??");
        	
		$this->template->subpages = $this->pageManager->getInSubpagesByParent($this->template->page->id);
		$services = array();
		foreach($this->template->subpages as $sp){
			$services[$sp->name] = $sp->name;
		}
        $form->addSelect("service", "M??m z??jem o", $services)
        	->setPrompt("vyberte");

        $form->addText("locality", "Lokalita ??ern?? skl??dky")
        	->getControlPrototype()->class("form-control");


        $form->addSubmit("submit", "Odeslat objedn??vku")->getControlPrototype()->class("btn btn-primary btn-arrow btn-white");

        $form->onSuccess[] = [$this, 'saveOrder'];

        return $form;
    }


    /** callback for page form
    *
    * @param Form data from page form
    * @return void
    */
    public function saveOrder(Form $form){
        $values = $form->getValues();
        
        $basketfield = "basket";
		if($values->type == 9){
			$basketfield = "basketD";
		}
		if($values->type == 8 || $values->type == 7){
			$basketfield = "basketD";
		}
		if($values->type == 2){
			$basketfield = "basketM";
		}

        if($values->type==1 && count($this->basket->containers)==0){
			$form->addError("Objedn??vka neobsahuje ????dn?? kontejnery");
        }
        if($values->type==8 && empty($values->service)){
			$form->addError("Vyberte slu??bu o kterou m??te z??jem.");
        }
        if($values->type==7 && empty($values->locality)){
			$form->addError("Zadejte lokalitu skl??dky.");
        }
        if($basketfield != "basketD" && $values->payment != true){
			$form->addError("Je nutn?? potvrdit zp??sob platby. Platba je mo??n?? pouze hotov?? ??idi??i.");
        }
        if(/*$basketfield != "basketD" && */$values->agree != true && $values->type != 8 && $values->type != 7){
			$form->addError("Je nutn?? potvrdit souhlas s obchodn??mi podm??nkami.");
        }
        
        if($basketfield == "basketD" && empty($this->$basketfield->termFrom) && $values->type != 8 && $values->type != 7){
			$form->addError("Vypl??te term??n, od kdy se pl??nuje realizace");
        }
        if($basketfield != "basketD" && !empty($this->$basketfield->containers)){
	        $typesError = false;
	        $productsError = false;
	        $termsError = false;
	        $timesError = false;
	        foreach($this->$basketfield->containers as $container){
				if(empty($container->type)){
					$typesError = true;
				}
				if(empty($container->product)){
					$productsError = true;
				}
				if($basketfield != "basketD"){
					if(empty($container->term)){
						$termsError = true;
					}
					if(empty($container->time)){
						$timesError = true;
					}
				}
	        }
	        if($typesError) $form->addError("Vypl??te typ odpadu u v??ech kontejer??");
	        if($productsError) $form->addError("Vypl??te velikost u v??ech kontejer??");
	        if($basketfield == "basket"){
		        if($termsError) $form->addError("Vypl??te term??n p??istaven?? u v??ech kontejer??");
		        if($timesError) $form->addError("Vypl??te ??as p??istaven?? u v??ech kontejer??");
	        }
        }

        if($form->isValid()){
            try{
                if($values->type == 8){
					$values->description = $values->service;
                }
                if($values->type == 7){
					$values->description = $values->locality;
                }
                unset($values->service);
                unset($values->locality);
                $values->date = new \nette\utils\DateTime();
				/*
				if(!empty($values->payment)){
					$values->paymentPrice = (!empty($this->paymentPrices[$values->payment])?$this->paymentPrices[$values->payment]:0);
				}
				if(!empty($values->delivery)){
					$values->deliveryPrice = (!empty($this->deliveryPrices[$values->delivery])?$this->deliveryPrices[$values->delivery]:0);
				}
				*/
                unset($values->usertype);
                unset($values->agree);
                $this->$basketfield->order = $values;

				$orderId = $this->orderManager->saveOrder($this->$basketfield, $this->productManager, $this->settings);

				$this->$basketfield->remove();

				$order = $this->orderManager->find($orderId);

				$products = $this->orderManager->findOrderProducts($orderId);

				$data = array(
					"order" => $order,
					"products" => $products,
					"beton" => $this->settings->betonProduct,
					//"deliveries" => $this->deliveries,
					//"payments" => $this->payments,
				);

				//TODO generate mail
				//$this->sendMailFromTemplate("orderStatus1.latte", $data, $order->email, "Potvrzen?? objedn??vky kontejneru");
				if($values->type==1){
					$this->sendMailFromTemplate("orderConfirmEshop.latte", $data, $this->settings->email, "Nov?? objedn??vka kontejneru");
					if(!empty($values->email)){
						$this->sendMailFromTemplate("orderConfirmEshop.latte", $data, $values->email, "Nov?? objedn??vka kontejneru");
					}
					if(!empty($values->bussiness_email)){
						$this->sendMailFromTemplate("orderConfirmEshop.latte", $data, $values->bussiness_email, "Nov?? objedn??vka kontejneru");
					}
				}
				if($values->type==2){
					$this->sendMailFromTemplate("orderMatConfirmEshop.latte", $data, $this->settings->email, "Nov?? objedn??vka materi??lu");
					if(!empty($values->email)){
						$this->sendMailFromTemplate("orderMatConfirmEshop.latte", $data, $values->email, "Nov?? objedn??vka materi??lu");
					}
					if(!empty($values->bussiness_email)){
						$this->sendMailFromTemplate("orderMatConfirmEshop.latte", $data, $values->bussiness_email, "Nov?? objedn??vka materi??lu");
					}
				}
				if($values->type==9){
					$this->sendMailFromTemplate("demandConfirmEshop.latte", $data, $this->settings->email, "Nov?? popt??vka");
					if(!empty($values->email)){
						$this->sendMailFromTemplate("demandConfirmEshop.latte", $data, $values->email, "Nov?? popt??vka");
					}
					if(!empty($values->bussiness_email)){
						$this->sendMailFromTemplate("demandConfirmEshop.latte", $data, $values->bussiness_email, "Nov?? popt??vka");
					}
				}
				if($values->type==8 || $values->type==7){
					$data["type"] = $values->type;
					$this->sendMailFromTemplate("demandConfirmEshop2.latte", $data, $this->settings->email, "Nov?? popt??vka");
					$this->sendMailFromTemplate("demandConfirmEshop2.latte", $data, $values->email, "Nov?? popt??vka");
				}

				if($values->type==9 || $values->type==8 || $values->type==7){
                	$this->redirect(":Front:Homepage:page", "dekujeme-za-poptavku");
				}
				else{
                	$this->redirect(":Front:Homepage:page", "dekujeme-za-objednavku");
				}
            }
            catch(DibiDriverException $e){
                $this->flashMessage($e->getMessage(), "error");
            }
        }
    }
    
    public function createComponentAddToOrderForm(){
        $form = new Form();

        $form ->addHidden("isContainer", "");
        
        $form->onSuccess[] = [$this, 'createOrder'];

        return $form;
    }
    
    public function handleAddToOrderC($c, $p=null){
		$item = new \Nette\Utils\ArrayHash();
		$item->product = $c;
		if(!empty($p)){
			$price = $this->productManager->findPrice($p);
			$item->type = $price->attributeValue;
			$item->price = $this->rowToArray($price);
		}
		$items[] = $item;
	    $this->basket->containers = $items;
        
		$this->recalculateBasket();

        $containerOrderPage = $this->pageManager->findByLayout(11);
        $this->redirect(":Front:Homepage:page", $containerOrderPage->alias);
		
    }

    public function handleAddToOrderM($c, $p=null){
		$material = new \Nette\Utils\ArrayHash();
		$material->product = $c;
		if(!empty($p)){
			$price = $this->productManager->findPrice($p);
			$material->price = $p;
			$material->amount = 1;
			$material->priceObj = $this->rowToArray($price);
		}
		$items[] = $material;
	    $this->basketM->materials = $items;
        
		$this->recalculateBasket();

        $containerOrderPage = $this->pageManager->findByLayout(15);
        $this->redirect(":Front:Homepage:page", $containerOrderPage->alias);
		
    }


    /** callback for page form
    *
    * @param Form data from page form
    * @return void
    */
    public function createOrder(Form $form){
        $values = $form->getValues();
	   	$request = $this->getHttpRequest();
	   	$amounts = $request->getPost("amounts");
	   	$prices = $request->getPost("prices");
        if($values->isContainer=="1"){
	        $items = array();
	        foreach($prices as $priceId=>$value){
				if($value=="on"){
					$amount = $amounts[$priceId];
					for($i=1;$i<=$amount;$i++){
						$price = $this->productManager->findPrice($priceId);
						$item = new \Nette\Utils\ArrayHash();
						$item->type = $price->attributeValue;
						$item->product = $price->product;
						$item->price = $this->rowToArray($price);
						$items[] = $item;
					}
				}
	        }
	        $this->basket->containers = $items;
            
			$this->recalculateBasket();

            $containerOrderPage = $this->pageManager->findByLayout(11);
            $this->redirect(":Front:Homepage:page", $containerOrderPage->alias);
        }
        if($values->isContainer=="2"){
	        foreach($prices as $priceId=>$value){
				if($value=="on"){
					$amount = $amounts[$priceId];
					$price = $this->productManager->findPrice($priceId);

					$material = new \Nette\Utils\ArrayHash();
					$material->price = $priceId;
					$material->product = $price->product;
					$material->amount = $amount;
					$material->priceObj = $this->rowToArray($price);
					
					$materials[0] = $material;
					$this->basketM->materials = $materials;
				}
	        }
            
			$this->recalculateBasket("basketM");

            $containerOrderPage = $this->pageManager->findByLayout(15);
            $this->redirect(":Front:Homepage:page", $containerOrderPage->alias);
        }
    }
    
    public function createComponentUpload(){
        $form = new Form();
        
        $form ->addMultiUpload("img", "Soubor obr??zku")
            ->setRequired(true)
            ->addRule(Form::MIME_TYPE, 'Po??adovan?? soubor mus?? b??t ve form??tu JPG nebo TIFF.', 'image/jpeg,image/tiff')
            //->addRule(Form::MAX_LENGTH, 'Najednou lze nahr??t maxim??ln?? %d soubor??', 10)
            //->addRule(Form::IMAGE, 'Soubor mus?? b??t JPG, JPEG, PNG nebo GIF.')
            ;
        $form ->addSubmit("submit", "Nahr??t")
            ->getControlPrototype()->class("btn btn-primary");

        $form->onSuccess[] = [$this, 'savePhoto'];


        return $form;
    }
    
    public function actionUploadFile(){
    	
    	$albumSes = $this->getSession("album");
    	if(empty($albumSes->album)){
			$this->createAlbum();
    	}

		$fileTypes = array('jpg','jpeg','tif','tiff'); // Allowed file extensions

		$verifyToken = md5('unique_salt' . $_POST['timestamp']);

		if (!empty($_FILES) && $_POST['token'] == $verifyToken) {
			$tempFile   = $_FILES['Filedata']['tmp_name'];

			// Validate the filetype
			$fileParts = pathinfo($_FILES['Filedata']['name']);
			$ext= strtolower($fileParts['extension']);
			if (in_array($ext, $fileTypes)) {
				// Save the file
		        $name = $this->generateString(15);
		        $fileName = "usr_".$name.".".$ext;
		        $albumSes = $this->getSession("album");
		        $album = $albumSes->album;
		        $gFile = $this->uploadGfile($fileName, $tempFile, $album);
		        if($ext=="tif" || $ext=="tiff"){
					$this->generateJpegForTif($gFile->getId(), $album);
		        }
				echo 1;

			} else {

				// The file type wasn't allowed
				echo 'Invalid file type.';

			}
		}
		$this->terminate();
    }
    
    public function generateJpegForTif($fileId, $album){
		$file = $this->getGfile($fileId);
		$tiffName = $file->getName();
		$jpegName = $this->tiff2jpgName($tiffName);
		$tiffPath = DATA_DIR.'/temp/'.$tiffName;
        $ft = fopen($tiffPath, 'w');
		//get data of original file
		fwrite($ft, file_get_contents($file->getWebContentLink()));
		fclose($ft);

		//convert tiff to jpeg
		$jpegPath = $this->tiff2jpg($tiffPath);

		//upload file to server
		if(!empty($jpegPath)){
			$this->uploadGfile($jpegName, $jpegPath, $album);
		}
    }

    public function savePhoto(Form $form){
        $values = $form->getValues();

        if ($form->isValid()) {
            // submitted and valid
            $values = $form->getValues();
            /*
             * Kontrola, zda-li byl obrazek skutecne nahran
             */
            if(!empty($values['img'])){
                foreach($values['img'] as $image){
                    if ($image->isOk()) {
                        $ext = pathinfo($image->getSanitizedName(), PATHINFO_EXTENSION);
                        $name = $this->generateString(15);
                        $fileName = $name.".".$ext;
                        $tempFile = BASE_DIR."/data/temp/".$fileName;
                        $image->move($tempFile);

                        //resize and move
                        //$bigImage = Image::fromFile($tempFile);
                        //$bigImage->resize(1600, 1200, Image::SHRINK_ONLY);
                        //$bigImage->save($tempFile);

                        $albumSes = $this->getSession("album");
                        $album = $albumSes->album;
                        $this->uploadGfile($fileName, $tempFile, $album);

                        if(file_exists($tempFile))
                            unlink($tempFile);

                    }
                }
            }
        }
        $this->redirect("this");

    }

    public function createComponentVoucherForm(){
        $form = new Form($this->lang);

        //$form->getElementPrototype()->class("ajax");
        $form ->addText("voucher", "Vlo??te k??d kup??nu")
                ->getControlPrototype()->class("form-control")->placeholder("Vlo??te k??d kup??nu");

        $form->addSubmit("submit", "Pou????t slevov?? kup??n")->getControlPrototype()->class("btn btn-info");

        if(!empty($this->basket->details)){
            $form->setDefaults($this->basket->details);
        }

        $form->onSuccess[] = [$this, 'useVoucher'];

        return $form;
    }

    /** callback for contact form
    *
    * @param Form data from contact form
    * @return void
    */
    public function useVoucher(Form $form, $values){

        $exists = $this->voucherManager->findByCode($values->voucher);
        $now = new \nette\utils\DateTime();
        if(!$exists){
            $form["voucher"]->addError("Slevov?? k??d nen?? platn??");
        }
        elseif(!empty($exists->validTo) && $exists->validTo<$now){
            $form["voucher"]->addError("Slevov?? k??d ji?? nen?? platn??");
        }
        elseif(!$exists->unlimited && !empty($exists->used)){
            $form["voucher"]->addError("Slevov?? k??d ji?? byl pou??it");
        }
        else{
            $exists = \Nette\Utils\ArrayHash::from($exists->toArray());
            $this->basket->voucher = $exists;
            $this->flashMessage("Slevov?? k??d byl ??sp????n?? pou??it");
        	$this->redirect("this");
        }

        //$this->recalculateBasket();


    }

    public function handleDownloadZip($id, $format="JPEG", array $images){
    	$album = $this->projectManager->find($id);
    	$files = $this->getGfiles($album->hash);
		$toZip = array();
		foreach($files as $file){
			$ext = pathinfo($file->getName(), PATHINFO_EXTENSION);
			$name = pathinfo($file->getName(), PATHINFO_FILENAME);
			if( ($format=="TIF" && in_array(strtolower($ext), array("tif", "tiff"))) || ($format=="JPEG" && in_array(strtolower($ext), array("jpg", "jpeg")))){
				if(in_array($file->getId(), $images)){
					$toZip[$name] = $file;
				}
			}
		}

		$dir = DATA_DIR.DIRECTORY_SEPARATOR."temp".DIRECTORY_SEPARATOR;
        $zipname = "fotografie_".$format."_".$id.".zip";
		if(file_exists($dir . $zipname)){
            unlink($dir . $zipname);
		}
        $zip = new \ZipArchive;
        $zip->open($dir . $zipname, \ZipArchive::CREATE);
        foreach ($toZip as $file) {
			$content = $this->getGfileMedia($file->getId());
            $f = fopen($dir.$file->getName(), "w");
            fputs($f, $content);
            fclose($f);
            $zip->addFile($dir.$file->getName(),$file->getName());
            //$zip->addFromString($content,$file->getName());
		}
        $zip->close();
        foreach ($toZip as $file) {
			if(file_exists($dir.$file->getName())){
            	unlink($dir.$file->getName());
			}
		}

		if(file_exists($dir . $zipname)){
	        $ret = array("url"=>$this->link("//:Front:Homepage:page") . "data/temp/". $zipname);
	        die(json_encode($ret));
	        //$response = new \Nette\Application\Responses\FileResponse($dir . $zipname, $zipname, 'application/zip', false);
	        //$this->sendResponse($response);
		}
		$this->terminate();
    }
    
    public function handleMergeRows(){
		$items = $this->basket->items;
		$sizesS = $this->basket->sizes;
		$materialsS = $this->basket->materials;
		$amountsS = $this->basket->amounts;
		$exists = array();
		
		foreach($items as $key=>$fileId){
			$unique = $fileId."-".$sizesS[$key]."-".$materialsS[$key];
			if(!isset($exists[$unique])){
				$exists[$unique] = $key;
			}
			else{
				$amountsS[$exists[$unique]] += $amountsS[$key];
				unset($items[$key]);
				unset($sizesS[$key]);
				unset($materialsS[$key]);
				unset($amountsS[$key]);
			}
		}
		
		$this->basket->items = $items;
		$this->basket->sizes = $sizesS;
		$this->basket->materials = $materialsS;
		$this->basket->amounts = $amountsS;

		$this->redirect("order2");
    }
    
    public function actionAres($ico){
        define('ARES','http://wwwinfo.mfcr.cz/cgi-bin/ares/darv_bas.cgi?ico=');
        $file = @file_get_contents(ARES.$ico);
        if ($file) $xml = @simplexml_load_string($file);
        $a = array();
        if ($xml) {
         $ns = $xml->getDocNamespaces();
         $data = $xml->children($ns['are']);
         $el = $data->children($ns['D'])->VBAS;
         if (strval($el->ICO) == $ico) {
          $a['ico']     = strval($el->ICO);
          $a['dic']     = strval($el->DIC);
          $a['firma']     = strval($el->OF);
          $a['ulice']    = strval($el->AA->NU).' '.strval($el->AA->CO);
          $a['mesto']    = strval($el->AA->N);
          $a['psc']        = strval($el->AA->PSC);
          $a['zeme']    = strval($el->AA->NS);
          $a['stav']     = 'ok';
         } else
          $a['stav']     = 'I?? firmy nebylo nalezeno';
        } else
         $a['stav']     = 'Datab??ze ARES nen?? dostupn??';
        $this->payload->data = $a;
        $this->sendPayload();
        $this->terminate();
    }

    

}
