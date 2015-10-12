<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * User
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Entity\UserRepository")
 */
class User
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
     * @var string
     *
     * @ORM\Column(name="user_name", type="string", length=255)
     */
    private $name;
    

    /**
     * Set name
     *
     * @param string $name
     * @return User
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
     * @var boolean
     *
     * @ORM\Column(name="has_highlight", type="boolean", nullable=true)
     */
    private $has_highlight;

    /**
     * @var boolean
     *
     * @ORM\Column(name="has_cmh", type="boolean", nullable=true)
     */
    private $has_cmh;

    /**
     * @ORM\OneToMany(targetEntity="Highlight", mappedBy="user")
     **/
    private $highlight;
    // ...

    public function __construct() {
        $this->highlight = new ArrayCollection();
    }



    /**
     * Add highlight
     *
     * @param \AppBundle\Entity\Highlight $highlight
     * @return User
     */
    public function addHighlight(\AppBundle\Entity\Highlight $highlight)
    {
        $this->highlight[] = $highlight;

        return $this;
    }

    /**
     * Remove highlight
     *
     * @param \AppBundle\Entity\Highlight $highlight
     */
    public function removeHighlight(\AppBundle\Entity\Highlight $highlight)
    {
        $this->highlight->removeElement($highlight);
    }

    /**
     * Get highlight
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getHighlight()
    {
        return $this->highlight;
    }

    /**
     * @ORM\OneToMany(targetEntity="Cmh", mappedBy="user")
     **/
    private $cmh;
    

    /**
     * Add cmh
     *
     * @param \AppBundle\Entity\Cmh $cmh
     * @return User
     */
    public function addCmh(\AppBundle\Entity\Cmh $cmh)
    {
        $this->cmh[] = $cmh;

        return $this;
    }

    /**
     * Remove cmh
     *
     * @param \AppBundle\Entity\Cmh $cmh
     */
    public function removeCmh(\AppBundle\Entity\Cmh $cmh)
    {
        $this->cmh->removeElement($cmh);
    }

    /**
     * Get cmh
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getCmh()
    {
        return $this->cmh;
    }

    /**
     * Set has_highlight
     *
     * @param boolean $hasHighlight
     * @return User
     */
    public function setHasHighlight($hasHighlight)
    {
        $this->has_highlight = $hasHighlight;

        return $this;
    }

    /**
     * Get has_highlight
     *
     * @return boolean
     */
    public function getHasHighlight()
    {
        return $this->has_highlight;
    }

    /**
     * Set has_cmh
     *
     * @param boolean $hasCmh
     * @return User
     */
    public function setHasCmh($hasCmh)
    {
        $this->has_cmh = $hasCmh;

        return $this;
    }

    /**
     * Get has_cmh
     *
     * @return boolean 
     */
    public function getHasCmh()
    {
        return $this->has_cmh;
    }
}
