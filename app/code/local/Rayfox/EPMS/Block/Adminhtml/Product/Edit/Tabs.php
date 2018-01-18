<?php
class Rayfox_EPMS_Block_Adminhtml_Product_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{
	public function __construct()
    {
        parent::__construct();
        $this->setId('enhanced_product_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('adminhtml')->__('Manage Products By Upload'));
    }

    protected function _beforeToHtml()
    {
        $this->addTab('upload', array(
            'label'     => Mage::helper('adminhtml')->__('Upload File'),
            'content'   => $this->getLayout()->createBlock('rayfox_epms/adminhtml_product_edit_tab_upload')->toHtml(),
        ));
        if(Mage::getSingleton('adminhtml/session')->getData('preparedFilter')) {
            $this->addTab('product_grid', array(
                'label' => Mage::helper('adminhtml')->__('Manage Products'),
                'content'   => $this->getLayout()->createBlock('rayfox_epms/adminhtml_product_edit_tab_product_grid')->toHtml(),
            ));    
        }
        return parent::_beforeToHtml();
    }
}