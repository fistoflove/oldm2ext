<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Annex\Helper\Block\Rewrite;

use Magento\Catalog\Block\Navigation;

/**
 * Product details block.
 *
 * Holds a group of blocks to show as tabs.
 *
 * @api
 * @since 103.0.1
 */
class AnnexNavigation extends Navigation
{
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Catalog\Model\CategoryFactory $categoryFactory,
        \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $productCollectionFactory,
        \Magento\Catalog\Model\Layer\Resolver $layerResolver,
        \Magento\Framework\App\Http\Context $httpContext,
        \Magento\Catalog\Helper\Category $catalogCategory,
        \Magento\Framework\Registry $registry,
        \Magento\Catalog\Model\Indexer\Category\Flat\State $flatState,
        array $data = []
    ) {
        $this->_productCollectionFactory = $productCollectionFactory;
        $this->_catalogLayer = $layerResolver->get();
        $this->httpContext = $httpContext;
        $this->_catalogCategory = $catalogCategory;
        $this->_registry = $registry;
        $this->flatState = $flatState;
        $this->_categoryInstance = $categoryFactory->create();
        parent::__construct($context, $categoryFactory, $productCollectionFactory, $layerResolver, $httpContext, $catalogCategory, $registry, $flatState, $data);
    }

    public function sayHello()
    {
        return 'hello from AnneNavigation';
    }

    public function getChildren($_category)
    {
        $categories = $_category->getChildrenCategories();
        /** @var \Magento\Catalog\Model\ResourceModel\Product\Collection $productCollection */
        $productCollection = $this->_productCollectionFactory->create();
        $this->_catalogLayer->prepareProductCollection($productCollection);
        $productCollection->addCountToCategories($categories);
        return $categories;
    }
}
