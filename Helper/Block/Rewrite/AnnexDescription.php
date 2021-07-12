<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

/**
 * Product description block
 *
 * @author     Magento Core Team <core@magentocommerce.com>
 */
namespace Annex\Helper\Block\Rewrite;

use Magento\Catalog\Model\Product;

/**
 * @api
 * @since 100.0.2
 */
class AnnexDescription extends \Magento\Framework\View\Element\Template
{
    /**
     * @var Product
     */
    protected $_product = null;

    /**
     * Core registry
     *
     * @var \Magento\Framework\Registry
     */
    protected $_coreRegistry = null;

    /**
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Variable\Model\Variable $customVar,
        array $data = []
    ) {
        $this->_coreRegistry = $registry;
        $this->customVar = $customVar;
        parent::__construct($context, $data);
    }

    /**
     * @return Product
     */
    public function getProduct()
    {
        if (!$this->_product) {
            $this->_product = $this->_coreRegistry->registry('product');
        }
        return $this->_product;
    }

    public function getCustomVarPlain($var_name)
    {
        return $this->customVar->loadByCode($var_name)->getPlainValue();
    }

    public function getCustomVarHtml($var_name)
    {
        return $this->customVar->loadByCode($var_name)->getHtmlValue();
    }
}
