<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

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

    /**
    * @var boolean
    * @ORM\Column(name="trade", type="boolean", nullable=true)
    */
    private $trade;

    /**
    * @var string
    * @ORM\Column(name="trade_message", type="string", length=255, nullable=true)
    */
    private $trade_message;

    /**
    * @var boolean
    * @ORM\Column(name="accepted_trade", type="boolean", nullable=true)
    */
    private $accepted_trade;

    /**
     * Set trade
     *
     * @param boolean $trade
     * @return Highlight
     */
    public function setTrade($trade)
    {
        $this->trade = $trade;

        return $this;
    }

    /**
     * Get trade
     *
     * @return boolean 
     */
    public function getTrade()
    {
        return $this->trade;
    }

    /**
     * Set trade_message
     *
     * @param string $tradeMessage
     * @return Highlight
     */
    public function setTradeMessage($tradeMessage)
    {
        $this->trade_message = $tradeMessage;

        return $this;
    }

    /**
     * Get trade_message
     *
     * @return string 
     */
    public function getTradeMessage()
    {
        return $this->trade_message;
    }

    /**
     * Set accepted_trade
     *
     * @param boolean $acceptedTrade
     * @return Highlight
     */
    public function setAcceptedTrade($acceptedTrade)
    {
        $this->accepted_trade = $acceptedTrade;

        return $this;
    }

    /**
     * Get accepted_trade
     *
     * @return boolean 
     */
    public function getAcceptedTrade()
    {
        return $this->accepted_trade;
    }
}
