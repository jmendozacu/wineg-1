<?php
class Spectrum_Setdist_IndexController extends Mage_Core_Controller_Front_Action{
    public function IndexAction() {

      $dist = $this->getRequest()->getParam('dist', false);
      Mage::getSingleton('core/session')->setStoredeliverydistance($dist);
      $response["dist"] = Mage::getSingleton('core/session')->getStoredeliverydistance();
      $this->getResponse()->clearHeaders()->setHeader('Content-type','application/json',true);
      $this->getResponse()->setBody(json_encode($response));
        /*die;
	  $this->loadLayout(); 
    $this->renderLayout();
    Zend_Debug::dump($this->getLayout()->getUpdate()->getHandles());  
  
	  $this->getLayout()->getBlock("head")->setTitle($this->__("Titlename"));
	        $breadcrumbs = $this->getLayout()->getBlock("breadcrumbs");
      $breadcrumbs->addCrumb("home", array(
                "label" => $this->__("Home Page"),
                "title" => $this->__("Home Page"),
                "link"  => Mage::getBaseUrl()
		   ));

      $breadcrumbs->addCrumb("titlename", array(
                "label" => $this->__("Titlename"),
                "title" => $this->__("Titlename")
		   ));

      $this->renderLayout(); */
	  
    }
}