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

class AliasType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $this->domainChoices = $options['domain_choices'];

        $builder 
            ->add('email', TextType::class, array('label' => 'Email'))
            ->add('domain', ChoiceType::class, array(
                'label' => 'Domain',
                'placeholder' => false,
                'choices' => $this->domainChoices
            ))

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
