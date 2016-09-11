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
        $builder 
            ->add('sn', TextType::class, array('label' => 'Surname'))
            ->add('givenname', TextType::class, array('label' => 'Givenname'))
            ->add('displayname', TextType::class, array('label' => 'Display Name'))
            ->add('email', TextType::class, array('label' => 'Email'))
#            ->add('domain', ChoiceType::class, array(
#              'label' => 'Domain',
#              'placeholder' => false,
#              'choices' => $domain_repository->getAllDomainsAsChoice()
#            ))
            ->add('username', TextType::class, array('label' => 'Username'))
            ->add('password', PasswordType::class, array('label' => 'Password'))
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

            ->add('domain', ChoiceType::class, array(
               'label' => 'Domain',
               'placeholder' => false,
              // 'choices' => $domain_repository->getAllDomainsAsChoice()
            ))

            ->add('zarafaquotasoft', TextType::class, array('label' => 'Soft Quota'))
            ->add('zarafaquotawarn', TextType::class, array('label' => 'Warn Quota'))
            ->add('zarafaquotahard', TextType::class, array('label' => 'Hard Quota'))

            #->add('platform', HiddenType::class, array('data' => $platform->getEntryUUID()))
            #->add('organization', HiddenType::class, array('data' => $organization->getEntryUUID()))

            ->add('platform', HiddenType::class)
            ->add('organization', HiddenType::class)
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
