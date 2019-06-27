<?php

namespace HS\ImageClean\Model\ResourceModel;

class Image extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    /**
     * Initialize resource model.
     */
    protected function _construct()
    {
        $this->_init('catalog_product_entity_media_gallery', 'value_id');
    }
}
