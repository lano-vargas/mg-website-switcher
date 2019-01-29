<?php
namespace Lano\WebsiteSwitcher\Controller\Index;

class Test extends \Magento\Framework\App\Action\Action
{
        /**
         * @var \Magento\Framework\View\Result\PageFactory
         */
        protected $resultPageFactory;

        /**
         * @param \Magento\Framework\App\Action\Context $context
         * @param \Magento\Framework\View\Result\PageFactory resultPageFactory
         */
        public function __construct(
		\Magento\Framework\App\Action\Context $context,
		\Magento\Framework\View\Result\PageFactory $pageFactory,
		\Lano\WebsiteSwitcher\Model\TestFactory $postFactory
		)
	{
		$this->_pageFactory = $pageFactory;
		$this->_postFactory = $postFactory;
		return parent::__construct($context);
	}
    /**
     * Default customer account page
     *
     * @return void
     */
    public function execute()
    {
        $post = $this->_postFactory->create();
		$collection = $post->getCollection();
		foreach($collection as $item){
			// echo "<pre>";
			// // print_r($item->getId());
			// // print_r($item->getName());
			// echo "</pre>";
		}
		return $this->_pageFactory->create();
    }
}