<?php
class Spectrum_Decshipping_Model_Shipping_Shipping extends Mage_Shipping_Model_Shipping
{


	public function collectCarrierRates($carrierCode, $request)
    {
        if (!$this->_isAvailable($carrierCode, $request)) {
           return $this;
        }
        return parent::collectCarrierRates($carrierCode, $request);
    }

    /**
     * @param string $carrierCode
     * @param Varien_Object $request
     * @return bool
     */
    protected function _isAvailable($carrierCode, $request)
    {
        $regionCode = $request->getDestRegionCode();
        
       //$distance = Mage::getSingleton('core/session')->getStoredeliverydistance();
       //$max_distance_from_store = Mage::getStoreConfig('locdistance/locdistancegrp/maxlocdistancec', $storeId);

     $location = Mage::getSingleton('core/session')->getAllstoresnewdatapicthree();

     $customerData= array(
                 
                 'street' =>Mage::getSingleton('checkout/session')->getQuote()->getShippingAddress()->getStreet(), 
                 'city'=>Mage::getSingleton('checkout/session')->getQuote()->getShippingAddress()->getCity(),
                 'state' =>Mage::getSingleton('checkout/session')->getQuote()->getShippingAddress()->getRegion(),
                 'countryid' =>Mage::getSingleton('checkout/session')->getQuote()->getShippingAddress()->getCountryId(),
                 'postcode'=>Mage::getSingleton('checkout/session')->getQuote()->getShippingAddress()->getPostcode()

           );

       $customerData["street"] = implode(",+", $customerData["street"]);
       $customerData["street"] = str_replace(" ", "+", $customerData["street"]);

       $address = $customerData["street"].",+".$customerData["city"].",+".$customerData["state"].",+".$customerData["countryid"].",+".$customerData["postcode"];
        $location = current($location);
        $lat2 = $location["store_latitude"];
        $long2 = $location["store_longitude"];
        //Mage::log($address, null, 'mylogfile.log');
    /* static $distance = 0; 
     static $call_counter = 0;
     if ( $call_counter == 0 ) 
     {
        //Mage::log($shipping_address, null, 'mylogfile.log');
        
        //http://maps.google.com/maps/api/geocode/json?address=573/1,+Jangli+Maharaj+Road,+Deccan+Gymkhana,+Pune,+Maharashtra,+India&sensor=false%27); 
        $url = 'http://maps.google.com/maps/api/geocode/json?address='.$data.'&sensor=false';
        
        $data = @file_get_contents($url);
        sleep(1);
        $output = json_decode($data);
        $lat1 = $output->results[0]->geometry->location->lat;
        $long1 = $output->results[0]->geometry->location->lng;
        Mage::log($url.$lat1.$long1, null, 'mylogfile1.log');
       

        $distance = $this->GetDrivingDistance($lat1, $lat2, $long1, $long2);
        Mage::log(print_r($output,true), null, 'mylogfile3.log'); 
     }
     Mage::log($distance, null, 'mylogfile2.log'); 
     $call_counter++;*/


     static $max_distance_from_store = 0; 
     static $call_counter = 0;
     static $distance = 0;
     if ( $call_counter == 0 ) 
     {
     $storeId = Mage::app()->getStore()->getStoreId();
     $max_distance_from_store = Mage::getStoreConfig('locdistance/locdistancegrp/maxlocdistancec', $storeId);
     $burl = str_replace("index.php","",Mage::getBaseUrl());
     $url = $burl."getdist.php?lat2=".$lat2."&long2=".$long2."&address=".urlencode($address);
     //$url = urlencode($url);
     //Mage::log(print_r($url,true), null, 'mylogfile66.log');
     $data = @file_get_contents($url);
     $data = explode(",",$data);
     $distance = round(current($data));
     if ($distance > $max_distance_from_store) {
        Mage::getSingleton('core/session')->setLat1(next($data));
        Mage::getSingleton('core/session')->setLong1(next($data));
     }
     
     Mage::log(print_r($data,true), null, 'mylogfile55.log');
     }
     
     $call_counter++;

        switch ($carrierCode) {
            case 'deliveryfromstore':
                if ($distance > $max_distance_from_store) {
                return false;
                }
                break;
           /* case 'freeshipping':
                if ($regionCode == 'abc') {
                    return false;
                }
                break;*/
        }
        return true;
    }

   

}
		