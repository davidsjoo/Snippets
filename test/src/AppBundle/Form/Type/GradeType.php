<?php
/**
 * Created by PhpStorm.
 * User: davidsjoo
 * Date: 15-09-16
 * Time: 13:03
 */

namespace AppBundle\Form\Type;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class GradeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options) {

        $builder
            ->add('grade', 'choice', array(
                'choices' => array(
                    '1' => 1,
                    '2' => 2,
                    '3' => 3,
                    '4' => 4,
                    '5' => 5,
                ),
                'placeholder' => '-',
            ))
            ->add('save', 'submit');
    }

    public function getName()
    {
        return 'grade';
    }

}