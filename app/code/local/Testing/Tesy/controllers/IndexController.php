<?php
class Testing_Tesy_IndexController extends Mage_Core_Controller_Front_Action{


    public function IndexAction() {
      
$output = $this->GetGApi();
echo "<pre>"; print_r($output); die;
   
       Mage::log(print_r($output,true), null, 'mylogfile3.log');

	  $this->loadLayout();   
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

      $this->renderLayout(); 
	  
    }


    function GetGApi()
    {

         $customerData= array(
                 
                 'street' =>Mage::getSingleton('checkout/session')->getQuote()->getShippingAddress()->getStreet(), 
                 'city'=>Mage::getSingleton('checkout/session')->getQuote()->getShippingAddress()->getCity(),
                 'state' =>Mage::getSingleton('checkout/session')->getQuote()->getShippingAddress()->getRegion(),
                 'countryid' =>Mage::getSingleton('checkout/session')->getQuote()->getShippingAddress()->getCountryId(),
                 'postcode'=>Mage::getSingleton('checkout/session')->getQuote()->getShippingAddress()->getPostcode()

           );

       $customerData["street"] = implode(",+", $customerData["street"]);
       $customerData["street"] = str_replace(" ", "+", $customerData["street"]);

       $data = $customerData["street"].",+".$customerData["city"].",+".$customerData["state"].",+".$customerData["countryid"].",+".$customerData["postcode"];
  Mage::log(print_r($data,true), null, 'mylogfile1.log'); 
    //$url = 'http://maps.google.com/maps/api/geocode/json?address=47+Warbird+Dr.,+Millville,+New%20Jersey,+US,+08332&sensor=false';
    echo $url = 'http://maps.google.com/maps/api/geocode/json?address='.$data.'&sensor=false';    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_PROXYPORT, 3128);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    $response = curl_exec($ch);
    curl_close($ch);

    $response_a = json_decode($response, true);
    Mage::log(print_r($response_a,true), null, 'mylogfile5.log'); 
    return  $response_a;
    //return array('distance' => $dist, 'time' => $time);
    }

}