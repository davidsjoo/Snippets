<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Highlight
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Entity\HighlightRepository")
 */
class Highlight
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
     * @ORM\OneToOne(targetEntity="Testgame", inversedBy="highlight")
     * @ORM\JoinColumn(name="testgame_id", referencedColumnName="id")
     *
     **/
    private $testgame;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="highlight")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     *
     **/
    private $user;


    /**
     * Set testgame
     *
     * @param \AppBundle\Entity\Testgame $testgame
     * @return Highlight
     */
    public function setTestgame(\AppBundle\Entity\Testgame $testgame = null)
    {
        $this->testgame = $testgame;

        return $this;
    }

    /**
     * Get testgame
     *
     * @return \AppBundle\Entity\Testgame 
     */
    public function getTestgame()
    {
        return $this->testgame;
    }

    /**
     * Set user
     *
     * @param \AppBundle\Entity\User $user
     * @return Highlight
     */
    public function setUser(\AppBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \AppBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }
}
