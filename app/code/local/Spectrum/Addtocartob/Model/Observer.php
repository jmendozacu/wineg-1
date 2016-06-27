<?php
class Spectrum_Addtocartob_Model_Observer
{


public function removeItemAndSetMessage($observer,$message="")
{

$quoteItem = $observer->getEvent()->getQuoteItem();
$product = $observer->getEvent()->getProduct();
// Your checks here, return if you want to leave things alone
$quoteItem->getQuote()->removeItem($quoteItem->getId());
Mage::throwException($message);

return $this;

}

			public function setAddtocartAttribute(Varien_Event_Observer $observer)
			{
				//Mage::dispatchEvent('admin_session_user_login_success', array('user'=>$user));
				//$user = $observer->getEvent()->getUser();
				//$user->doSomething();
				//Mage::log(print_r($_GET,true), null, 'myoblogfilef.log');
				//Mage::log(print_r($_POST,true), null, 'myoblogfilefxx.log');



		$params = $_POST;
        
        $cartone = Mage::getModel('checkout/cart')->getQuote();
        $sm_in_cart = $cartone->getCustomerShipping();
        $comming_shipping_not_supported_by_cart = "yes";
        $totalItemsInCart = Mage::helper('checkout/cart')->getItemsCount();
        //Mage::log(print_r($totalItemsInCart,true), null, 'myoblogfilefxx.log');
if($totalItemsInCart && isset($_POST["shippingp"]))
{	
        foreach ($cartone->getAllItems() as $item) 
        {
         $productId = $item->getProduct()->getId();
         $productName = $item->getProduct()->getName();
         //$productPrice = $item->getProduct()->getPrice();
          $attribute_code = "product_shipping";
          $storeIdforattribute = 0; 
          $productId = $productId;
          $valueforattribute = Mage::getResourceModel('catalog/product')->getAttributeRawValue($productId, $attribute_code, $storeIdforattribute);

          if ($valueforattribute != "" && !is_array($valueforattribute)) 
          {
            $valueforattribute = explode(',', $valueforattribute);
          }
          else
          {
            $valueforattribute[] = "storepickup";
          }

          if(!in_array($params["shippingp"],$valueforattribute))
          {  
                $comming_shipping_not_supported_by_cart = "no"; 
                $productname_array[] = $productName;
          }

          
          
        } //end foreach

        $productcheck = $observer->getEvent()->getProduct();
        
         $productId = $productcheck->getId();
          $valueforattribute = Mage::getResourceModel('catalog/product')->getAttributeRawValue($productId, $attribute_code, $storeIdforattribute);

          if ($valueforattribute != "" && !is_array($valueforattribute)) 
          {
            $valueforattribute = explode(',', $valueforattribute);
          }
          else
          {
            $valueforattribute[] = "storepickup";
          }

          if(!in_array($sm_in_cart,$valueforattribute) && $sm_in_cart=="fedex" && $params["shippingp"] == "storepickup")
          {  
                $comming_shipping_not_supported_by_cart = "no"; 
                $productname_array[] = $productName;
                $pn = implode(",", $productname_array);
                $message = "The shipping method ".$sm_comming." is going to overridden by shipping method  ".$sm_in_cart." which is not supported by ".$pn." products. Either place seprate order for this product or remove that product from cart.";

                   return $this->removeItemAndSetMessage($observer,$message);
                   
          }


                $sm_comming = $params["shippingp"];
                //$sm_in_cart  
                if($comming_shipping_not_supported_by_cart == "no" && isset($productname_array))
                {    
                   $pn = implode(",", $productname_array);
                   $message = "The shipping method ".$sm_comming." or set shipping method is not supported by ".$pn." products. Either place seprate order for this product or remove that product from cart.";
                   return $this->removeItemAndSetMessage($observer,$message);
                }
                //$d = true;
                //deliveryfromstore
             
                if($sm_in_cart == "fedex" && $sm_comming == 'storepickup')
                {
                   $params["shippingp"]="fedex";
                   $_POST["shippingp"]="fedex";
                }
                elseif($sm_in_cart == "fedex" && $sm_comming == 'deliveryfromstore')
                {    
                   $message = "The order has shipping method Fedex and you have selected method Store Delivery either you change this method in cart page or place seprate order for this product.";
                 return $this->removeItemAndSetMessage($observer,$message);
                }
                elseif($sm_in_cart == "storepickup" && $sm_comming == 'fedex')
                {    
                   $params["shippingp"]="fedex";
                   $_POST["shippingp"]="fedex";
                }
                elseif($sm_in_cart == "storepickup" && $sm_comming == 'deliveryfromstore')
                {    
                   $message = "The order has shipping method Store Pickup and you have selected method Store Delivery either you change this method in cart page or place seprate order for this product.";
                   return $this->removeItemAndSetMessage($observer,$message);
                }
                elseif($sm_in_cart == "deliveryfromstore" && $sm_comming == 'storepickup')
                {    
                   $message = "The order has shipping method Store Delivery and you have selected method Store Pickup either you change this method in cart page or place seprate order for this product.";
                   return $this->removeItemAndSetMessage($observer,$message);
                }
                elseif($sm_in_cart == "deliveryfromstore" && $sm_comming == 'fedex')
                {    
                   $message = "The order has shipping method Store Delivery and you have selected method Fedex either you change this method in cart page or place seprate order for this product.";
                   return $this->removeItemAndSetMessage($observer,$message);
                }
                else
                {    

                }    

}//if any item in cart
				    

				if(isset($_POST["shippingp"]))
				{	
					//Mage::log($_POST["shippingp"], null, 'myoblogfile.log');
				    //$item = $observer->getQuoteItem();
				    //$product = $observer->getProduct();
				    //$item->setCustomerShipping($_POST["shippingp"]);
                    //$quote = $observer->getEvent()->getQuote();
				    //Mage::log(print_r($item,true), null, 'myoblogfilef.log');
				    Mage::getSingleton("checkout/cart")->getQuote()->setCustomerShipping($_POST["shippingp"])->save();

			        //$quote->setCustomerShipping($_POST["shippingp"]);
			        //$quote->save();
				    $item = $observer->getEvent()->getQuoteItem();
				    //Mage::log(print_r($item,true), null, 'myoblogfilef.log');
			        $item->setData('customer_shipping', $_POST["shippingp"]);
			        $item->save();

			        
				}    
				    return $this;

			}
		
}
