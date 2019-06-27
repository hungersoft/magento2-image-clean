<?php

namespace HS\ImageClean\Block\Adminhtml;

class Image extends \Magento\Backend\Block\Widget\Container
{
    /**
     * @var string
     */
    protected $_template = 'image/image.phtml';

    /**
     * @param \Magento\Backend\Block\Widget\Context $context
     * @param array                                 $data
     */
    public function __construct(\Magento\Backend\Block\Widget\Context $context, array $data = [])
    {
        parent::__construct($context, $data);
    }

    /**
     * Prepare button and grid.
     *
     * @return \Magento\Catalog\Block\Adminhtml\Product
     */
    protected function _prepareLayout()
    {
        $this->setChild(
            'grid',
            $this->getLayout()->createBlock('HS\ImageClean\Block\Adminhtml\Image\Grid', 'hs.image.grid')
        );

        return parent::_prepareLayout();
    }

    /**
     * @return array
     */
    protected function _getAddButtonOptions()
    {
        $splitButtonOptions[] = [
            'label' => __('Add New'),
            'onclick' => "setLocation('".$this->_getCreateUrl()."')",
        ];

        return $splitButtonOptions;
    }

    /**
     * @param string $type
     *
     * @return string
     */
    protected function _getCreateUrl()
    {
        return $this->getUrl(
            'imageclean/*/new'
        );
    }

    /**
     * Render grid.
     *
     * @return string
     */
    public function getGridHtml()
    {
        return $this->getChildHtml('grid');
    }
}
