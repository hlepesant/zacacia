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
use ZacaciaBundle\Form\DomainType;

use ZacaciaBundle\Form\DataTransformer\ZacaciaTransformer;

class DomainController extends Controller
{
    /**
     * @Route("/domain/{platformid}/{organizationid}", name="_domain", requirements={
		 *    "platformid": "([a-z0-9]{8})(\-[a-z0-9]{4}){3}(\-[a-z0-9]{12})",
		 *    "organizationid": "([a-z0-9]{8})(\-[a-z0-9]{4}){3}(\-[a-z0-9]{12})",
     * })
     * @Method({"GET","HEAD"})
     */
    public function indexAction(Request $request, $platformid, $organizationid)
    {
        $platform_repository = (new PlatformPeer())->getLdapManager()->getRepository('platform');
        $platform = $platform_repository->getPlatformByUUID($platformid);

        $organizationPeer =  new OrganizationPeer($platform->getDn());
        $organization_repository = $organizationPeer->getLdapManager()->getRepository('organization');
        $organization = $organization_repository->getOrganizationByUUID($organizationid);

        $domainPeer =  new DomainPeer($organization->getDn());
        $domain_repository = $domainPeer->getLdapManager()->getRepository('domain');
        $domains = $domain_repository->getAllDomains();


        foreach ($domains as $domain) {
          $nbemail = $domainPeer->countEmailForDomain($domain->getCn());
          $domain->setNbEmailForDomain($nbemail);
        }

        return $this->render('ZacaciaBundle:Domain:index.html.twig', array(
            'platform' => $platform,
            'organization' => $organization,
            'domains' => $domains,
        ));
    }

    /**
     * @Route("/domain/{platformid}/{organizationid}/new", name="_domain_new", requirements={
     *    "platformid": "([a-z0-9]{8})(\-[a-z0-9]{4}){3}(\-[a-z0-9]{12})",
	 *    "organizationid": "([a-z0-9]{8})(\-[a-z0-9]{4}){3}(\-[a-z0-9]{12})",
     * })
     * @Method({"GET","POST"})
     */
    public function newAction(Request $request, $platformid, $organizationid)
    {
        $platform_repository = (new PlatformPeer())->getLdapManager()->getRepository('platform');
        $platform = $platform_repository->getPlatformByUUID($platformid);

        $organizationPeer =  new OrganizationPeer($platform->getDn());
        $organization_repository = $organizationPeer->getLdapManager()->getRepository('organization');
        $organization = $organization_repository->getOrganizationByUUID($organizationid);

        $domain = new Domain();
        $domain->setZacaciastatus("disable");

        $form = $this->createForm(DomainType::class, $domain);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid() ) {

            try{
                $domainPeer = new DomainPeer($organization->getDn());
                $domainPeer->createDomain($domain);

                return $this->redirectToRoute('_domain', array(
                  'platformid' => $platform->getEntryUUID(),
                  'organizationid' => $organization->getEntryUUID(),
                ));
            
            } catch (LdapConnectionException $e) {
                echo "Failed to add server!".PHP_EOL;
                echo $e->getMessage().PHP_EOL;
            }
        }

        return $this->render('ZacaciaBundle:Domain:new.html.twig', array(
            'platform' => $platform,
            'organization' => $organization,
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/domain/{platformid}/{organizationid}/{domainid}/edit", name="_domain_edit", requirements={
     *     "platformid": "([a-z0-9]{8})(\-[a-z0-9]{4}){3}(\-[a-z0-9]{12})",
     *     "organizationid": "([a-z0-9]{8})(\-[a-z0-9]{4}){3}(\-[a-z0-9]{12})",
     *     "domainid": "([a-z0-9]{8})(\-[a-z0-9]{4}){3}(\-[a-z0-9]{12})"
     * })
     */
    public function editAction(Request $request, $platformid, $organizationid, $domainid)
    {
        $platform_repository = (new PlatformPeer())->getLdapManager()->getRepository('platform');
        $platform = $platform_repository->getPlatformByUUID($platformid);

        $organizationPeer = new OrganizationPeer($platform->getDn());
        $organization_repository = $organizationPeer->getLdapManager()->getRepository('organization');
        $organization = $organization_repository->getOrganizationByUUID($organizationid);

        $domainPeer = new DomainPeer($organization->getDn());
        $domain_repository = $domainPeer->getLdapManager()->getRepository('domain');
        $domainLdap = $domain_repository->getDomainByUUID($domainid);

        $tranformer = new ZacaciaTransformer();
        $domain = $tranformer->transDomain($domainLdap);

        $form = $this->createForm(DomainType::class, $domain);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            try{
                $domainLdap->setZacaciastatus($domain->getZacaciastatus());
                $domainPeer->updateDomain($domainLdap);

                return $this->redirectToRoute('_domain', array(
                  'platformid' => $platform->getEntryUUID(),
                  'organizationid' => $organization->getEntryUUID(),
                ));
            
            } catch (LdapConnectionException $e) {
                echo "Failed to update domain!".PHP_EOL;
                echo $e->getMessage().PHP_EOL;
            }
        }

        return $this->render('ZacaciaBundle:Domain:edit.html.twig', array(
            'platform' => $platform,
            'organization' => $organization,
            'domain' => $domain,
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/domain/{platformid}/{organizationid}/{domainid}/delete", name="_domain_delete", requirements={
     *     "platformid": "([a-z0-9]{8})(\-[a-z0-9]{4}){3}(\-[a-z0-9]{12})",
     *     "organizationid": "([a-z0-9]{8})(\-[a-z0-9]{4}){3}(\-[a-z0-9]{12})",
     *     "domainid": "([a-z0-9]{8})(\-[a-z0-9]{4}){3}(\-[a-z0-9]{12})"
     * })
     */
    public function deleteAction(Request $request, $platformid, $organizationid, $domainid)
    {
        $platform_repository = (new PlatformPeer())->getLdapManager()->getRepository('platform');
        $platform = $platform_repository->getPlatformByUUID($platformid);

        $organizationPeer = new OrganizationPeer($platform->getDn());
        $organization_repository = $organizationPeer->getLdapManager()->getRepository('organization');
        $organization = $organization_repository->getOrganizationByUUID($organizationid);

        try {
            $domainPeer =  new DomainPeer($organization->getDn());
            $domainPeer->deleteDomain($domainid, true);
            
        } catch (LdapConnectionException $e) {
            echo "Failed to delete domain!".PHP_EOL;
            echo $e->getMessage().PHP_EOL;
        }

        return $this->redirectToRoute('_domain', array(
            'platformid' => $platform->getEntryUUID(),
            'organizationid' => $organization->getEntryUUID(),
        ));
    }
}
