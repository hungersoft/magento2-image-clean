<?php

namespace HS\ImageClean\Controller\Adminhtml\image;

/**
 * Class MassDelete.
 */
class MassDelete extends \Magento\Backend\App\Action
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
     * @return \Magento\Backend\Model\View\Result\Redirect
     */
    public function execute()
    {
        $mediaRootDir = $this->directoryList->getPath('media');

        $itemIds = $this->getRequest()->getParam('image');
        if (!is_array($itemIds) || empty($itemIds)) {
            $this->messageManager->addError(__('Please select item(s).'));
        } else {
            try {
                foreach ($itemIds as $itemId) {
                    $image = $this->_objectManager->get('HS\ImageClean\Model\Image')->load($itemId);
                    $filePath = $mediaRootDir.'/catalog/product'.$image->getValue();
                    if ($this->file->isExists($filePath)) {
                        $this->file->deleteFile($filePath);
                    }
                    $image->delete();
                }
                $this->messageManager->addSuccess(
                    __('A total of %1 record(s) have been deleted.', count($itemIds))
                );
            } catch (\Exception $e) {
                $this->messageManager->addError($e->getMessage());
            }
        }

        return $this->resultRedirectFactory->create()->setPath('imageclean/*/index');
    }
}
