<?php 
namespace Lano\WebsiteSwitcher\Api\Data;

Interface FabInterface{
    /**#@+
     * Constants for keys of data array. Identical to the name of the getter in snake case
     */
    const FAB_ID               = 'fab_id';
    const NAME                 = 'name';
    /**#@-*/


    /**
     * Get Title
     *
     * @return string|null
     */
    public function getName();

    /**
     * Get ID
     *
     * @return int|null
     */
    public function getFabId();

    /**
     * Set Name
     *
     * @param string $name
     * @return $this
     */
    public function setName($name);

    /**
     * Set ID
     *
     * @param int $lanoId
     * @return $this
     */
    public function setFabId($fabId);

}
