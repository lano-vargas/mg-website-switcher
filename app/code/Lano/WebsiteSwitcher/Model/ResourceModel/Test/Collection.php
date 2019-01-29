<?php
namespace Lano\WebsiteSwitcher\Model\ResourceModel\Test;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

 class Collection extends AbstractCollection
 {
/**
     * Define model & resource model
     */
    const YOUR_TABLE = 'lano_custom';
    const STOREID = 1;
    protected $logger;
    protected $storeId;
    protected $storeManager;
    protected $request;

    public function __construct(
        \Magento\Framework\Data\Collection\EntityFactoryInterface $entityFactory,
        \Psr\Log\LoggerInterface $logger,
        \Magento\Framework\Data\Collection\Db\FetchStrategyInterface $fetchStrategy,
        \Magento\Framework\Event\ManagerInterface $eventManager,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Framework\App\Request\Http $request,
        \Magento\Framework\App\State $state,
        \Magento\Framework\DB\Adapter\AdapterInterface $connection = null,
        \Magento\Framework\Model\ResourceModel\Db\AbstractDb $resource = null
    ) {
        $this->storeManager = $storeManager;
        $this->request = $request;
        $this->_state = $state;
        $this->_init(
            'Lano\WebsiteSwitcher\Model\Test',
            'Lano\WebsiteSwitcher\Model\ResourceModel\Test'
        );
        parent::__construct(
            $entityFactory, $logger, $fetchStrategy, $eventManager, $connection,
            $resource
        );
    }

    protected function _initSelect()
    {
        
        parent::_initSelect();
        $this->_joinTables();
        return $this;      
    }

    public function _joinTables() {
        $this->storeId = ($this->_state->getAreaCode() == 'adminhtml' && $this->request->getParam('store')?$this->request->getParam('store'):$this->storeManager->getStore()->getId());
        $this->getSelect()->joinLeft(
            ['secondTable' => $this->getTable('lano_fab_custom')], //2nd table name by which you want to join
            'main_table.lano_fab_id = secondTable.lano_fab_id', // common column which available in both table
            '*' // '*' define that you want all column of 2nd table. if you want some particular column then you can define as ['column1','column2']
        )->where('secondTable.store = ? ', $this->storeId);

        return $this;
    }

    public function getAggregations()
    {
        return $this->aggregations;
    }
 
    /**
     * @param AggregationInterface $aggregations
     *
     * @return $this
     */
    public function setAggregations($aggregations)
    {
        $this->aggregations = $aggregations;
    }
 
    /**
     * Get search criteria.
     *
     * @return \Magento\Framework\Api\SearchCriteriaInterface|null
     */
    public function getSearchCriteria()
    {
        return null;
    }
 
    /**
     * Set search criteria.
     *
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     *
     * @return $this
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function setSearchCriteria(
        \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria = null
    ) {
        return $this;
    }
 
    /**
     * Get total count.
     *
     * @return int
     */
    public function getTotalCount()
    {
        return $this->getSize();
    }
 
    /**
     * Set total count.
     *
     * @param int $totalCount
     *
     * @return $this
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function setTotalCount($totalCount)
    {
        return $this;
    }
 
    /**
     * Set items list.
     *
     * @param \Magento\Framework\Api\ExtensibleDataInterface[] $items
     *
     * @return $this
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function setItems(array $items = null)
    {
        return $this;
    }
 
}