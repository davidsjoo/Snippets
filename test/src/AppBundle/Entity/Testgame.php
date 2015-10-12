<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Testgame
 *
 * @ORM\Table()
 *
 * @ORM\Entity(repositoryClass="AppBundle\Entity\TestgameRepository")
 */
class Testgame
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
     * @var \DateTime
     * @ORM\Column(name="datetime", type="datetime")
     */
    private $gamedates;

    /**
     * @var string
     *
     * @ORM\Column(name="game_name", type="string", length=255)
     */
    private $game_name;


    /**
     * Set game_name
     *
     * @param string $gameName
     * @return Testgame
     */
    public function setGameName($gameName)
    {
        $this->game_name = $gameName;

        return $this;
    }

    /**
     * Get game_name
     *
     * @return string 
     */
    public function getGameName()
    {
        return $this->game_name;
    }

    /**
     * @ORM\OneToOne(targetEntity="Highlight", mappedBy="testgame")
     *
     **/
    private $highlight;


    /**
     * Set highlight
     *
     * @param \AppBundle\Entity\Highlight $highlight
     * @return Testgame
     */
    public function setHighlight(\AppBundle\Entity\Highlight $highlight = null)
    {
        $this->highlight = $highlight;

        return $this;
    }

    /**
     * Get highlight
     *
     * @return \AppBundle\Entity\Highlight 
     */
    public function getHighlight()
    {
        return $this->highlight;
    }

    /**
     * @ORM\OneToOne(targetEntity="Grade", mappedBy="testgame")
     **/
    private $grade;

    /**
     * Set grade
     *
     * @param \AppBundle\Entity\Grade $grade
     * @return Testgame
     */
    public function setGrade(\AppBundle\Entity\Grade $grade = null)
    {
        $this->grade = $grade;

        return $this;
    }

    /**
     * Get grade
     *
     * @return \AppBundle\Entity\Grade 
     */
    public function getGrade()
    {
        return $this->grade;
    }

    /**
     * @ORM\OneToOne(targetEntity="Cmh", mappedBy="testgame")
     **/
    private $cmh;

    /**
     * Set cmh
     *
     * @param \AppBundle\Entity\Cmh $cmh
     * @return Testgame
     */
    public function setCmh(\AppBundle\Entity\Cmh $cmh = null)
    {
        $this->cmh = $cmh;

        return $this;
    }

    /**
     * Get cmh
     *
     * @return \AppBundle\Entity\Cmh 
     */
    public function getCmh()
    {
        return $this->cmh;
    }

    /**
     * Set datetime
     *
     * @param \DateTime $datetime
     * @return Testgame
     */
    public function setDatetime($datetime)
    {
        $this->datetime = $datetime;

        return $this;
    }

    /**
     * Get datetime
     *
     * @return \DateTime 
     */
    public function getDatetime()
    {
        return $this->datetime;
    }

    /**
     * Set gamedates
     *
     * @param \DateTime $gamedates
     * @return Testgame
     */
    public function setGamedates($gamedates)
    {
        $this->gamedates = $gamedates;

        return $this;
    }

    /**
     * Get gamedates
     *
     * @return \DateTime 
     */
    public function getGamedates()
    {
        return $this->gamedates;
    }

    function randomDate($start_date, $end_date)
    {
        // Convert to timetamps
        $min = strtotime($start_date);
        $max = strtotime($end_date);

        // Generate random number using above bounds
        $val = rand($min, $max);

        // Convert back to desired date format
        return date('Y-m-d H:i:s', $val);
    }
}
