<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Annex\Widgets\Block\Widget;

use Magento\Cms\Block\Widget\Block;


class StoreAlerts extends Block 
{

    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Cms\Model\Template\FilterProvider $filterProvider,
        \Magento\Cms\Model\BlockFactory $blockFactory,
        array $data = []
    ) {
        $this->_filterProvider = $filterProvider;
        $this->_blockFactory = $blockFactory;
        parent::__construct($context, $filterProvider, $blockFactory, $data);
    }

    public function sayHello() {
        return 'hello from store alerts';
    }
    

}