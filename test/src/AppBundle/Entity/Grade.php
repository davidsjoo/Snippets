<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Grade
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Grade
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
     * @var integer
     *
     * @ORM\Column(name="grade", type="integer", nullable=true)
     * @Assert\Range(
     *      min = 1,
     *      max = 5)
     */
    private $grade;

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
     * @ORM\OneToOne(targetEntity="Testgame", inversedBy="grade")
     * @ORM\JoinColumn(name="testgame_id", referencedColumnName="id")
     **/
    private $testgame;
    

    /**
     * Set testgame
     *
     * @param \AppBundle\Entity\Testgame $testgame
     * @return Grade
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
     * Set grade
     *
     * @param integer $grade
     * @return Grade
     */
    public function setGrade($grade)
    {
        $this->grade = $grade;

        return $this;
    }

    /**
     * Get grade
     *
     * @return integer 
     */
    public function getGrade()
    {
        return $this->grade;
    }
}
