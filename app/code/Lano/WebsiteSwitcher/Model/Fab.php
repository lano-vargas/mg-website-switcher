<?php
namespace Lano\WebsiteSwitcher\Model;

use \Lano\WebsiteSwitcher\Api\Data\FabInterface;

class Fab extends \Magento\Framework\Model\AbstractModel implements FabInterface
{

	protected function _construct()
	{
		$this->_init('Lano\WebsiteSwitcher\Model\ResourceModel\Fab');
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
     * Get ID
     *
     * @return int|null
     */
    public function getFabId() {
    	return $this->setData(TestInterface::FAB_ID);
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
     * Set ID
     *
     * @param int $lanoId
     * @return $this
     */
    public function setFabId($fabId) {
    	return $this->setData(TestInterface::FAB_ID, $fabId);
    }
}