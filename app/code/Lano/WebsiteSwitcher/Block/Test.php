<?php

namespace Lano\WebsiteSwitcher\Block;

class Test extends \Magento\Framework\View\Element\Template
{

    protected $_request;

    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\App\Request\Http $request,
        \Lano\WebsiteSwitcher\Model\TestFactory $postFactory,
        array $data = []
    )
    {
        $this->_request = $request;
        $this->_postFactory = $postFactory;
        parent::__construct($context, $data);
    }

    public function getCollection() {
        $post = $this->_postFactory->create();
		$collection = $post->getCollection();
		return $collection;
    }
}