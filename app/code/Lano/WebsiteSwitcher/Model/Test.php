<?php
namespace Lano\WebsiteSwitcher\Model;

use \Lano\WebsiteSwitcher\Api\Data\TestInterface;

class Test extends \Magento\Framework\Model\AbstractModel implements TestInterface
{
	const CACHE_TAG = 'switcher_test_grid_collection';

	protected $_cacheTag = 'switcher_test_grid_collection';

	protected $_eventPrefix = 'switcher_test_grid_collection';

	protected function _construct()
	{
		$this->_init('Lano\WebsiteSwitcher\Model\ResourceModel\Test');
	}

    /**
     * Get Title
     *
     * @return string|null
     */
    public function getName(){
    	return $this->getData(TestInterface::NAME);
    }

    /**
     * Get Email
     *
     * @return string|null
     */
    public function getEmail(){
        return $this->getData(TestInterface::EMAIL);
    }

    /**
     * Get ID
     *
     * @return int|null
     */
    public function getLanoId() {
    	return $this->setData(TestInterface::LANO_ID);
    }

    /**
     * Set Name
     *
     * @param string $name
     * @return $this
     */
    public function setName($name){
    	return $this->getData(TestInterface::NAME,  $name);
    }

    /**
     * Set Email
     *
     * @param string $email
     * @return $this
     */
    public function setEmail($email){
        return $this->getData(TestInterface::EMAIL,  $email);
    }

    /**
     * Set ID
     *
     * @param int $lanoId
     * @return $this
     */
    public function setLanoId($lanoId) {
    	return $this->setData(TestInterface::LANO_ID, $lanoId);
    }
}