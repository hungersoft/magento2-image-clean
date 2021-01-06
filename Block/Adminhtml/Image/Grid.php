<?php

namespace HS\ImageClean\Block\Adminhtml\Image;

class Grid extends \Magento\Backend\Block\Widget\Grid\Extended
{
    /**
     * @var \Magento\Framework\Module\Manager
     */
    protected $moduleManager;

    /**
     * @var \HS\ImageClean\Model\imageFactory
     */
    protected $_imageFactory;

    /**
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Backend\Helper\Data            $backendHelper
     * @param \HS\ImageClean\Model\imageFactory       $imageFactory
     * @param \Magento\Framework\Module\Manager       $moduleManager
     * @param array                                   $data
     *
     * @SuppressWarnings(PHPMD.ExcessiveParameterList)
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Backend\Helper\Data $backendHelper,
        \HS\ImageClean\Model\ImageFactory $ImageFactory,
        \Magento\Framework\Module\Manager $moduleManager,
        array $data = []
    ) {
        $this->_imageFactory = $ImageFactory;
        $this->moduleManager = $moduleManager;
        parent::__construct($context, $backendHelper, $data);
    }

    /**
     */
    protected function _construct()
    {
        parent::_construct();
        $this->setId('postGrid');
        $this->setDefaultSort('value_id');
        $this->setDefaultDir('DESC');
        $this->setSaveParametersInSession(true);
        $this->setUseAjax(false);
        $this->setVarNameFilter('post_filter');
    }

    /**
     * @return $this
     */
    protected function _prepareCollection()
    {        
        $linkedImagePathCollection = $this->_imageFactory->create()->getCollection();
        $linkedImagePathCollection->getSelect()
            ->reset(\Zend_Db_Select::COLUMNS)
            ->columns(['value'])
            ->joinLeft(
                ['emgve' => $linkedImagePathCollection->getTable('catalog_product_entity_media_gallery_value_to_entity')],
                'main_table.value_id=emgve.value_id',
                []
            )->where('emgve.value_id IS NOT NULL');
        
        $unlinkedImageCollection = $this->_imageFactory->create()->getCollection();
        $unlinkedImageCollection->getSelect()->where(
            'main_table.value NOT IN (
                ' . $linkedImagePathCollection->getSelect() . '
            )'
        );
        
        $this->setCollection($unlinkedImageCollection);

        parent::_prepareCollection();

        return $this;
    }

    /**
     * @return $this
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    protected function _prepareColumns()
    {
        $this->addColumn(
            'value_id',
            [
                'header' => __('ID'),
                'type' => 'number',
                'index' => 'value_id',
                'header_css_class' => 'col-id',
                'column_css_class' => 'col-id',
            ]
        );

        $this->addColumn(
            'value',
            [
                'header' => __('Path'),
                'index' => 'value',
            ]
        );

        $this->addColumn(
            'image',
            array(
                'header' => __('Image'),
                'index' => 'value',
                'renderer' => '\HS\ImageClean\Block\Adminhtml\Image\Grid\Renderer\Image',
            )
        );

        $this->addColumn('action', array(
            'header' => __('Action'),
            'type' => 'action',
            'getter' => 'getValueId',
            'actions' => array(
                array(
                    'caption' => __('Delete'),
                    'url' => array('base' => 'imageclean/image/delete'),
                    'field' => 'value_id',
                ),
            ),
            'renderer' => 'HS\ImageClean\Block\Adminhtml\Image\Grid\Renderer\Action',
            'index' => 'value_id',
        ));

        $block = $this->getLayout()->getBlock('grid.bottom.links');
        if ($block) {
            $this->setChild('grid.bottom.links', $block);
        }

        return parent::_prepareColumns();
    }

    /**
     * @return $this
     */
    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('value_id');
        $this->getMassactionBlock()->setFormFieldName('image');

        $this->getMassactionBlock()->addItem(
            'delete',
            [
                'label' => __('Delete'),
                'url' => $this->getUrl('imageclean/*/massDelete'),
                'confirm' => __('Are you sure?'),
            ]
        );

        return $this;
    }

    /**
     * @return string
     */
    public function getGridUrl()
    {
        return $this->getUrl('imageclean/*/index', ['_current' => true]);
    }

    /**
     * @param \HS\ImageClean\Model\image|\Magento\Framework\Object $row
     *
     * @return string
     */
    public function getRowUrl($row)
    {
        return '#';
    }
}