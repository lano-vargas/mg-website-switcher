<?php 
namespace Lano\WebsiteSwitcher\Api\Data;

Interface TestInterface{
    /**#@+
     * Constants for keys of data array. Identical to the name of the getter in snake case
     */
    const LANO_ID               = 'lano_id';
    const NAME                 = 'name';
    const EMAIL                 = 'Email';
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
    public function getLanoId();

    /**
     * Get Email
     *
     * @return int|null
     */
    public function getEmail();

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
    public function setLanoId($lanoId);

     /**
     * Set ID
     *
     * @param string $email
     * @return $this
     */
    public function setEmail($email);
}