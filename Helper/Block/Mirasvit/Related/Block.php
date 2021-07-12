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

use Magento\Catalog\Block\Product\AbstractProduct;
use Magento\Catalog\Block\Product\Context;
use Mirasvit\Related\Api\Data\BlockInterface;
use Mirasvit\Related\Service\ProductFinderService;

class Block extends AbstractProduct
{
    private $productFinderService;


    public function __construct(
        ProductFinderService $productFinderService,
        \Annex\Helper\Block\Rewrite\ProductHelper $productHelper,
        Context $context,
        array $data = []
    ) {
        $this->productHelper = $productHelper;
        $this->productFinderService = $productFinderService;

        parent::__construct($context, $data);
    }

    public function getTemplate()
    {
        return $this->getBlock()->getDisplayTemplate();
    }

    /**
     * @return BlockInterface
     */
    public function getBlock()
    {
        return $this->getData(BlockInterface::class);
    }

    public function getTitle()
    {
        return $this->getBlock()->getDisplayTitle();
    }

    /**
     * Theme compatibility
     * @return \Magento\Catalog\Model\ResourceModel\Product\Collection
     */
    public function getItemCollection()
    {
        return $this->getProducts();
    }

    public function getProducts()
    {
        return $this->productFinderService->getProducts($this->getBlock());
    }

    public function getItemLimit()
    {
        return intval($this->getData('item_limit'));
    }

    public function getTheData($_product)
    {
        return $this->productHelper->getTheData($_product);
    }

    public function getAddToCartPostParams($_product)
    {
        return $this->productHelper->getAddToCartPostParams($_product);
    }
    public function getProductDetailsHtml($_product)
    {
        return $this->productHelper->getProductDetailsHtml($_product);
    }
}
