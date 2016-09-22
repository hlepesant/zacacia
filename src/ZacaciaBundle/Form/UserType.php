<?php

namespace ZacaciaBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;

class UserType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $this->domainChoices = $options['domain_choices'];

        $builder 
            ->add('sn', TextType::class, array('label' => 'Surname'))
            ->add('givenname', TextType::class, array('label' => 'Givenname'))
            ->add('displayname', TextType::class, array('label' => 'Display Name'))
            ->add('email', TextType::class, array('label' => 'Email'))
            ->add('domain', ChoiceType::class, array(
                'label' => 'Domain',
                'placeholder' => false,
                'choices' => $this->domainChoices
            ))
            ->add('uid', TextType::class, array('label' => 'Username'))
            ->add('userpassword', PasswordType::class, array('label' => 'Password'))
            ->add('confpass', PasswordType::class, array('label' => 'Confirm Password'))
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
                    'No' => "0",
                    'Yes' => "1",
            )))
            ->add('zarafaquotaoverride', ChoiceType::class, array(
                'label' => 'Override Quota', 
                'choices' => array(
                    'No' => "0",
                    'Yes' => "1",
            )))
            ->add('zarafaquotasoft', TextType::class, array('label' => 'Soft Quota', 'required' => false))
            ->add('zarafaquotawarn', TextType::class, array('label' => 'Warn Quota', 'required' => false))
            ->add('zarafaquotahard', TextType::class, array('label' => 'Hard Quota', 'required' => false))

            ->add('platformid', HiddenType::class)
            ->add('organizationid', HiddenType::class)
            ->add('userid', HiddenType::class)
            ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'ZacaciaBundle\Entity\User',
            'domain_choices' => array(),
        ));
    }

    public function getBlockPrefix()
    {
        return 'form';
    }
}
