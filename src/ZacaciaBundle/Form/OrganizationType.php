<?php

namespace ZacaciaBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;

class OrganizationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder 
            ->add('cn', TextType::class, array('label' => 'Name'))
            ->add('zacaciastatus', ChoiceType::class, array(
                'label' => 'Status',
                'choices' => array(
                    'Enable' => 'enable',
                    'Disable' => 'disable',
            )))
            ->add('zarafaaccount', ChoiceType::class, array(
                'label' => 'Account', 
                'choices' => array(
                    'Yes' => "1",
                    'No' => "0",
            )))
            ->add('zarafahidden', ChoiceType::class, array(
                'label' => 'Hidden', 
                'choices' => array(
                    'Yes' => "1",
                    'No' => "0",
            )))
            ->add('platform', HiddenType::class)
            ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'ZacaciaBundle\Entity\Organization',
        ));
    }

    public function getBlockPrefix()
    {
        return 'form';
    }
}
