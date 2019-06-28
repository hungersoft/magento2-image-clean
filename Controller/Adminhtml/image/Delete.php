<?php

namespace HS\ImageClean\Controller\Adminhtml\image;

class Delete extends \Magento\Backend\App\Action
{
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\App\Filesystem\DirectoryList $directoryList,
        \Magento\Framework\Filesystem\Driver\File $file
    ) {
        $this->file = $file;
        $this->directoryList = $directoryList;
        parent::__construct($context);
    }

    /**
     * Delete action.
     *
     * @return \Magento\Backend\Model\View\Result\Redirect
     */
    public function execute()
    {
        $mediaRootDir = $this->directoryList->getPath('media');
        $id = $this->getRequest()->getParam('id');
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        if ($id) {
            try {
                $image = $this->_objectManager->get('HS\ImageClean\Model\Image')->load($id);
                $filePath = $mediaRootDir . '/catalog/product' . $image->getValue();
                if ($this->file->isExists($filePath)) {
                    $this->file->deleteFile($filePath);
                }
                $image->delete();

                $this->messageManager->addSuccess(__('The item has been deleted.'));

                return $resultRedirect->setPath('*/*/');
            } catch (\Exception $e) {
                $this->messageManager->addError($e->getMessage());
                return $resultRedirect->setPath('*/*/edit', ['value_id' => $id]);
            }
        }

        $this->messageManager->addError(__('We can\'t find a item to delete.'));
        return $resultRedirect->setPath('*/*/');
    }
}
