<?php

namespace Annex\Helper\Block;

use Magento\Customer\CustomerData\SectionSourceInterface;
use Mirasvit\Rewards\Helper\Balance;
use Magento\Customer\Model\Session;
use Mirasvit\Rewards\Helper\Data as DataHelper;
use Mirasvit\Rewards\Model\Config;

class Menu extends \Magento\Framework\View\Element\Template
{

	public function sayHello()
	{
		return __('Hello World');
    }
    public function getWelcome()
    {
        return $this->_layout->getBlock('header')->getWelcome();
    }
}
