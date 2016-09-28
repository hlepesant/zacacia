<?php

namespace ZacaciaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

use Symfony\Component\HttpFoundation\Request;

use LdapTools\Configuration;
use LdapTools\LdapManager;
use LdapTools\Query\LdapQueryBuilder;

use ZacaciaBundle\Entity\Platform;
use ZacaciaBundle\Entity\PlatformPeer;

use ZacaciaBundle\Entity\Organization;
use ZacaciaBundle\Entity\OrganizationPeer;

use ZacaciaBundle\Entity\Group;
use ZacaciaBundle\Entity\GroupPeer;

class GroupController extends Controller
{
    /**
     * @Route("/group/{platformid}/{organizationid}", name="_group", requirements={
		 *     "platformid": "([a-z0-9]{8})(\-[a-z0-9]{4}){3}(\-[a-z0-9]{12})",
		 *     "organizationid": "([a-z0-9]{8})(\-[a-z0-9]{4}){3}(\-[a-z0-9]{12})",
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

        $groupPeer =  new GroupPeer($platform->getDn());
        $group_repository = $groupPeer->getLdapManager()->getRepository('group');
        $groups = $group_repository->getAllGroups();

        return $this->render('ZacaciaBundle:Group:index.html.twig', array(
            'platform' => $platform,
            'organization' => $organization,
            'groups' => $groups,
        ));
    }

    /**
     * @Route("/group/{platformid}/{organizationid}/{groupid}/edit", name="_group_edit", requirements={
     *     "platformid": "([a-z0-9]{8})(\-[a-z0-9]{4}){3}(\-[a-z0-9]{12})",
     *     "organizationid": "([a-z0-9]{8})(\-[a-z0-9]{4}){3}(\-[a-z0-9]{12})",
     *     "groupid": "([a-z0-9]{8})(\-[a-z0-9]{4}){3}(\-[a-z0-9]{12})"
     * })
     */
    public function editAction(Request $request, $platformid, $organizationid, $groupid)
    {
        $platform_repository = (new PlatformPeer())->getLdapManager()->getRepository('platform');
        $platform = $platform_repository->getPlatformByUUID($platformid);

        $organizationPeer = new OrganizationPeer($platform->getDn());
        $organization_repository = $organizationPeer->getLdapManager()->getRepository('organization');
        $organization = $organization_repository->getOrganizationByUUID($organizationid);

        $groupPeer = new GroupPeer($organization->getDn());
        $group_repository = $groupPeer->getLdapManager()->getRepository('group');
        $groupLdap = $group_repository->getGroupByUUID($groupid);

        $domainPeer =  new DomainPeer($organization->getDn());
        $domain_repository = $domainPeer->getLdapManager()->getRepository('domain');

        $tranformer = new ZacaciaTransformer();
        $group = $tranformer->transGroup($groupLdap, $platform, $organization);

        $form = $this->createForm(GroupType::class, $group, array(
            'domain_choices' => $domain_repository->getAllDomainsAsChoice(),
         ));

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            try{

                $groupLdap->setSn($group->getSn());
                $groupLdap->setGivenName($group->getGivenName());
                $groupLdap->setMail(sprintf('%s@%s', $group->getEmail(), $group->getDomain()));

                $groupLdap->setZarafaHidden($group->getZarafaHidden());
                $groupLdap->setZarafaAccount($group->getZarafaAccount());
                $groupLdap->setZacaciastatus($group->getZacaciastatus());

                $groupPeer->updateGroup($groupLdap);

                return $this->redirectToRoute('_group', array(
                  'platformid' => $platform->getEntryUUID(),
                  'organizationid' => $organization->getEntryUUID(),
                ));
            
            } catch (LdapConnectionException $e) {
                echo "Failed to update group!".PHP_EOL;
                echo $e->getMessage().PHP_EOL;
            }
        }

        return $this->render('ZacaciaBundle:Group:edit.html.twig', array(
            'platform' => $platform,
            'organization' => $organization,
            'group' => $group,
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/group/{platformid}/{organizationid}/{groupid}/delete", name="_group_delete", requirements={
     *     "platformid": "([a-z0-9]{8})(\-[a-z0-9]{4}){3}(\-[a-z0-9]{12})",
     *     "organizationid": "([a-z0-9]{8})(\-[a-z0-9]{4}){3}(\-[a-z0-9]{12})",
     *     "groupid": "([a-z0-9]{8})(\-[a-z0-9]{4}){3}(\-[a-z0-9]{12})"
     * })
     */
    public function deleteAction(Request $request, $platformid, $organizationid, $groupid)
    {
        $platform_repository = (new PlatformPeer())->getLdapManager()->getRepository('platform');
        $platform = $platform_repository->getPlatformByUUID($platformid);

        $organizationPeer = new OrganizationPeer($platform->getDn());
        $organization_repository = $organizationPeer->getLdapManager()->getRepository('organization');
        $organization = $organization_repository->getOrganizationByUUID($organizationid);

        try {
            $groupPeer = new GroupPeer($organization->getDn());
            $groupPeer->deleteGroup($groupid, true);
            
        } catch (LdapConnectionException $e) {
          echo "Failed to delete group!".PHP_EOL;
          echo $e->getMessage().PHP_EOL;
        }

        return $this->redirectToRoute('_group', array(
          'platformid' => $platform->getEntryUUID(),
          'organizationid' => $organization->getEntryUUID(),
        ));
    }
}
