<?php

namespace AppBundle\Form\Type;
use AppBundle\Entity\UserRepository;
use AppBundle\Entity\Highlight;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Doctrine\ORM\EntityRepository;

class TradeType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            ->add('accepted_trade', 'checkbox', array(
                'label' => 'Vill du ta detta pass?',
                'required' => true,
                ))
            ->add('save', 'submit', array(
                'label' => 'Spara'));
    }

    public function getName()
    {
        return 'accepted_trade';
    }

}