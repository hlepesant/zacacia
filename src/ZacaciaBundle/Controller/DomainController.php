<?php

namespace ZacaciaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
#use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

use LdapTools\Configuration;
use LdapTools\LdapManager;
use LdapTools\Query\LdapQueryBuilder;

use ZacaciaBundle\Entity\Platform;
use ZacaciaBundle\Entity\PlatformPeer;

use ZacaciaBundle\Entity\Organization;
use ZacaciaBundle\Entity\OrganizationPeer;

use ZacaciaBundle\Entity\Domain;
use ZacaciaBundle\Entity\DomainPeer;

class DomainController extends Controller
{
    /**
     * @Route("/domain/{platform}/{organization}", name="_domain", requirements={
		 *    "platform": "([a-z0-9]{8})(\-[a-z0-9]{4}){3}(\-[a-z0-9]{12})",
		 *    "organization": "([a-z0-9]{8})(\-[a-z0-9]{4}){3}(\-[a-z0-9]{12})",
     * })
     * @Method({"GET","HEAD"})
     */
    public function indexAction(Request $request, $platform, $organization)
    {
        $platform_repository = (new PlatformPeer())->getLdapManager()->getRepository('platform');
        $platform = $platform_repository->getPlatformByUUID($platform);

        $organizationPeer =  new OrganizationPeer($platform->getDn());
        $organization_repository = $organizationPeer->getLdapManager()->getRepository('organization');
        $organization = $organization_repository->getOrganizationByUUID($organization);

        $domainPeer =  new DomainPeer($organization->getDn());
        $domain_repository = $domainPeer->getLdapManager()->getRepository('domain');
        $domains = $domain_repository->getAllDomains();

        return $this->render('ZacaciaBundle:Domain:index.html.twig', array(
            'platform' => $platform,
            'organization' => $organization,
            'domains' => $domains,
        ));
    }

    /**
     * @Route("/domain/{platform}/{organization}/new", name="_domain_new", requirements={
     *    "platform": "([a-z0-9]{8})(\-[a-z0-9]{4}){3}(\-[a-z0-9]{12})",
		 *    "organization": "([a-z0-9]{8})(\-[a-z0-9]{4}){3}(\-[a-z0-9]{12})",
     * })
     */
    public function newAction(Request $request, $platform)
    {
        $platform_repository = (new PlatformPeer())->getLdapManager()->getRepository('platform');
        $platform = $platform_repository->getPlatformByUUID($platform);

        $server = new Server();
        $server->setZacaciastatus("enable");

        $form = $this->createFormBuilder($server)
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
            ->add('save', SubmitType::class, array('label' => 'Create Server'))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            try{
                $serverPeer =  new ServerPeer($platform->getDn());
                $serverPeer->createServer($server);

                return $this->redirectToRoute('_server', array('platform' => $platform->getEntryUUID()));                
            
            } catch (LdapConnectionException $e) {
                echo "Failed to add server!".PHP_EOL;
                echo $e->getMessage().PHP_EOL;
            }
        }

        return $this->render('ZacaciaBundle:Server:new.html.twig', array(
            'platform' => $platform,
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/domain/{platform}/{organization]/{domain}/edit", name="_domain_edit", requirements={
     *   "platform": "([a-z0-9]{8})(\-[a-z0-9]{4}){3}(\-[a-z0-9]{12})",
     *   "organization": "([a-z0-9]{8})(\-[a-z0-9]{4}){3}(\-[a-z0-9]{12})",
     *   "domain": "([a-z0-9]{8})(\-[a-z0-9]{4}){3}(\-[a-z0-9]{12})"
     * })
     */
    public function editAction(Request $request, $platform, $organization, $domain)
    {
        $platform_repository = (new PlatformPeer())->getLdapManager()->getRepository('platform');
        $platform = $platform_repository->getPlatformByUUID($platform);

        $organizationPeer = new OrganizationPeer($platform->getDn());
        $organization_repository = $organizationPeer->getLdapManager()->getRepository('organization');
        $organization = $organization_repository->getOrganizationByUUID($uuid);

#        var_dump($organization); exit;

        $form = $this->createFormBuilder($organization)
            ->setAction($this->generateUrl('_organization_edit', array('platform' => $platform->getEntryUUID(), 'uuid' => $uuid)))
            ->add('cn', TextType::class, array('label' => 'Name', 'attr' => array('readonly' => 'readonly')))
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
            #->add('zarafahidden', TextType::class, array('label' => 'Hidden'))
            ->add('zarafahidden', ChoiceType::class, array(
                'label' => 'Hidden', 
                'choices' => array(
                    'Yes' => "1",
                    'No' => "0",
            )))
            ->add('entryUUID', HiddenType::class)
            ->add('save', SubmitType::class, array('label' => 'Update Customer'))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            #$server->setZarafaHttpPort($form['zarafahttpport']->getData());
            #$server->zarafaHttpPort = (string)$form['zarafahttpport']->getData();

            try{
                $organizationPeer->updateOrganization($organization);

                return $this->redirectToRoute('_organization', array('platform' => $platform->getEntryUUID()));                
            
            } catch (LdapConnectionException $e) {
                echo "Failed to update server!".PHP_EOL;
                echo $e->getMessage().PHP_EOL;
            }
        }

        return $this->render('ZacaciaBundle:Organization:edit.html.twig', array(
            'platform' => $platform,
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/domain/{platform}/{organization]/{domain}/delete", name="_domain_delete", requirements={
     *   "platform": "([a-z0-9]{8})(\-[a-z0-9]{4}){3}(\-[a-z0-9]{12})",
     *   "organization": "([a-z0-9]{8})(\-[a-z0-9]{4}){3}(\-[a-z0-9]{12})",
     *   "domain": "([a-z0-9]{8})(\-[a-z0-9]{4}){3}(\-[a-z0-9]{12})"
     * })
     */
    public function deleteAction(Request $request, $platform, $uuid)
    {
        $platform_repository = (new PlatformPeer())->getLdapManager()->getRepository('platform');
        $platform = $platform_repository->getPlatformByUUID($platform);

        try {
            $organizationPeer =  new OrganizationPeer($platform->getDn());
            $organizationPeer->deleteOrganization($uuid, true);
            
        } catch (LdapConnectionException $e) {
          echo "Failed to delete organization!".PHP_EOL;
          echo $e->getMessage().PHP_EOL;
        }

        return $this->redirectToRoute('_organization', array('platform' => $platform->getEntryUUID()));                
    }
}
