<?php

namespace Modulo1Bundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityManager;
use ClientBundle\Entity\Client;

class DireccionType extends AbstractType
{
   
    private $collection;
    public function __construct(EntityManager $entityManager)
    {
        $this->collection = [];
        $em = $entityManager;
        $sql = " 
            SELECT id,nombres, apellidos
            FROM client u
            ";

        $stmt = $em->getConnection()->prepare($sql);
        $stmt->execute();
        $res = $stmt->fetchAll();
        foreach($res as $r){
           $this->collection[$r["id"]] = $r["nombres"].' '.$r["apellidos"];
        }
        

    }

    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('cliente', 'choice', [
                'choices' => $this->collection,
                'label' => false,
                'empty_value' => 'Escoja un cliente',
                'required' => false,
                'attr' => [
                    'class' => 'select2'
                ],
                'disabled' => true,
        ])
        ->add('direccion', 'text', [
            'label' => 'Direccion',
            'required' => true,
        ])
        ->add('submit', 'submit', [
                'label' => 'Guardar',
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
        return 'direccion';
    }
}