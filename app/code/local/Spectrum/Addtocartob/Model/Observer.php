<?php
class Spectrum_Addtocartob_Model_Observer
{

			public function setAddtocartAttribute(Varien_Event_Observer $observer)
			{
				//Mage::dispatchEvent('admin_session_user_login_success', array('user'=>$user));
				//$user = $observer->getEvent()->getUser();
				//$user->doSomething();
				//Mage::log(print_r($_GET,true), null, 'myoblogfilef.log');
				//Mage::log(print_r($_POST,true), null, 'myoblogfilefxx.log');

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
