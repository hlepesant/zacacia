<?php

namespace ZacaciaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

use LdapTools\Configuration;
use LdapTools\LdapManager;
use LdapTools\Query\LdapQueryBuilder;

use ZacaciaBundle\Entity\Platform;
use ZacaciaBundle\Entity\PlatformPeer;
use ZacaciaBundle\Form\PlatformType;

use ZacaciaBundle\Form\DataTransformer\ZacaciaTransformer;


class PlatformController extends Controller
{
    /**
     * @Route("/platform", name="_platform")
     */
    public function indexAction()
    {
        $repository = (new PlatformPeer())->getLdapManager()->getRepository('platform');
        $platforms = $repository->getAllPlatforms();

        return $this->render('ZacaciaBundle:Platform:index.html.twig', array(
            'platforms' => $platforms,
        ));
    }

    /**
     * @Route("/platform/new", name="_platform_new")
     */
    public function newAction(Request $request)
    {
        $platform = new Platform();
        $platform->setZacaciastatus("enable");

        $form = $this->createForm(PlatformType::class, $platform);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            try{
                $platformPeer = new PlatformPeer();
                $platformPeer->createPlatform($platform);

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
     * @Route("/platform/{platformid}/edit", name="_platform_edit", requirements={
     *     "platformid": "([a-z0-9]{8})(\-[a-z0-9]{4}){3}(\-[a-z0-9]{12})"
     * })
     */
    public function editAction(Request $request, $platformid)
    {
        $platformPeer = new PlatformPeer();
        $platformLdap = $platformPeer->getLdapManager()->getRepository('platform')->getPlatformByUUID($platformid);

        $tranformer = new ZacaciaTransformer();
        $platform = $tranformer->transPlatform($platformLdap);

        $form = $this->createForm(PlatformType::class, $platform);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            try{
                $platformLdap->setZacaciastatus($platform->getZacaciastatus());

                $platformPeer->updatePlaform($platformLdap);

                return $this->redirectToRoute('_platform');

            } catch (LdapConnectionException $e) {
                echo "Failed to update Platform!".PHP_EOL;
                echo $e->getMessage().PHP_EOL;
            }
        }

        return $this->render('ZacaciaBundle:Platform:edit.html.twig', array(
            'platform' => $platform,
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/platform/{platformid}/delete", name="_platform_delete", requirements={
     *     "platformid": "([a-z0-9]{8})(\-[a-z0-9]{4}){3}(\-[a-z0-9]{12})"
     * })
     */
    public function deleteAction(Request $request, $platformid)
    {
        try {
            $ldapPeer = new PlatformPeer();
            $ldapPeer->deletePlatform($platformid, true);    
            
        } catch (LdapConnectionException $e) {
                echo "Failed to delete platform!".PHP_EOL;
                echo $e->getMessage().PHP_EOL;
        }

        return $this->redirectToRoute('_platform');
    }
}
