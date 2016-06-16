<?php


$installer = $this;
$installer->startSetup();
$attribute  = array(
        'type'          => 'text',
        'backend_type'  => 'text',
        'frontend_input' => 'text',
        'is_user_defined' => true,
        'label'         => 'Delivery From Store',
        'visible'       => true,
        'required'      => false,
        'user_defined'  => false,   
        'searchable'    => false,
        'filterable'    => false,
        'comparable'    => false,
        'default'       => ''
);

$installer->addAttribute("order", "deliveryfrom", $attribute);
$installer->endSetup();
	 