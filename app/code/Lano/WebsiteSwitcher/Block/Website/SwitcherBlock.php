<?php

/**
 * Created by PhpStorm.
 * User: julianovargas
 * Date: 24/03/2018
 * Time: 20:06
 */
namespace Lano\WebsiteSwitcher\Block\Website;

class SwitcherBlock extends \Magento\Framework\View\Element\Template
{

    protected $_request;

    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\App\Request\Http $request,
        array $data = []
    )
    {
        $this->_request = $request;
        parent::__construct($context, $data);
    }

    public function getWebsites() {
        $ar=array();
        foreach ($this->_storeManager->getWebsites() as $website){
            foreach ($website->getStores() as $key=>$store) {
                $storeObj = $this->_storeManager->getStore($store);
                $url = $storeObj->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_WEB);
                $ar[] = array('url'=>$url, 'name'=>$website->getName(), 'code'=>$website->getCode(), 'id'=>$website->getId());
            }
        }
        return $ar;
    }

    public function getWebsite() {
        return $this->_storeManager->getWebsite();
    }

    public function getUrlAfterBaseUrl() {
        return str_replace($this->getBaseUrl(), "", $this->getUrl('*/*/*', ['_current' => true, '_use_rewrite' => true]));
    }

    public function getIsNoRoute() {
        return ($this->_request->getControllerName()=='noroute'?true:false);
    }
}