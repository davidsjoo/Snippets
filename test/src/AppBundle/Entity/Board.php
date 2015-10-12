<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Board
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Board
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
     * @var string
     *
     * @ORM\Column(name="board_message", type="text")
     */
    private $boardMessage;


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
     * Set boardMessage
     *
     * @param string $boardMessage
     * @return Board
     */
    public function setBoardMessage($boardMessage)
    {
        $this->boardMessage = $boardMessage;

        return $this;
    }

    /**
     * Get boardMessage
     *
     * @return string 
     */
    public function getBoardMessage()
    {
        return $this->boardMessage;
    }
}
