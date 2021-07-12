<?php

namespace Annex\Helper\Block\Rewrite;

use Magento\Catalog\Block\Product\ListProduct as MagentoListProduct;

class ListProduct extends MagentoListProduct
{

    public function __construct(
        \Magento\Catalog\Block\Product\Context $context,
        \Magento\Framework\Data\Helper\PostHelper $postDataHelper,
        \Magento\Catalog\Model\Layer\Resolver $layerResolver,
        \Magento\Catalog\Api\CategoryRepositoryInterface $categoryRepository,
        \Magento\Framework\Url\Helper\Data $urlHelper,
        \Magento\Framework\Stdlib\DateTime\TimezoneInterface $localeDate,
        \Annex\Helper\Block\Rewrite\ProductHelper $annexProductHelper,
        array $data = []
    ) {
        $this->_catalogLayer = $layerResolver->get();
        $this->_postDataHelper = $postDataHelper;
        $this->categoryRepository = $categoryRepository;
        $this->urlHelper = $urlHelper;
        $this->localeDate = $localeDate;
        $this->annexProductHelper = $annexProductHelper;
        parent::__construct($context, $postDataHelper , $layerResolver, $categoryRepository, $urlHelper, $data);
    }

    public function getProductData($_product_id)
    {
        return $this->annexProductHelper->getTheData($_product_id);
    }
}
