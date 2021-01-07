<?php
/**
 * @category  HS
 * @package   HS_ImageClean
 * @copyright Copyright (c) 2015 Hungersoft (http://www.hungersoft.com)
 * @license   http://www.hungersoft.com/license.txt Hungersoft General License
 */

namespace HS\ImageClean\Observer;

use Magento\Framework\Event\ObserverInterface;

class Register implements ObserverInterface
{
    /**
     * @var \HS\All\Helper\Data
     */
    protected $helper;

    /**
     * @param \HS\All\Helper\Data $helper
     * @SuppressWarnings(PHPMD.ExcessiveParameterList)
     */
    public function __construct(
        \HS\All\Helper\Data $helper
    ) {
        $this->helper = $helper;
    }

    /**
     * Register extension.
     *
     * @param \Magento\Framework\Event\Observer $observer
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $this->helper->register('HS_ImageClean', '1.1.1', 'confirm');
    }
}