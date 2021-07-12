<?php

namespace Annex\Helper\Block\Rewrite;

use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Framework\Exception\LocalizedException;

class ProductView extends \Magento\Catalog\Block\Product\View
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
        \Magento\Catalog\Block\Product\Context $context,
        \Magento\Framework\Url\EncoderInterface $urlEncoder,
        \Magento\Framework\Json\EncoderInterface $jsonEncoder,
        \Magento\Framework\Stdlib\StringUtils $string,
        \Magento\Catalog\Helper\Product $productHelper,
        \Magento\Framework\Registry $registry,
        \Magento\Catalog\Model\ProductTypes\ConfigInterface $productTypeConfig,
        \Magento\Framework\Locale\FormatInterface $localeFormat,
        \Magento\Customer\Model\Session $customerSession,
        ProductRepositoryInterface $productRepository,
        \Magento\Framework\Pricing\PriceCurrencyInterface $priceCurrency,
        \Magento\Variable\Model\Variable $customVar,
        \Annex\Helper\Block\Rewrite\ProductHelper $annexProductHelper,
        \Magento\Catalog\Model\CategoryFactory $categoryFactory,
        array $data = []
    ) {
        $this->_productHelper = $productHelper;
        $this->urlEncoder = $urlEncoder;
        $this->_jsonEncoder = $jsonEncoder;
        $this->productTypeConfig = $productTypeConfig;
        $this->string = $string;
        $this->registry = $registry;
        $this->_localeFormat = $localeFormat;
        $this->customerSession = $customerSession;
        $this->productRepository = $productRepository;
        $this->priceCurrency = $priceCurrency;
        $this->customVar = $customVar;
        $this->annexProductHelper = $annexProductHelper;
        $this->categoryFactory = $categoryFactory;
        parent::__construct($context, $urlEncoder, $jsonEncoder, $string, $productHelper, $productTypeConfig, $localeFormat, $customerSession, $productRepository, $priceCurrency, $data);
    }

    public function sayHello()
    {
        return 'hello from productview';
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

    public function lubeBlockId()
    {
        $block_id = $this->customVar->loadByCode('lube_product_block_id')->getPlainValue();
        return $block_id;
    }

    public function getTheData($product)
    {
        return $this->annexProductHelper->getTheData($product);
    }

    public function getUpSellCategories()
    {
        $upSellCategories = [];

        $productCategoriess = $this->_getProduct()->getCategoryIds();

        $powerType = $this->_getProduct()->getData('power_type');

        $aa = ["5544", "5545", "5546", "5557"];

        $aaa = ["5541", "5542", "5543", "5559", "5564", "5565"];

        if (in_array($powerType, $aa)) {

            array_push($upSellCategories, 662);

        } elseif (in_array($powerType, $aaa)) {

            array_push($upSellCategories, 668);

        }

        if (array_intersect([221], $productCategoriess)) { // Male Masturbator

            array_push($upSellCategories, 671); // Masturbators

        }

        if (array_intersect([216], $productCategoriess)) { // Anal Toys

            array_push($upSellCategories, 669); // Anal Lubricant

        }

        if (array_intersect([217, 220, 354], $productCategoriess)) { // Dildos, Vibrators, Ben Wa Balls

            array_push($upSellCategories, 652); // Lubricant

        }

        return array_unique($upSellCategories);

    }

    public function getUpSellProducts($cat_id)
    {
        $categoryProducts = $this->categoryFactory->create()->load($cat_id)->getProductCollection()->addAttributeToSelect('*');

        return $categoryProducts;
    }

    public function getBrandLink($_product)
    {
        $_product->getResource()->getAttribute('your_attribute_code')->getFrontend()->getValue($_product);
        return $block_id;
    }
}
