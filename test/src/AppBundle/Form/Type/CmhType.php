<?php

namespace AppBundle\Form\Type;
use AppBundle\Entity\UserRepository;
use AppBundle\Entity\Cmh;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Doctrine\ORM\EntityRepository;

class CmhType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            ->add('user', 'entity', array(
                'class' => 'AppBundle:User',
                'choice_label' => 'name',
                'placeholder' => '-',
                'label' => false,
                'query_builder' => function(EntityRepository $er) {
                return $er->createQueryBuilder('u')
                    ->where('u.has_cmh = :true')
                    ->setParameter('true', true);
                }
                    ))
            ->add('save', 'submit', array(
                'label' => 'Spara'));
    }

    public function getName()
    {
        return 'cmh';
    }

}