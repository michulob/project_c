<?php

namespace CodersLabBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Contact
 *
 * @ORM\Table(name="contact")
 * @ORM\Entity(repositoryClass="CodersLabBundle\Repository\ContactRepository")
 */
class Contact
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
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="surname", type="string", length=255)
     */
    private $surname;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     */
    private $description;
    
    /**
     * @ORM\OneToMany(targetEntity="Address", mappedBy="contact", cascade={"remove"})
     */
    private $address;
    
    /**
     * @ORM\OneToMany(targetEntity="Phone", mappedBy="contact", cascade={"remove"})
     */
    private $phone;
    
    /**
     * @ORM\OneToMany(targetEntity="Email", mappedBy="contact", cascade={"remove"})
     */
    private $email;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="contacts")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;
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
     * Set name
     *
     * @param string $name
     * @return Contact
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set surname
     *
     * @param string $surname
     * @return Contact
     */
    public function setSurname($surname)
    {
        $this->surname = $surname;

        return $this;
    }

    /**
     * Get surname
     *
     * @return string 
     */
    public function getSurname()
    {
        return $this->surname;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Contact
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->address = new ArrayCollection();
        $this->phone = new ArrayCollection();
        $this->email = new ArrayCollection();
    }

    /**
     * Add address
     *
     * @param \CodersLabBundle\Entity\Address $address
     * @return Contact
     */
    public function addAddress(\CodersLabBundle\Entity\Address $address)
    {
        $this->address[] = $address;

        return $this;
    }

    /**
     * Remove address
     *
     * @param \CodersLabBundle\Entity\Address $address
     */
    public function removeAddress(\CodersLabBundle\Entity\Address $address)
    {
        $this->address->removeElement($address);
    }

    /**
     * Get address
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Add phone
     *
     * @param \CodersLabBundle\Entity\Phone $phone
     * @return Contact
     */
    public function addPhone(\CodersLabBundle\Entity\Phone $phone)
    {
        $this->phone[] = $phone;

        return $this;
    }

    /**
     * Remove phone
     *
     * @param \CodersLabBundle\Entity\Phone $phone
     */
    public function removePhone(\CodersLabBundle\Entity\Phone $phone)
    {
        $this->phone->removeElement($phone);
    }

    /**
     * Get phone
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Add email
     *
     * @param \CodersLabBundle\Entity\Email $email
     * @return Contact
     */
    public function addEmail(\CodersLabBundle\Entity\Email $email)
    {
        $this->email[] = $email;

        return $this;
    }

    /**
     * Remove email
     *
     * @param \CodersLabBundle\Entity\Email $email
     */
    public function removeEmail(\CodersLabBundle\Entity\Email $email)
    {
        $this->email->removeElement($email);
    }

    /**
     * Get email
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set user
     *
     * @param \CodersLabBundle\Entity\User $user
     * @return Contact
     */
    public function setUser(\CodersLabBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \CodersLabBundle\Entity\User 
     */
    public function getUser()
    {
        return $this->user;
    }
}
