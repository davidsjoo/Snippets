<?php

namespace AppBundle\Form\Type;

use \Symfony\Component\Form\AbstractType;
use \Symfony\Component\Form\FormBuilderInterface;


class MessageType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options) {

        $builder
            ->add('headline')
            ->add('paragraph')
            ->add('message')
            ->add('save', 'submit');
    }

    public function getName()
    {
        return 'message';
    }

}