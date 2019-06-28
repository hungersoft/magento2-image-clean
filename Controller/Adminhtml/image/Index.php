<?php

namespace HS\ImageClean\Controller\Adminhtml\image;

use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;

class Index extends \Magento\Backend\App\Action
{
    /**
     * @var PageFactory
     */
    protected $resultPagee;

    /**
     * @param Context     $context
     * @param PageFactory $resultPageFactory
     */
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
    }

    /**
     * Index action.
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('HS_ImageClean::image');
        $resultPage->addBreadcrumb(__('HS'), __('HS'));
        $resultPage->addBreadcrumb(__('Manage item'), __('Manage unused product images'));
        $resultPage->getConfig()->getTitle()->prepend(__('Manage unused product images'));

        return $resultPage;
    }
}
