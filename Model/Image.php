<?php

namespace HS\ImageClean\Model;

class Image extends \Magento\Framework\Model\AbstractModel
{
    /**
     * Initialize resource model.
     */
    protected function _construct()
    {
        $this->_init('HS\ImageClean\Model\ResourceModel\Image');
    }
}
