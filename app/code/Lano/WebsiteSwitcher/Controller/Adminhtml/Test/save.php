<?php 
namespace Lano\WebsiteSwitcher\Controller\Adminhtml\Test;


use Magento\Backend\Model\Session;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Api\DataObjectHelper;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Reflection\DataObjectProcessor;
use Magento\Framework\Registry;
use Magento\Framework\Stdlib\DateTime\Filter\Date;
use Magento\Framework\View\Result\PageFactory;
use Lano\WebsiteSwitcher\Api\TestRepositoryInterface;
use Lano\WebsiteSwitcher\Api\Data\TestInterface;
use Lano\WebsiteSwitcher\Api\Data\TestInterfaceFactory;
use Lano\WebsiteSwitcher\Api\Data\FabInterface;
use Lano\WebsiteSwitcher\Api\Data\FabInterfaceFactory;
use Lano\WebsiteSwitcher\Controller\Adminhtml\Test;
// use Lano\WebsiteSwitcher\Model\Uploader;
// use Lano\WebsiteSwitcher\Model\UploaderPool;
class Save extends Test
{
    /**
     * @var DataObjectProcessor
     */
    protected $dataObjectProcessor;
    /**
     * @var DataObjectHelper
     */
    protected $dataObjectHelper;
    /**
     * @var UploaderPool
     */
    protected $uploaderPool;
    /**
     * @param Registry $registry
     * @param AuthorRepositoryInterface $authorRepository
     * @param PageFactory $resultPageFactory
     * @param Date $dateFilter
     * @param Context $context
     * @param AuthorInterfaceFactory $authorFactory
     * @param DataObjectProcessor $dataObjectProcessor
     * @param DataObjectHelper $dataObjectHelper
     * @param UploaderPool $uploaderPool
     */
    public function __construct(
        Registry $registry,
        TestRepositoryInterface $authorRepository,
        FabInterfaceFactory $fabFactory,
        PageFactory $resultPageFactory,
        Date $dateFilter,
        Context $context,
        TestInterfaceFactory $authorFactory,
        DataObjectProcessor $dataObjectProcessor,
        DataObjectHelper $dataObjectHelper
        // UploaderPool $uploaderPool
    )
    {
        $this->authorFactory = $authorFactory;
        $this->fabFactory = $fabFactory;
        $this->dataObjectProcessor = $dataObjectProcessor;
        $this->dataObjectHelper = $dataObjectHelper;
        //$this->uploaderPool = $uploaderPool;
        parent::__construct($registry, $authorRepository, $resultPageFactory, $dateFilter, $context);
    }
    /**
     * run the action
     *
     * @return \Magento\Backend\Model\View\Result\Redirect
     */
    public function execute()
    {
        /** @var \Lano\WebsiteSwitcher\Api\Data\TestInterface $author */
        $author = null;
        $data = $this->getRequest()->getPostValue();
        $id = !empty($data['lano_id']) ? $data['lano_id'] : null;
        $resultRedirect = $this->resultRedirectFactory->create();
        try {
            $fab = $this->fabFactory->create();
            $fab->load($data['lano_fab_id']);
            if ($id) {
                $author = $this->authorRepository->getById((int)$id);
            } else {
                unset($data['lano_id']);
                $author = $this->authorFactory->create();
            }
            //$avatar = $this->getUploader('image')->uploadFileAndGetName('avatar', $data);
            //$data['avatar'] = $avatar;
            //$resume = $this->getUploader('file')->uploadFileAndGetName('resume', $data);
            //$data['resume'] = $resume;

            $this->dataObjectHelper->populateWithArray($author, $data, TestInterface::class);
            $author->setData($data);
            $fab->setData($data);
            $author->save();
            $fab->save();
            $this->authorRepository->save($author);
            $this->messageManager->addSuccessMessage(__('You saved the author'));
            if ($this->getRequest()->getParam('back')) {
                $resultRedirect->setPath('switcher/test/edit', ['id' => $author->getId()]);
            } else {
                $resultRedirect->setPath('switcher/test');
            }
        } catch (LocalizedException $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
            if ($author != null) {
                $this->storeAuthorDataToSession(
                    $this->dataObjectProcessor->buildOutputDataArray(
                        $author,
                        TestInterface::class
                    )
                );
            }
            $resultRedirect->setPath('switcher/test/edit', ['id' => $id]);
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage(__('There was a problem saving the author= '.$e->getMessage()));
            // if ($author != null) {
            //     $this->storeAuthorDataToSession(
            //         $this->dataObjectProcessor->buildOutputDataArray(
            //             $author,
            //             TestInterface::class
            //         )
            //     );
            // }
            $resultRedirect->setPath('switcher/test/edit', ['id' => $id]);
        }
        return $resultRedirect;
    }
    /**
     * @param $type
     * @return Uploader
     * @throws \Exception
     */
    protected function getUploader($type)
    {
        return $this->uploaderPool->getUploader($type);
    }
    /**
     * @param $authorData
     */
    protected function storeAuthorDataToSession($authorData)
    {
        $this->_getSession()->setSampleNewsAuthorData($authorData);
    }
}