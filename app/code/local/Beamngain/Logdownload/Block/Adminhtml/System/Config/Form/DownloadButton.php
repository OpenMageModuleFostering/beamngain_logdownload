<?php

class Beamngain_Logdownload_Block_Adminhtml_System_Config_Form_DownloadButton extends Mage_Adminhtml_Block_System_Config_Form_Field {
    
    /**
     * Set template
     */

    protected function _construct() {
        parent::_construct();
        $this->setTemplate('beamngain/system/config/form/download_button.phtml');
    }

    /**
     * Return element html
     *
     * @param  Varien_Data_Form_Element_Abstract $element
     * @return string
     */
    protected function _getElementHtml(Varien_Data_Form_Element_Abstract $element) {
        return $this->_toHtml();
    }

    /**
     * Generate button html
     *
     * @return string
     */
    public function getButtonHtml() {
        $button = $this->getLayout()->createBlock('adminhtml/widget_button')->setData(array('id' => 'locayta_log_download_button', 'label' => Mage::helper('logdownload')->__('Download Log File'), 'onclick' => 'javascript:download_log_file(); return false;'));

        return $button->toHtml();
    }

    /**
     * Return log check url for button
     *
     * @return string
     */
    public function getAjaxUrl() {
        return Mage::helper("adminhtml")->getUrl("adminhtml/logdownload_log/check");
    }


    /**
     * Return log download url for button
     *
     * @return string
     */
    public function getDownloadUrl() {
        return Mage::helper("adminhtml")->getUrl("adminhtml/logdownload_log/download");
    }
}
