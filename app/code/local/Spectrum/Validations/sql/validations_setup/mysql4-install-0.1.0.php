<?php
$installer = $this;
//$installer->startSetup();
/*$sql=<<<SQLTEXT
create table tablename(tablename_id int not null auto_increment, name varchar(100), primary key(tablename_id));
    insert into tablename values(1,'tablename1');
    insert into tablename values(2,'tablename2');
		
SQLTEXT;*/

//$installer->run($sql);
//demo 
//Mage::getModel('core/url_rewrite')->setId(null);
//demo 
$installer = $this;
$installer->getConnection()->addColumn($this->getTable('sales_flat_quote_item'), 'customer_shipping', 'varchar(255) NOT NULL');
$installer->getConnection()->addColumn($this->getTable('sales_flat_order_item'), 'customer_shipping', 'varchar(255) NOT NULL');
//$installer->getConnection()->addColumn($this->getTable('sales_flat_quote'), 'customer_shipping', 'varchar(255) NOT NULL');
//$installer->getConnection()->addColumn($this->getTable('sales_flat_order'), 'customer_shipping', 'varchar(255) NOT NULL');
$installer->endSetup();

//$installer->endSetup();
	 