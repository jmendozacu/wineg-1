<?php
class Spectrum_Ordersavebefore_Model_Observer
{

			public function saveCustomData(Varien_Event_Observer $observer)
			{
				//Mage::dispatchEvent('admin_session_user_login_success', array('user'=>$user));
				//$user = $observer->getEvent()->getUser();
				//$user->doSomething();
				$event = $observer->getEvent();
                $order = $event->getOrder();
                $location = Mage::getSingleton('core/session')->getAllstoresnewdatapicthree();
                $shipping =  Mage::getSingleton('checkout/session')->getQuote()->getShippingAddress()->getShippingMethod();

                if ($location != "" && $shipping =="deliveryfromstore_deliveryfromstore") 
                {

	                $location = current($location);
	                $output = $location["store_name"]." ".$location["address"]." ".$location["city"]." ".$location["zipcode"];
	                
	                //Mage::log(print_r($a,true), null, 'mylogfile.log');


	                //$fieldVal = Mage::app()->getFrontController()->getRequest()->getParams();
	                $order->setDeliveryfrom($output);

                }
			}
		
}
