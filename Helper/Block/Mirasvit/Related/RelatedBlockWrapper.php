<?php
/**
 * Mirasvit
 *
 * This source file is subject to the Mirasvit Software License, which is available at https://mirasvit.com/license/.
 * Do not edit or add to this file if you wish to upgrade the to newer versions in the future.
 * If you wish to customize this module for your needs.
 * Please refer to http://www.magentocommerce.com for more information.
 *
 * @category  Mirasvit
 * @package   mirasvit/module-related
 * @version   1.0.8
 * @copyright Copyright (C) 2020 Mirasvit (https://mirasvit.com/)
 */



namespace Annex\Helper\Block\Mirasvit\Related;

use Magento\Framework\View\Element\Template;
use Mirasvit\Related\Api\Data\BlockInterface;
use Mirasvit\Related\Repository\BlockRepository;

class RelatedBlockWrapper extends Template
{
    protected $_template = 'Mirasvit_Related::block-wrapper.phtml';

    private $blockRepository;

    public function __construct(
        BlockRepository $blockRepository,
        Template\Context $context,
        array $data = []
    ) {
        $this->blockRepository = $blockRepository;

        parent::__construct($context, $data);
    }

    public function getBlockId()
    {
        return $this->getData(BlockInterface::ID);
    }

    private function getBlock()
    {
        return $this->blockRepository->get($this->getBlockId());
    }

    public function getInstanceHtml()
    {
        $block = $this->getBlock();

        if (!$block) {
            return false;
        }

        if (!$block->isActive()) {
            return false;
        }

        /** @var Block $instance */
        $instance = $this->_layout->createBlock(Block::class);

        $instance->setData(BlockInterface::class, $block);

        return trim($instance->toHtml());
    }
}
