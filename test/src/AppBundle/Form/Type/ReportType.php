<?php

namespace AppBundle\Form\Type;
use AppBundle\Entity\UserRepository;
use Symfony\Component\Form\AbstractType;
use AppBundle\Entity\Highlight;
use AppBundle\Entity\Cmh;
use AppBundle\Entity\User;
use Symfony\Component\Form\FormBuilderInterface;
use Doctrine\ORM\EntityRepository;

class ReportType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            ->add('user', 'entity', array(
                'class' => 'AppBundle:User',
                'choice_label' => 'name',
                'label' => 'Användare',
            ))
            ->add('start_date', 'date', array(
                'data' => new \DateTime('first day of last month midnight'),
                'label' => 'Från:'
            ))
            ->add('end_date', 'date', array(
                'data' => new \DateTime('last day of last month 9pm'),
                'label' => 'Till:'
            ))
            ->add('save', 'submit', array(
                'label' => 'Sök',
                'attr' => array(
                    'class' => 'rapport_submit'
                )
            ));
    }

    public function getName()
    {
        return 'report';
    }

}