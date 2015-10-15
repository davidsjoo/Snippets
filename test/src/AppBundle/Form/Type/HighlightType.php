<?php
/**
 * Created by PhpStorm.
 * User: davidsjoo
 * Date: 15-09-16
 * Time: 11:01
 */

namespace AppBundle\Form\Type;
use AppBundle\Entity\UserRepository;
use AppBundle\Entity\Highlight;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Doctrine\ORM\EntityRepository;

class HighlightType extends AbstractType
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
                    ->where('u.has_highlight = :true')
                    ->setParameter('true', true);
                }
                    ))
            ->add('trade', 'checkbox', array(
                'label' => 'Vill du byta detta pass?',
                'required' => false,
                ))
            ->add('trade_message', 'textarea', array(
                'required' => false,
                'label' => 'Meddelande'
                ))
            ->add('save', 'submit', array(
                'label' => 'Spara'));
    }

    public function getName()
    {
        return 'highlight';
    }

}