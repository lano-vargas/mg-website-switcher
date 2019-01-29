<?php
/**
 * 
 */
namespace Lano\WebsiteSwitcher\Api;
use Magento\Framework\Api\SearchCriteriaInterface;
use Lano\WebsiteSwitcher\Api\Data\TestInterface;
/**
 * s
 */
interface TestRepositoryInterface
{
    /**
     * Save page.
     *
     * @param TestInterface $author
     * @return TestInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function save(TestInterface $author);
    /**
     * Retrieve Author.
     *
     * @param int $lanoId
     * @return TestInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getById($lanoId);
    /**
     * Retrieve pages matching the specified criteria.
     *
     * @param SearchCriteriaInterface $searchCriteria
     * @return \Lano\WebsiteSwitcher\Api\Data\TestSearchResultsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(SearchCriteriaInterface $searchCriteria);
    /**
     * Delete author.
     *
     * @param TestInterface $author
     * @return bool true on success
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function delete(TestInterface $author);
    /**
     * Delete lano by ID.
     *
     * @param int $lanoId
     * @return bool true on success
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function deleteById($authorId);
}
