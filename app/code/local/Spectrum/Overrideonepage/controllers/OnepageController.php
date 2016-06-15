<?php
/**
 * Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magento.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magento.com for more information.
 *
 * @category    Mage
 * @package     Mage_Checkout
 * @copyright  Copyright (c) 2006-2015 X.commerce, Inc. (http://www.magento.com)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * Onepage controller for checkout
 *
 * @category    Mage
 * @package     Mage_Checkout
 * @author      Magento Core Team <core@magentocommerce.com>
 */
require_once "Mage/Checkout/controllers/OnepageController.php";
class Spectrum_Overrideonepage_OnepageController  extends Mage_Checkout_OnepageController
{
    

    /**
     * Get shipping method step html
     *
     * @return string
     */
    protected function _getShippingMethodsHtml()
    {
        $layout = $this->getLayout();
        $update = $layout->getUpdate();
        $update->load('checkout_onepage_shippingmethod');
        $layout->generateXml();
        $layout->generateBlocks();
        $output = $layout->getOutput();
        
        $max_distance_from_store = Mage::getStoreConfig('locdistance/locdistancegrp/maxlocdistancec', $storeId);
        $latitude1 = Mage::getSingleton('core/session')->getLat1();
        $longitude1 = Mage::getSingleton('core/session')->getLong1();
        $location = Mage::getSingleton('core/session')->getAllstoresnewdatapicthree();

        $allstores = $location;
        //<--------------------------------->
        if($latitude1 != "" && $longitude1 != "")
        {    
                $allstoresnewdata = array();
                if(isset($allstores) && $allstores)
                {
                       foreach($allstores as $key => $val)
                       { 
                         $val["storedistancefromuserforshipping"] = round(distance($latitude1, $longitude1, $val["store_latitude"], $val["store_longitude"], "M"), 2);
                         $allstoresnewdata[] = $val;
                       } 
                    }

                if(isset($allstoresnewdata) && $allstoresnewdata)
                { 
                    foreach($allstoresnewdata as $key => $val)
                    {
                        if($val["storedistancefromuserforshipping"]<=$max_distance_from_store)
                        {
                           $storedistancefromuserforshipping[] = $val;
                           $storedistancefromuserforshippingsortingkey[] = $val["storedistancefromuserforshipping"];
                        }
                    }
                    if(isset($storedistancefromuserforshippingsortingkey))
                    {   
                        array_multisort($storedistancefromuserforshippingsortingkey, SORT_ASC, $storedistancefromuserforshipping);
                    }
                }     

                if(isset($storedistancefromuserforshippingsortingkey) && $storedistancefromuserforshippingsortingkey)
                {   
                    //Mage::log(print_r($storedistancefromuserforshipping,true), null, 'mylogfile88.log');
                    $additionoutput = "<p>Store delivery shipping method not available for selected location. You need to select a different store.</p><p>Select Store : <select class='c_change_store' onchange='changestore(this)'><option value=''>Please Select Store</option>";
                        
                        foreach($storedistancefromuserforshipping as $key => $val)
                        {
                          $additionoutput = $additionoutput."<option value='".$val["store_id"]."'>".$val["store_name"]."</option>";        
                        }
                    $additionoutput = $additionoutput."</select></p>"; 
                    
                    $output = $output.$additionoutput;
                    Mage::getSingleton('core/session')->setLat1("");
                    Mage::getSingleton('core/session')->setLong1("");
                }

                //Mage::log(print_r($output,true), null, 'mylogfile77.log');
         }       
        //<--------------------------------->
        return $output;
    }

   
}
