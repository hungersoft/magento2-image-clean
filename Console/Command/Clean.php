<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace HS\ImageClean\Console\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Helper\ProgressBar;

class Clean extends Command
{
    /**
     * @var \HS\ImageClean\Model\imageFactory
     */
    protected $_imageFactory;

    public function __construct(
        \HS\ImageClean\Model\ImageFactory $ImageFactory,
        \Magento\Framework\App\Filesystem\DirectoryList $directoryList,
        \Magento\Framework\Filesystem\Driver\File $file
    ) {
        $this->_imageFactory = $ImageFactory;
        $this->file = $file;
        $this->directoryList = $directoryList;
        parent::__construct();
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(
        InputInterface $input,
        OutputInterface $output
    ) {
        $mediaRootDir = $this->directoryList->getPath('media');

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
        
        ProgressBar::setFormatDefinition('custom', ' %current%/%max% -- %message%');
        $progressBar = new ProgressBar($output, $collection->getSize());
        $progressBar->setFormat('custom');
        $progressBar->start();
        foreach ($unlinkedImageCollection as $image) {
            $filePath = $mediaRootDir.'/catalog/product'.$image->getValue();
            $progressBar->setMessage('Deleting ' . $filePath . '...');
            if ($this->file->isExists($filePath)) {
                $this->file->deleteFile($filePath);
            }
            $image->delete();
            $progressBar->advance();
        }
        $progressBar->finish();
    }

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->setName("hs:imageclean:clean");
        $this->setDescription("Clean unused product images");
        parent::configure();
    }
}