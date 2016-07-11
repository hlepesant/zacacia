<?php

namespace ZacaciaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

use LdapTools\Configuration;
use LdapTools\LdapManager;
use LdapTools\Query\LdapQueryBuilder;

use ZacaciaBundle\Entity\Platform;
use ZacaciaBundle\Entity\PlatformPeer;

#use ZacaciaBundle\Entity\Server;
#use ZacaciaBundle\Entity\ServerPeer;

use ZacaciaBundle\Entity\Organization;
use ZacaciaBundle\Entity\OrganizationPeer;

class OrganizationController extends Controller
{
    /**
     * @Route("/customer/{platform}", name="_organization", requirements={
		 * "platform": "([a-z0-9]{8})(\-[a-z0-9]{4}){3}(\-[a-z0-9]{12})"
     })
     * @Method({"GET","HEAD"})
     */
    public function indexAction(Request $request, $platform)
    {
        $platform_repository = (new PlatformPeer())->getLdapManager()->getRepository('platform');
        $platform = $platform_repository->getPlatformByUUID($platform);

        $organizationPeer =  new OrganizationPeer($platform->getDn());
        $organization_repository = $organizationPeer->getLdapManager()->getRepository('organization');
        $organizations = $organization_repository->getAllOrganizations();

        return $this->render('ZacaciaBundle:Organization:index.html.twig', array(
            'platform' => $platform,
            'organizations' => $organizations,
        ));
    }

    /**
     * @Route("/customer/{platform}/new", name="_organization_new", requirements={
     *     "platform": "([a-z0-9]{8})(\-[a-z0-9]{4}){3}(\-[a-z0-9]{12})"
     * })
     */
    public function newAction(Request $request, $platform)
    {
        $platform_repository = (new PlatformPeer())->getLdapManager()->getRepository('platform');
        $platform = $platform_repository->getPlatformByUUID($platform);

        $organization = new Organization();
        $organization->setZacaciastatus("enable");
        $organization->setZarafahidden("0");

        $form = $this->createFormBuilder($organization)
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
            ->add('save', SubmitType::class, array('label' => 'Create Organization'))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            try{
                $organizationPeer =  new OrganizationPeer($platform->getDn());
                $organizationPeer->createOrganization($organization);

                return $this->redirectToRoute('_organization', array('platform' => $platform->getEntryUUID()));                
            
            } catch (LdapConnectionException $e) {
                echo "Failed to add server!".PHP_EOL;
                echo $e->getMessage().PHP_EOL;
            }
        }

        return $this->render('ZacaciaBundle:Organization:new.html.twig', array(
            'platform' => $platform,
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/customer/{platform}/{uuid}/edit", name="_organization_edit", requirements={
     *     "platform": "([a-z0-9]{8})(\-[a-z0-9]{4}){3}(\-[a-z0-9]{12})",
     *     "uuid": "([a-z0-9]{8})(\-[a-z0-9]{4}){3}(\-[a-z0-9]{12})"
     * })
     */
    public function editAction(Request $request, $platform, $uuid)
    {
    }

    /**
     * @Route("/customer/{platform}/{uuid}/delete", name="_organization_delete", requirements={
     *     "platform": "([a-z0-9]{8})(\-[a-z0-9]{4}){3}(\-[a-z0-9]{12})",
     *     "uuid": "([a-z0-9]{8})(\-[a-z0-9]{4}){3}(\-[a-z0-9]{12})"
     * })
     */
    public function deleteAction(Request $request, $platform, $uuid)
    {
    }
}
