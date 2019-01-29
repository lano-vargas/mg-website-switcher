<?php
/**
 */
namespace Lano\WebsiteSwitcher\Block\Adminhtml\Test\Edit\Buttons;
use Magento\Backend\Block\Widget\Context;
use Lano\WebsiteSwitcher\Api\TestRepositoryInterface;
use Magento\Framework\Exception\NoSuchEntityException;
class Generic
{
    /**
     * @var Context
     */
    protected $context;
    /**
     * @var TestRepositoryInterface
     */
    protected $testRepository;
    /**
     * @param Context $context
     * @param TestRepositoryInterface $testRepository
     */
    public function __construct(
        Context $context,
        TestRepositoryInterface $testRepository
    ) {
        $this->context = $context;
        $this->testRepository = $testRepository;
    }
    /**
     * Return test page ID
     *
     * @return int|null
     */
    public function getLanoId()
    {
        try {
            return $this->authorRepository->getById(
                $this->context->getRequest()->getParam('lano_id')
            )->getId();
        } catch (NoSuchEntityException $e) {
            return null;
        }
    }
    /**
     * Generate url by route and parameters
     *
     * @param   string $route
     * @param   array $params
     * @return  string
     */
    public function getUrl($route = '', $params = [])
    {
        return $this->context->getUrlBuilder()->getUrl($route, $params);
    }
}
