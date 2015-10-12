<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Cart
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Cart
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;


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
     * @ORM\OneToOne(targetEntity="Customer", inversedBy="cart")
     * @ORM\JoinColumn(name="customer_id", referencedColumnName="id")
     **/
    private $customer;

    /**
     * Set customer
     *
     * @param \AppBundle\Entity\Customer $customer
     * @return Cart
     */
    public function setCustomer(\AppBundle\Entity\Customer $customer = null)
    {
        $this->customer = $customer;

        return $this;
    }

    /**
     * Get customer
     *
     * @return \AppBundle\Entity\Customer 
     */
    public function getCustomer()
    {
        return $this->customer;
    }

    /**
     * @ORM\OneToMany(targetEntity="Produkt", mappedBy="cart")
     */
    protected $produkt;

    public function __construct()
    {
        $this->produkt = new ArrayCollection();
    }

    /**
     * Add produkt
     *
     * @param \AppBundle\Entity\Produkt $produkt
     * @return Cart
     */
    public function addProdukt(\AppBundle\Entity\Produkt $produkt)
    {
        $this->produkt[] = $produkt;

        return $this;
    }

    /**
     * Remove produkt
     *
     * @param \AppBundle\Entity\Produkt $produkt
     */
    public function removeProdukt(\AppBundle\Entity\Produkt $produkt)
    {
        $this->produkt->removeElement($produkt);
    }

    /**
     * Get produkt
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getProdukt()
    {
        return $this->produkt;
    }
}
