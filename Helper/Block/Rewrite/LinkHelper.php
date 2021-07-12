<?php

namespace Annex\Helper\Block\Rewrite;

use Magento\Framework\View\Element\Template;

class LinkHelper extends Template
{

    public function __construct(
        Template\Context $context,
        \Magento\Customer\Model\Session $session,
        \Magento\Variable\Model\Variable $customVar,
        array $data = []
        )
    {
        $this->_customerSession = $session;
        $this->customVar = $customVar;
        parent::__construct($context, $data);
    }

    public function loggedIn()
    {
        return $this->_customerSession->isLoggedIn();
    }

    public function sayHello()
    {
        return 'hello';
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
