<?php

namespace adminBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;



class ProductType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('title')
            ->add('description')
            ->add('price')
            ->add('quantity')
            ->add('marque', EntityType::class,[
                'class' => 'adminBundle\Entity\Marque',
                'choice_label' => 'title',
                'placeholder' => '',
                'expanded' => true
            ])
            ->add('categorie', EntityType::class,[
                'class' => 'adminBundle\Entity\Categorie',
                'choice_label' => 'title',
                'placeholder' => '',
                'multiple' => true,
                'expanded' => true
            ])
            ->add('image', FileType::class)




        ;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'adminBundle\Entity\Product'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'adminbundle_product';
    }


}
