<?php

namespace Annex\Helper\Block\Rewrite;

use Magento\Catalog\Block\Product\ListProduct as MagentoListProduct;

class ProductHelper extends MagentoListProduct
{

    public function __construct(
        \Magento\Catalog\Block\Product\Context $context,
        \Magento\Framework\Data\Helper\PostHelper $postDataHelper,
        \Magento\Catalog\Model\Layer\Resolver $layerResolver,
        \Magento\Catalog\Api\CategoryRepositoryInterface $categoryRepository,
        \Magento\Catalog\Api\ProductRepositoryInterface $productRepository,
        \Magento\Framework\Url\Helper\Data $urlHelper,
        \Magento\Customer\Model\Session $customerSession,
        \Mirasvit\RewardsCatalog\Helper\Earn $earnHelper,
        \Magento\Framework\Stdlib\DateTime\TimezoneInterface $localeDate,
        \Magento\Catalog\Model\Product $productModel,
        \Magento\Review\Model\Rating $ratingModel,
        \Magento\Review\Model\ReviewFactory $reviewFactory,
        \Magento\Variable\Model\Variable $customVar,
        array $data = []
    ) {
        $this->_catalogLayer = $layerResolver->get();
        $this->_postDataHelper = $postDataHelper;
        $this->categoryRepository = $categoryRepository;
        $this->productRepository = $productRepository;
        $this->urlHelper = $urlHelper;
        $this->customerSession = $customerSession;
        $this->earnHelper = $earnHelper;
        $this->localeDate = $localeDate;
        $this->customVar = $customVar;
        $this->productModel = $productModel;
        $this->ratingModel = $ratingModel;
        $this->reviewFactory = $reviewFactory;
        parent::__construct($context, $postDataHelper , $layerResolver, $categoryRepository, $urlHelper, $data);
    }

    public function sayHello()
    {
        echo "hello from ProductHelper";
    }

    public function lubeBlockId()
    {
        return $this->customVar->loadByCode('lube_product_block_id')->getPlainValue();
    }

    public function freeShippingValue()
    {
        return $this->customVar->loadByCode('free_shippings_value_threshold')->getPlainValue();
    }

    private function _thePoints($_product)
    {
        $customer = $this->customerSession->getCustomer();
        $website_id = $_product->getStore()->getWebsiteId();
        $points = $this->earnHelper->getProductPoints($_product, $customer, $website_id);
        return $points;
    }

    public function getTheData($_product)
    {
        $superAttributeList = [];
        $RatingOb = $this->ratingModel->getEntitySummary($_product->getId());
        $ratingCollection = $this->reviewFactory->create()->getResourceCollection()->addStatusFilter(\Magento\Review\Model\Review::STATUS_APPROVED)->addEntityFilter('product', $_product->getId());
        $review_count = count($ratingCollection);
        $r_sum = $RatingOb->getSum();
        $r_count = $RatingOb->getCount();
        $newsFromDate = $_product->getNewsFromDate();
        $newsToDate = $_product->getNewsToDate();
        $data = [
            "name"  => $_product->getName(),
            "price"     =>  $_product->getPrice(),
            "sprice"    => $_product->getSpecialPrice(),
            "fprice"    => $_product->getFinalPrice(),
            "url"       => $_product->getProductUrl(),
            "rcount"    =>  $review_count,
            "points"    => $this->_thePoints($_product),
            "new"       => (!$newsFromDate && !$newsToDate ? false : $this->localeDate->isScopeDateInInterval($_product->getStore(),$newsFromDate,$newsToDate)),
            "fship"     => ($_product->getFinalPrice() > $this->freeShippingValue() ? true : false)
        ];
        if ($data["price"] > $data["fprice"] ) {
            $data["pchange"] = round((1 - $data["fprice"] / $data["price"] ) * 100);
            $data["sale"]  =   true;
        } else {
            $data["pchange"] = 0;
            $data["sale"]  =  false;
        }

        if ($review_count == 0 || $r_sum == 0 || $r_count == 0) {
            $data["rating"] = 0;
        } else {
            $rating = $r_sum / $r_count;
            $data["rating"] = number_format(($rating / 100) * 5, 1);
        }

        if ($_product->getTypeId() != \Magento\ConfigurableProduct\Model\Product\Type\Configurable::TYPE_CODE) {
            $data["options"] = 0;
        } else {
            $productTypeInstance = $_product->getTypeInstance();
            $productTypeInstance->setStoreFilter($_product->getStoreId(), $_product);
            $attributes = $productTypeInstance->getConfigurableAttributes($_product);
            $_children = $_product->getTypeInstance()->getUsedProducts($_product);
            $superAttributeList = ["count" => count($_children),];
            foreach ($attributes as $_attribute) {
                $attributeCode = $_attribute->getProductAttribute()->getAttributeCode();
                $superAttributeList["name"] = $attributeCode;
            }
            $data["options"] = $superAttributeList["count"];
        }
        return $data;
    }
}
