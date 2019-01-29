<?php
/**
 * Sample_News extension
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the MIT License
 * that is bundled with this package in the file LICENSE
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/mit-license.php
 *
 * @category  Sample
 * @package   Sample_News
 * @copyright 2016 Marius Strajeru
 * @license   http://opensource.org/licenses/mit-license.php MIT License
 * @author    Marius Strajeru
 */
namespace Lano\WebsiteSwitcher\Model;
use Magento\Framework\Api\DataObjectHelper;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\Search\FilterGroup;
use Magento\Framework\Api\SortOrder;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\StateException;
use Magento\Framework\Exception\ValidatorException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Store\Model\StoreManagerInterface;
use Lano\WebsiteSwitcher\Api\TestRepositoryInterface;
use Lano\WebsiteSwitcher\Api\Data;
use Lano\WebsiteSwitcher\Api\Data\TestInterface;
use Lano\WebsiteSwitcher\Api\Data\TestInterfaceFactory;
use Lano\WebsiteSwitcher\Api\TestRepositoryInterface as TestModelRepositoryInterface;
//use Lano\WebsiteSwitcher\Api\Data\TestSearchResultsInterfaceFactory;
use Lano\WebsiteSwitcher\Model\ResourceModel\Test as ResourceAuthor;
use Lano\WebsiteSwitcher\Model\ResourceModel\Test\Collection;
use Lano\WebsiteSwitcher\Model\ResourceModel\Test\CollectionFactory as TestCollectionFactory;
/**
 * Class AuthorRepository
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class TestRepository implements TestModelRepositoryInterface
{
    /**
     * @var array
     */
    protected $instances = [];
    /**
     * @var ResourceAuthor
     */
    protected $resource;
    /**
     * @var StoreManagerInterface
     */
    protected $storeManager;
    /**
     * @var AuthorCollectionFactory
     */
    protected $authorCollectionFactory;
    /**
     * @var AuthorSearchResultsInterfaceFactory
     */
    protected $searchResultsFactory;
    /**
     * @var AuthorInterfaceFactory
     */
    protected $authorInterfaceFactory;
    /**
     * @var DataObjectHelper
     */
    protected $dataObjectHelper;
    public function __construct(
        ResourceAuthor $resource,
        StoreManagerInterface $storeManager,
        TestCollectionFactory $authorCollectionFactory,
        //TestSearchResultsInterfaceFactory $authorSearchResultsInterfaceFactory,
        TestInterfaceFactory $authorInterfaceFactory,
        DataObjectHelper $dataObjectHelper
    ) {
        $this->resource                 = $resource;
        $this->storeManager             = $storeManager;
        $this->authorCollectionFactory  = $authorCollectionFactory;
        //$this->searchResultsFactory     = $authorSearchResultsInterfaceFactory;
        $this->authorInterfaceFactory   = $authorInterfaceFactory;
        $this->dataObjectHelper         = $dataObjectHelper;
    }
    /**
     * Save page.
     *
     * @param \Lano\WebsiteSwitcher\Api\Data\TestInterface $author
     * @return \Lano\WebsiteSwitcher\Api\Data\TestInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function save(TestInterface $author)
    {
        /** @var AuthorInterface|\Magento\Framework\Model\AbstractModel $author */
        if (empty($author->getStoreId())) {
            $storeId = $this->storeManager->getStore()->getId();
            $author->setStoreId($storeId);
        }
        try {
            $this->resource->save($author);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__(
                'Could not save the author: %1',
                $exception->getMessage()
            ));
        }
        return $author;
    }
    /**
     * Retrieve Author.
     *
     * @param int $authorId
     * @return \Lano\WebsiteSwitcher\Api\Data\TestInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getById($authorId)
    {
        if (!isset($this->instances[$authorId])) {
            /** @var \Lano\WebsiteSwitcher\Api\Data\TestInterface|\Magento\Framework\Model\AbstractModel $author */
            $author = $this->authorInterfaceFactory->create();
            $this->resource->load($author, $authorId);
            if (!$author->getId()) {
                throw new NoSuchEntityException(__('Requested author doesn\'t exist'));
            }
            $this->instances[$authorId] = $author;
        }
        return $this->instances[$authorId];
    }
    /**
     * Retrieve pages matching the specified criteria.
     *
     * @param SearchCriteriaInterface $searchCriteria
     * @return \Sample\News\Api\Data\AuthorSearchResultsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(SearchCriteriaInterface $searchCriteria)
    {
        /** @var \Lano\WebsiteSwitcher\Api\Data\TestSearchResultsInterface $searchResults */
        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($searchCriteria);
        /** @var \Lano\WebsiteSwitcher\Model\ResourceModel\Test\Collection $collection */
        $collection = $this->authorCollectionFactory->create();
        //Add filters from root filter group to the collection
        /** @var FilterGroup $group */
        foreach ($searchCriteria->getFilterGroups() as $group) {
            $this->addFilterGroupToCollection($group, $collection);
        }
        $sortOrders = $searchCriteria->getSortOrders();
        /** @var SortOrder $sortOrder */
        if ($sortOrders) {
            foreach ($searchCriteria->getSortOrders() as $sortOrder) {
                $field = $sortOrder->getField();
                $collection->addOrder(
                    $field,
                    ($sortOrder->getDirection() == SortOrder::SORT_ASC) ? 'ASC' : 'DESC'
                );
            }
        } else {
            // set a default sorting order since this method is used constantly in many
            // different blocks
            $field = 'lano_id';
            $collection->addOrder($field, 'ASC');
        }
        $collection->setCurPage($searchCriteria->getCurrentPage());
        $collection->setPageSize($searchCriteria->getPageSize());
        /** @var \Sample\News\Api\Data\AuthorInterface[] $authors */
        $authors = [];
        /** @var \Sample\News\Model\Author $author */
        foreach ($collection as $author) {
            /** @var \Sample\News\Api\Data\AuthorInterface $authorDataObject */
            $authorDataObject = $this->authorInterfaceFactory->create();
            $this->dataObjectHelper->populateWithArray($authorDataObject, $author->getData(), AuthorInterface::class);
            $authors[] = $authorDataObject;
        }
        $searchResults->setTotalCount($collection->getSize());
        return $searchResults->setItems($authors);
    }
    /**
     * Delete author.
     *
     * @param \Sample\News\Api\Data\AuthorInterface $author
     * @return bool true on success
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function delete(TestInterface $author)
    {
        /** @var \Sample\News\Api\Data\AuthorInterface|\Magento\Framework\Model\AbstractModel $author */
        $id = $author->getId();
        try {
            unset($this->instances[$id]);
            $this->resource->delete($author);
        } catch (ValidatorException $e) {
            throw new CouldNotSaveException(__($e->getMessage()));
        } catch (\Exception $e) {
            throw new StateException(
                __('Unable to remove author %1', $id)
            );
        }
        unset($this->instances[$id]);
        return true;
    }
    /**
     * Delete author by ID.
     *
     * @param int $authorId
     * @return bool true on success
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function deleteById($authorId)
    {
        $author = $this->getById($authorId);
        return $this->delete($author);
    }
    /**
     * Helper function that adds a FilterGroup to the collection.
     *
     * @param FilterGroup $filterGroup
     * @param Collection $collection
     * @return $this
     * @throws \Magento\Framework\Exception\InputException
     */
    protected function addFilterGroupToCollection(FilterGroup $filterGroup, Collection $collection)
    {
        $fields = [];
        $conditions = [];
        foreach ($filterGroup->getFilters() as $filter) {
            $condition = $filter->getConditionType() ? $filter->getConditionType() : 'eq';
            $fields[] = $filter->getField();
            $conditions[] = [$condition => $filter->getValue()];
        }
        if ($fields) {
            $collection->addFieldToFilter($fields, $conditions);
        }
        return $this;
    }
}