<?php

namespace HS\ImageClean\Block\Adminhtml\Image\Grid\Renderer;

class Image extends \Magento\Backend\Block\Widget\Grid\Column\Renderer\AbstractRenderer
{
    protected $_storeManager;

    public function __construct(
        \Magento\Backend\Block\Context $context,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->_storeManager = $storeManager;
    }

    public function render(\Magento\Framework\DataObject $row)
    {
        $mediaDirectory = $this->_storeManager->getStore()->getBaseUrl(
           \Magento\Framework\UrlInterface::URL_TYPE_MEDIA
        );
        if ($this->_getValue($row) != '') {
            $imageUrl = $mediaDirectory.'/catalog/product'.$this->_getValue($row);

            return '<img src="'.$imageUrl.'" width="100" />';
        }

        return __('No image');
    }
}
