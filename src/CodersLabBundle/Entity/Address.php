<?php

namespace CodersLabBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Address
 *
 * @ORM\Table(name="address")
 * @ORM\Entity(repositoryClass="CodersLabBundle\Repository\AddressRepository")
 */
class Address
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="city", type="string", length=255)
     */
    private $city;

    /**
     * @var string
     *
     * @ORM\Column(name="street", type="string", length=255)
     */
    private $street;

    /**
     * @var string
     *
     * @ORM\Column(name="building", type="string", length=5)
     */
    private $building;

    /**
     * @var string
     *
     * @ORM\Column(name="flat", type="string", length=5, nullable=true)
     */
    private $flat;
    
    /**
     * @ORM\ManyToOne(targetEntity="Contact", inversedBy="address")
     * @ORM\JoinColumn(name="contact_id", referencedColumnName="id")
     */
    private $contact;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set city
     *
     * @param string $city
     * @return Address
     */
    public function setCity($city)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get city
     *
     * @return string 
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set street
     *
     * @param string $street
     * @return Address
     */
    public function setStreet($street)
    {
        $this->street = $street;

        return $this;
    }

    /**
     * Get street
     *
     * @return string 
     */
    public function getStreet()
    {
        return $this->street;
    }

    /**
     * Set building
     *
     * @param string $building
     * @return Address
     */
    public function setBuilding($building)
    {
        $this->building = $building;

        return $this;
    }

    /**
     * Get building
     *
     * @return string 
     */
    public function getBuilding()
    {
        return $this->building;
    }

    /**
     * Set flat
     *
     * @param string $flat
     * @return Address
     */
    public function setFlat($flat)
    {
        $this->flat = $flat;

        return $this;
    }

    /**
     * Get flat
     *
     * @return string 
     */
    public function getFlat()
    {
        return $this->flat;
    }

    /**
     * Set contact
     *
     * @param \CodersLabBundle\Entity\Contact $contact
     * @return Address
     */
    public function setContact(\CodersLabBundle\Entity\Contact $contact = null)
    {
        $this->contact = $contact;

        return $this;
    }

    /**
     * Get contact
     *
     * @return \CodersLabBundle\Entity\Contact 
     */
    public function getContact()
    {
        return $this->contact;
    }
}
