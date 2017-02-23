<?php

namespace CodersLabBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    /**
     * @ORM\OneToMany(targetEntity="Contact", mappedBy="user", cascade={"remove"})
     */
    private $contacts;

    public function __construct()
    {
        parent::__construct();
        $this->contacts = new ArrayCollection();
    }

    /**
     * Add contacts
     *
     * @param \CodersLabBundle\Entity\Contact $contacts
     * @return User
     */
    public function addContact(\CodersLabBundle\Entity\Contact $contacts)
    {
        $this->contacts[] = $contacts;

        return $this;
    }

    /**
     * Remove contacts
     *
     * @param \CodersLabBundle\Entity\Contact $contacts
     */
    public function removeContact(\CodersLabBundle\Entity\Contact $contacts)
    {
        $this->contacts->removeElement($contacts);
    }

    /**
     * Get contacts
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getContacts()
    {
        return $this->contacts;
    }
}
