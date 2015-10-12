<?php
/**
 * Created by PhpStorm.
 * User: davidsjoo
 * Date: 15-09-16
 * Time: 10:26
 */

namespace AppBundle\Form\Type;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class TestGameType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options) {

        $builder
            ->add('gameName')
            ->add('highlight', 'entity', array(
                'class' => 'AppBundle:Highlight',
                'choice_label' => 'id',))
            ->add('save', 'submit');
    }

    public function getName()
    {
        return 'testgame';
    }

}