<?php

namespace ZacaciaBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class ServerType extends AbstractType
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
            ->add('iphostnumber', TextType::class, array('label' => 'IP address'))
            ->add('zarafaaccount', ChoiceType::class, array(
                'label' => 'Account', 
                'choices' => array(
                    'Yes' => "1",
                    'No' => "0",
            )))
            ->add('zarafafilepath', TextType::class, array('label' => 'File Path', 'data' => '/var/run/zarafa'))
            ->add('zarafahttpport', IntegerType::class, array('label' => 'Http Port', 'data' => 636))
            ->add('zarafasslport', IntegerType::class, array('label' => 'Https Port', 'data' => 637))
            ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'ZacaciaBundle\Entity\Server',
        ));
    }

    public function getBlockPrefix()
    {
        return 'form';
    }
}
