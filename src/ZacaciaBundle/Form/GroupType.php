<?php

namespace ZacaciaBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class GroupType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $this->domainChoices = $options['domain_choices'];
        $this->memberChoices = $options['member_choices'];

        $builder 
            ->add('cn', TextType::class, array('label' => 'Name'))
            ->add('email', TextType::class, array('label' => 'Email'))
            ->add('domain', ChoiceType::class, array(
                'label' => 'Domain',
                'placeholder' => false,
                'choices' => $this->domainChoices
            ))
            ->add('member', ChoiceType::class, array(
                'label' => 'Member',
                'expanded' => false,
                'placeholder' => false,
                'multiple' => true,
                'required' => true,
                'choices' => $this->memberChoices,
                'preferred_choices' => array(),
                'attr' => array(
                    'size' => count($this->memberChoices) + 1,
                )
            ))
            ->add('zacaciaStatus', ChoiceType::class, array(
                'label' => 'Status',
                'choices' => array(
                    'Enable' => 'enable',
                    'Disable' => 'disable',
            )))
            ->add('zacaciaUnDeletable', ChoiceType::class, array(
                'label' => 'UnDeletable', 
                'choices' => array(
                    'Yes' => "1",
                    'No' => "0",
            )))
            ->add('zarafaAccount', ChoiceType::class, array(
                'label' => 'Account', 
                'choices' => array(
                    'Yes' => "1",
                    'No' => "0",
            )))
            ->add('zarafaHidden', ChoiceType::class, array(
                'label' => 'Hidden', 
                'choices' => array(
                    'No' => "0",
                    'Yes' => "1",
            )))
            ->add('zarafaSecurityGroup', ChoiceType::class, array(
                'label' => 'SecurityGroup', 
                'choices' => array(
                    'No' => "0",
                    'Yes' => "1",
            )))

            ->add('platformid', HiddenType::class)
            ->add('organizationid', HiddenType::class)
            ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'ZacaciaBundle\Entity\Group',
            'domain_choices' => array(),
            'member_choices' => array(),
        ));
    }

    public function getBlockPrefix()
    {
        return 'form';
    }
}
