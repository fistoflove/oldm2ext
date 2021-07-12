<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

declare(strict_types=1);

namespace Annex\Helper\Block\Rewrite;

use Magento\Catalog\Model\Product;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Registry;
use Magento\Framework\View\Element\Template;

/**
 * Product details block.
 *
 * Holds a group of blocks to show as tabs.
 *
 * @api
 * @since 103.0.1
 */
class AnnexDetails extends \Magento\Catalog\Block\Product\View\Details
{

    /**
     * @var Registry
     */
    protected $registry;

    /**
     * @var Product
     */
    private $product;

    public function __construct(
        Template\Context $context,
        Registry $registry, 
        \Annex\Helper\Block\Rewrite\ProductHelper $annexProductHelper,
        array $data)
    {
    $this->annexProductHelper = $annexProductHelper;
    $this->registry = $registry;

    parent::__construct($context, $data);
    }
    
    public function sayHello()
    {
        return 'hello from Annex Details';
    }

    private function _getProduct()
    {
        if (is_null($this->product)) {
            $this->product = $this->registry->registry('product');

            if (!$this->product->getId()) {
                throw new LocalizedException(__('Failed to initialize product'));
            }
        }

        return $this->product;
    }

    public function getProductName()
    {
        return $this->_getProduct()->getId();
    }

    public function getTheData()
    {
        return $this->annexProductHelper->getTheData($this->_getProduct());
    }
}
