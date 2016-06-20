<?php

namespace ZacaciaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

use LdapTools\Configuration;
use LdapTools\LdapManager;
use LdapTools\Query\LdapQueryBuilder;

use ZacaciaBundle\Entity\Platform;

class PlatformController extends Controller
{
    /**
     * @Route("/platform", name="_platform")
     */
    public function indexAction()
    {
        $config = (new Configuration())->load(__DIR__."/../Resources/config/zacacia.yml");
        $ldap = new LdapManager($config);
        $query = $ldap->buildLdapQuery();

        /*
        $platforms = $query->select()
            ->setBaseDn('ou=Platforms,ou=Zacacia,ou=Applications,dc=zarafa,dc=com')
            ->from('Platform')
            ->Where(['zacaciaStatus' => 'enable'])
            ->orderBy('cn')
            ->getLdapQuery()
            ->getResult();
        */

        $platforms = $query->fromPlatform()
            ->Where(['zacaciaStatus' => 'enable'])
            ->orderBy('cn')
            ->getLdapQuery()
            ->getResult();

        return $this->render('ZacaciaBundle:Platform:index.html.twig', array(
            'platforms' => $platforms,
        ));
    }

    /**
     * @Route("/platform/new", name="_platform_new")
     */
    public function newAction(Request $request)
    {
        $config = (new Configuration())->load(__DIR__."/../Resources/config/zacacia.yml");

        $ldap = new LdapManager($config);

        $platform = new Platform();
        $platform->setZacaciastatus("enable");

        $form = $this->createFormBuilder($platform)
            ->add('cn', TextType::class, array('label' => 'Name'))
            ->add('zacaciastatus', ChoiceType::class, array(
                'label' => 'Status',
                'choices' => array(
                    'Enable' => 'enable',
                    'Disable' => 'disable',
            )))
            ->add('save', SubmitType::class, array('label' => 'Create Platform'))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            try{
                $base_dn = $config->getDomainConfiguration($config->getDefaultDomain())->getBaseDn();

                $dn = sprintf("cn=%s,ou=Platforms,%s", $platform->getCn(),$base_dn);

                $ldapObject = $ldap->createLdapObject();
                $ldapObject->create('platform')
                    ->setDn($dn)
                    ->in($base_dn)
                    ->with([
                        'objectClass' => ['top', 'organizationalRole', 'zacaciaPlatform'],
                        'cn' => $platform->getCn(),
                        'zacaciaStatus' => $platform->getZacaciaStatus()
                    ])
                    ->execute();        

                return $this->redirectToRoute('_platform');                
            
            } catch (LdapConnectionException $e) {
                echo "Failed to add platform!".PHP_EOL;
                echo $e->getMessage().PHP_EOL;
            }
        }

        return $this->render('ZacaciaBundle:Platform:new.html.twig', array(
            'form' => $form->createView(),
        ));
    }


    /**
     * @Route("/platform/{uuid}/edit", name="_platform_edit")
     */
    public function editAction(Request $request)
    {
        $config = (new Configuration())->load(__DIR__."/../Resources/config/zacacia.yml");
        $ldap = new LdapManager($config);

        $platform = new Platform();
        $platform->setCn("");
        $platform->setZacaciastatus("enable");

        $form = $this->createFormBuilder($platform)
            ->add('cn', TextType::class, array('label' => 'Name'))
            ->add('zacaciastatus', ChoiceType::class, array(
                'label' => 'Status',
                'choices' => array(
                    'Enable' => 'enable',
                    'Disable' => 'disable',
            )))
            ->add('save', SubmitType::class, array('label' => 'Create Platform'))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            //$platform->setCn($request->getValue('cn'));
            $data = $form->getData();
            print_r($data);
            exit;

            return $this->redirectToRoute('_platform');
        }

        return $this->render('ZacaciaBundle:Platform:new.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/platform/{uuid}/delete", name="_platform_delete")
     */
    public function deleteAction($uuid)
    {
        $config = (new Configuration())->load(__DIR__."/../Resources/config/zacacia.yml");
        $ldap = new LdapManager($config);
        $query = $ldap->buildLdapQuery();

        $platform = $query->fromPlatform()
            ->Where(['entryUUID' => $uuid])
            ->getLdapQuery()
            ->getOneOrNullResult();

        try {
            $ldap->delete($platform);
        } catch (LdapConnectionException $e) {
                echo "Failed to delete platform!".PHP_EOL;
                echo $e->getMessage().PHP_EOL;
        }

        return $this->redirectToRoute('_platform');
    }
}
