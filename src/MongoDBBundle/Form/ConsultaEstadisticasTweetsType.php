<?php

namespace MongoDBBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ConsultaEstadisticasTweetsType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('usuario', 'entity', [
            'class'=>'UserBundle:Usuario',
            'empty_value' => 'Escoger usuario',
        ])
        ->add('fechaInicial', 'date', [
                'label' => 'Fecha inicio',
                'required' => false,
        ])
        ->add('fechaFinal', 'date', [
                'label' => 'Fecha final',
                'required' => false,
        ])
        ->add('hashtag', 'choice', [
                 'choices'  => array(
                    'No' => 0,
                    'Sí' => 1
                ),
            // *this line is important*
            'choices_as_values' => true,
            'label' => '¿Agrupar por hashtag?',
            'required' => true,
        ])
        ->add('idioma', 'choice', [
               'choices'  => array(
                    'No' => 0,
                    'Sí' => 1
                ),
            // *this line is important*
            'choices_as_values' => true,
            'label' => '¿Agrupar por idioma?',
            'required' => true,
        ])
        ->add('retweet', 'choice', [
                'choices'  => array(
                    'No' => 0,
                    'Sí' => 1
                ),
            // *this line is important*
            'choices_as_values' => true,
            'label' => '¿Agrupar por RT y FAV por día?',
            'required' => true,
        ])
        ->add('cantidad', 'choice', [
                'choices'  => array(
                    'No' => 0,
                    'Sí' => 1
                ),
            // *this line is important*
            'choices_as_values' => true,
            'label' => '¿Agrupar tweets por cantidad?',
            'required' => true,
        ])
         ->add('menciones', 'choice', [
                'choices'  => array(
                    'No' => 0,
                    'Sí' => 1
                ),
            // *this line is important*
            'choices_as_values' => true,
            'label' => '¿Agrupar por menciones?',
            'required' => true,
        ])
        ->add('submit', 'submit', [
                'label' => 'Buscar',
                'attr' => [
                    'class' => 'btn btn-primary btn-block',
                ],

            ])

        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'tweets';
    }
}
