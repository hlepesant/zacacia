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

use ZacaciaBundle\Entity\Server;
use ZacaciaBundle\Entity\ServerPeer;
use ZacaciaBundle\Form\ServerType;

use ZacaciaBundle\Form\DataTransformer\ZacaciaTransformer;

class ServerController extends Controller
{
    /**
     * @Route("/server/{platformid}", name="_server", requirements={
     *     "platformid": "([a-z0-9]{8})(\-[a-z0-9]{4}){3}(\-[a-z0-9]{12})"
     * })
     * @Method({"GET","HEAD"})
     */
    public function indexAction(Request $request, $platformid)
    {
        $platform_repository = (new PlatformPeer())->getLdapManager()->getRepository('platform');
        $platform = $platform_repository->getPlatformByUUID($platformid);

        $serverPeer =  new ServerPeer($platform->getDn());
        $server_repository = $serverPeer->getLdapManager()->getRepository('server');
        $servers = $server_repository->getAllServers();

        return $this->render('ZacaciaBundle:Server:index.html.twig', array(
            'platform' => $platform,
            'servers' => $servers,
        ));
    }

    /**
     * @Route("/server/{platformid}/new", name="_server_new", requirements={
     *     "platformid": "([a-z0-9]{8})(\-[a-z0-9]{4}){3}(\-[a-z0-9]{12})"
     * })
     */
    public function newAction(Request $request, $platformid)
    {
        $platform_repository = (new PlatformPeer())->getLdapManager()->getRepository('platform');
        $platform = $platform_repository->getPlatformByUUID($platformid);

        $server = new Server();
        $server->setZacaciastatus("enable");

        $form = $this->createForm(ServerType::class, $server);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            try{
                $serverPeer = new ServerPeer($platform->getDn());
                $serverPeer->createServer($server);

                return $this->redirectToRoute('_server', array('platformid' => $platform->getEntryUUID()));                
            
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
     * @Route("/server/{platformid}/{serverid}/edit", name="_server_edit", requirements={
     *     "platformid": "([a-z0-9]{8})(\-[a-z0-9]{4}){3}(\-[a-z0-9]{12})",
     *     "serverid": "([a-z0-9]{8})(\-[a-z0-9]{4}){3}(\-[a-z0-9]{12})"
     * })
     */
    public function editAction(Request $request, $platformid, $serverid)
    {
        $platform_repository = (new PlatformPeer())->getLdapManager()->getRepository('platform');
        $platform = $platform_repository->getPlatformByUUID($platformid);

        $serverPeer = new ServerPeer($platform->getDn());
        $server_repository = $serverPeer->getLdapManager()->getRepository('server');
        $serverLdap = $server_repository->getServerByUUID($serverid);

        $tranformer = new ZacaciaTransformer();
        $server = $tranformer->transServer($serverLdap);

        $form = $this->createForm(ServerType::class, $server);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            try{
                $serverLdap->setZacaciastatus($server->getZacaciastatus());
                $serverPeer->updateServer($serverLdap);

                return $this->redirectToRoute('_server', array('platformid' => $platform->getEntryUUID()));                
            
            } catch (LdapConnectionException $e) {
                echo "Failed to update server!".PHP_EOL;
                echo $e->getMessage().PHP_EOL;
            }
        }

        return $this->render('ZacaciaBundle:Server:edit.html.twig', array(
            'platform' => $platform,
            'server' => $server,
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/server/{platformid}/{serverid}/delete", name="_server_delete", requirements={
     *     "platformid": "([a-z0-9]{8})(\-[a-z0-9]{4}){3}(\-[a-z0-9]{12})",
     *     "serverid": "([a-z0-9]{8})(\-[a-z0-9]{4}){3}(\-[a-z0-9]{12})"
     * })
     */
    public function deleteAction(Request $request, $platformid, $serverid)
    {
        $platform_repository = (new PlatformPeer())->getLdapManager()->getRepository('platform');
        $platform = $platform_repository->getPlatformByUUID($platformid);

        try {
            $serverPeer =  new ServerPeer($platform->getDn());
            $serverPeer->deleteServer($serverid);
            
        } catch (LdapConnectionException $e) {
                echo "Failed to delete server!".PHP_EOL;
                echo $e->getMessage().PHP_EOL;
        }

        return $this->redirectToRoute('_server', array('platformid' => $platform->getEntryUUID()));                
    }

}
