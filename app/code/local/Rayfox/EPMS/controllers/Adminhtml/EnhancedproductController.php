<?php
class Rayfox_EPMS_Adminhtml_EnhancedProductController extends Mage_Adminhtml_Controller_Action
{
	public function indexAction()
	{
		$this->loadLayout();
		$this->_setActiveMenu('catalog/products');
		$this->_addContent(
			$this->getLayout()->createBlock('rayfox_epms/adminhtml_product_edit')
		);
		$this->_addLeft($this->getLayout()->createBlock('rayfox_epms/adminhtml_product_edit_tabs'));
		$this->_initLayoutMessages('catalog/session');
		$this->renderLayout();
	}

	public function saveAction()
	{
		try {
            $uploader = new Varien_File_Uploader('enhanced_manage_product_csv_file');
            $uploader->setAllowedExtensions(array('csv'));
            $path = Mage::app()->getConfig()->getTempVarDir().'/import/';
            try {
                $result = $uploader->save($path , 'products_uploaded.csv');
                if ($uploadFile = $uploader->getUploadedFileName()) {
                    Mage::getSingleton('catalog/session')->addNotice('Files upload success and was saved in '.$path.$uploadFile);
                } else {
                    Mage::getSingleton('catalog/session')->addError($this->__('Cannot get file name'));
                }
            } catch (Exception $e) {
            	Mage::logException($e);
                Mage::getSingleton('catalog/session')->addError($e->getMessage());
            }
        }catch(Exception $e) {
        	Mage::logException($e);
            Mage::getSingleton('catalog/session')->addError($this->__($e->getMessage()));
        }
        
        $this->_redirect('*/*');
	}

	public function searchAction()
	{
		$csvFile = Mage::app()->getConfig()->getTempVarDir().'/import/products_uploaded.csv';
    	
    	$csv = new Varien_File_Csv();
    	$rawData = $csv->getData($csvFile);
    	
    	if(!$this->_validateCSVRawData($rawData)){
    		Mage::getSingleton('catalog/session')->addError('Invalidate CSV file.');
    		return $this->_redirect('*/*');
    	}
    	
    	$firstRow = array_shift($rawData);
    	$productAttributeCode = array_shift($firstRow);

    	$filterData = array();
    	foreach($rawData as $data) {
    		$filterData[] = array_shift($data);
    	}
    	//Mage::register('preparedFilter', $filterData);
    	Mage::getSingleton('adminhtml/session')->setData('preparedAttribute', $productAttributeCode);
    	Mage::getSingleton('adminhtml/session')->setData('preparedFilter', $filterData);
    	$this->_forward('index', 'enhancedproduct', null, array('active_tab' => 'product_grid'));
	}

	public function gridAction()
    {
        $this->loadLayout();
        $this->renderLayout();
    }

    public function resetAction()
    {
    	Mage::getSingleton('adminhtml/session')->setData('preparedAttribute', false);
    	Mage::getSingleton('adminhtml/session')->setData('preparedFilter', false);
    	$this->_redirect('*/*');
    }

	protected function _validateCSVRawData($rawData)
    {
    	Mage::log($rawData);
    	return is_array($rawData) && count($rawData) > 1;
    }
}