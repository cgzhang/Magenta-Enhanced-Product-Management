<?php
class Rayfox_EPMS_Block_Adminhtml_Product_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
	public function __construct()
    {
        $this->_objectId = 'id';
        $this->_controller = 'enhancedproduct';
        $this->_blockGroup = 'rayfox_epms';
        parent::__construct();
        $this->_updateButton('reset', 'style', 'display:none');
        $this->_updateButton('back', 'style', 'display:none');
        $this->_updateButton('save', 'style', 'display:none');
        $this->_addButton('savecontinue', array(
            'label' => Mage::helper('adminhtml')->__('Upload file (csv format)'),
            'onclick' => "$('edit_form').action += 'continue/true/'; editForm.submit();",
            'class' => 'save',
        ), -1);
        $this->_addButton('Manage', array(
            'label'     => Mage::helper('adminhtml')->__('Search Products'),
            'onclick'   => 'setLocation(\'' . $this->getUrl('*/*/search') . '\')',
            'class'     => 'saveandcontinue',
        ), -1);
        $this->_addButton('Reset', array(
            'label'     => Mage::helper('adminhtml')->__('Reset'),
            'onclick'   => 'setLocation(\'' . $this->getUrl('*/*/reset') . '\')',
            'class'     => 'cancel',
        ), -1);
    }

    public function getHeaderText()
    {
        return Mage::helper('adminhtml')->__('Manage Products By Upload');
    }

    protected function _prepareLayout()
    {
        if ($this->_blockGroup && $this->_controller && $this->_mode) {
            $this->setChild('form', $this->getLayout()->createBlock($this->_blockGroup . '/adminhtml_product_' . $this->_mode . '_form'));
        }
        return parent::_prepareLayout();
    }
}