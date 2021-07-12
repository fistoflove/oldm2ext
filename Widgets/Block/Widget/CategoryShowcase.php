<?php

namespace Annex\Widgets\Block\Widget;

use Magento\Framework\View\Element\Template;
use Magento\Widget\Block\BlockInterface;

class CategoryShowcase extends Template implements BlockInterface
{

    protected $_template = "widget/categoryshowcase.phtml";

    public function __construct(
        \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $productCollectionFactory,
        \Magento\Framework\View\Element\Template\Context $context
        ) {
            $this->_productCollectionFactory = $productCollectionFactory;
            parent::__construct($context);
     }

     public function sayHello()
     {   
         return "hello";
     }
     
    /**
     * @param \Magento\Catalog\Model\CategoryRepository $categoryRepository
     */
    public function getCategory(\Magento\Catalog\Model\CategoryRepository $categoryRepository) 
    {
        return $categoryRepository->get(215);
    }
}