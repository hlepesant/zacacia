<?php

namespace ZacaciaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
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
use ZacaciaBundle\Form\OrganizationType;

use ZacaciaBundle\Form\DataTransformer\ZacaciaTransformer;

class OrganizationController extends Controller
{
    /**
     * @Route("/customer/{platformid}", name="_organization", requirements={
		 *     "platformid": "([a-z0-9]{8})(\-[a-z0-9]{4}){3}(\-[a-z0-9]{12})"
     * })
     * @Method({"GET","HEAD"})
     */
    public function indexAction(Request $request, $platformid)
    {
        $platform_repository = (new PlatformPeer())->getLdapManager()->getRepository('platform');
        $platform = $platform_repository->getPlatformByUUID($platformid);

        $organizationPeer =  new OrganizationPeer($platform->getDn());
        $organization_repository = $organizationPeer->getLdapManager()->getRepository('organization');
        $organizations = $organization_repository->getAllOrganizations();

        foreach ($organizations as $organization) {
          $nbdomain = $organizationPeer->countDomainForOrganization($organization->getDn());
          $organization->setNumberOfDomain($nbdomain);
        }

        return $this->render('ZacaciaBundle:Organization:index.html.twig', array(
            'platform' => $platform,
            'organizations' => $organizations,
        ));
    }

    /**
     * @Route("/customer/{platformid}/new", name="_organization_new", requirements={
     *     "platformid": "([a-z0-9]{8})(\-[a-z0-9]{4}){3}(\-[a-z0-9]{12})"
     * })
     */
    public function newAction(Request $request, $platformid)
    {
        $platform_repository = (new PlatformPeer())->getLdapManager()->getRepository('platform');
        $platform = $platform_repository->getPlatformByUUID($platformid);

        $organization = new Organization();
        $organization->setZacaciastatus("enable");
        $organization->setZarafahidden("0");
        $organization->setPlatform( $platform->getEntryUUID() );

        $form = $this->createForm(OrganizationType::class, $organization);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            try{
                $organizationPeer =  new OrganizationPeer($platform->getDn());
                $organizationPeer->createOrganization($organization);

                return $this->redirectToRoute('_organization', array('platformid' => $platform->getEntryUUID()));                
            
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
     * @Route("/customer/{platformid}/{organizationid}/edit", name="_organization_edit", requirements={
     *     "platformid": "([a-z0-9]{8})(\-[a-z0-9]{4}){3}(\-[a-z0-9]{12})",
     *     "organizationid": "([a-z0-9]{8})(\-[a-z0-9]{4}){3}(\-[a-z0-9]{12})"
     * })
     */
    public function editAction(Request $request, $platformid, $organizationid)
    {
        $platform_repository = (new PlatformPeer())->getLdapManager()->getRepository('platform');
        $platform = $platform_repository->getPlatformByUUID($platformid);

        $organizationPeer = new OrganizationPeer($platform->getDn());
        $organization_repository = $organizationPeer->getLdapManager()->getRepository('organization');
        $organizationLdap = $organization_repository->getOrganizationByUUID($organizationid);

        $tranformer = new ZacaciaTransformer();
        $organization = $tranformer->transOrganization($organizationLdap);

        $form = $this->createForm(OrganizationType::class, $organization);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            try{
                $organizationLdap->setZarafaHidden($organization->getZarafaHidden());
                $organizationLdap->setZarafaAccount($organization->getZarafaAccount());
                $organizationLdap->setZacaciastatus($organization->getZacaciastatus());

                $organizationPeer->updateOrganization($organizationLdap);

                return $this->redirectToRoute('_organization', array('platformid' => $platform->getEntryUUID()));                
            
            } catch (LdapConnectionException $e) {
                echo "Failed to update organization!".PHP_EOL;
                echo $e->getMessage().PHP_EOL;
            }
        }

        return $this->render('ZacaciaBundle:Organization:edit.html.twig', array(
            'platform' => $platform,
            'organization' => $organization,
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/customer/{platformid}/{organizationid}/delete", name="_organization_delete", requirements={
     *     "platformid": "([a-z0-9]{8})(\-[a-z0-9]{4}){3}(\-[a-z0-9]{12})",
     *     "organizationid": "([a-z0-9]{8})(\-[a-z0-9]{4}){3}(\-[a-z0-9]{12})"
     * })
     */
    public function deleteAction(Request $request, $platformid, $organizationid)
    {
        $platform_repository = (new PlatformPeer())->getLdapManager()->getRepository('platform');
        $platform = $platform_repository->getPlatformByUUID($platformid);

        try {
            $organizationPeer =  new OrganizationPeer($platform->getDn());
            $organizationPeer->deleteOrganization($organizationid, true);
            
        } catch (LdapConnectionException $e) {
          echo "Failed to delete organization!".PHP_EOL;
          echo $e->getMessage().PHP_EOL;
        }

        return $this->redirectToRoute('_organization', array('platformid' => $platform->getEntryUUID()));                
    }
}
