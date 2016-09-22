<?php

namespace ZacaciaBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;

class ChangePwdType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder 
            ->add('displayname', TextType::class, array('label' => 'Display Name'))
            ->add('userpassword', PasswordType::class, array('label' => 'Password'))
            ->add('confpass', PasswordType::class, array('label' => 'Confirm Password'))
            ->add('platformid', HiddenType::class)
            ->add('organizationid', HiddenType::class)
            ->add('userid', HiddenType::class)
            ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'ZacaciaBundle\Entity\User',
        ));
    }

    public function getBlockPrefix()
    {
        return 'form';
    }
}
