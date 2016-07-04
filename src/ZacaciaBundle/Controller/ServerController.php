<?php

namespace ZacaciaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

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

use ZacaciaBundle\Entity\Server;
use ZacaciaBundle\Entity\ServerPeer;

class ServerController extends Controller
{
    /**
     * @Route("/server/{platform}", name="_server", requirements={
     *     "platform": "([a-z0-9]{8})(\-[a-z0-9]{4}){3}(\-[a-z0-9]{12})"
     * })
     */
    public function indexAction(Request $request, $platform)
    {
        $platform_repository = (new PlatformPeer())->getLdapManager()->getRepository('platform');
        $platform = $platform_repository->getPlatformByUUID($platform);

        $serverPeer =  new ServerPeer($platform->getDn());
        $server_repository = $serverPeer->getLdapManager()->getRepository('server');
        $servers = $server_repository->getAllServers();

        return $this->render('ZacaciaBundle:Server:index.html.twig', array(
            'platform' => $platform,
            'servers' => $servers,
        ));
    }

    /**
     * @Route("/server/{platform}/new", name="_server_new", requirements={
     *     "platform": "([a-z0-9]{8})(\-[a-z0-9]{4}){3}(\-[a-z0-9]{12})"
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
     * @Route("/server/{platform}/{uuid}/edit", name="_server_edit", requirements={
     *     "platform": "([a-z0-9]{8})(\-[a-z0-9]{4}){3}(\-[a-z0-9]{12})",
     *     "uuid": "([a-z0-9]{8})(\-[a-z0-9]{4}){3}(\-[a-z0-9]{12})"
     * })
     */
    public function editAction(Request $request, $platform, $uuid)
    {
        $platform_repository = (new PlatformPeer())->getLdapManager()->getRepository('platform');
        $platform = $platform_repository->getPlatformByUUID($platform);

        $serverPeer = new ServerPeer($platform->getDn());
        $server_repository = $serverPeer->getLdapManager()->getRepository('server');
        $server = $server_repository->getServerByUUID($uuid);

#        var_dump($server->getZacaciaStatus()); exit;

        $form = $this->createFormBuilder($server)
            ->setAction($this->generateUrl('_server_edit', array('platform' => $platform->getEntryUUID(), 'uuid' => $uuid)))
            ->add('cn', TextType::class, array('label' => 'Name', 'attr' => array('readonly' => 'readonly')))
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
            ->add('zarafafilepath', TextType::class, array('label' => 'File Path'))
#            ->add('zarafahttpport', IntegerType::class, array('label' => 'Http Port'))
            ->add('zarafahttpport', TextType::class, array('label' => 'Http Port'))
#            ->add('zarafasslport', IntegerType::class, array('label' => 'Https Port'))
            ->add('zarafasslport', TextType::class, array('label' => 'Https Port'))
            ->add('entryUUID', HiddenType::class)
            ->add('save', SubmitType::class, array('label' => 'Update Server'))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            #$server->setZarafaHttpPort($form['zarafahttpport']->getData());
            #$server->zarafaHttpPort = (string)$form['zarafahttpport']->getData();

            try{
                $serverPeer->updateServer($server);

                return $this->redirectToRoute('_server', array('platform' => $platform->getEntryUUID()));                
            
            } catch (LdapConnectionException $e) {
                echo "Failed to update server!".PHP_EOL;
                echo $e->getMessage().PHP_EOL;
            }
        }

        return $this->render('ZacaciaBundle:Server:edit.html.twig', array(
            'platform' => $platform,
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/server/{platform}/{uuid}/delete", name="_server_delete", requirements={
     *     "platform": "([a-z0-9]{8})(\-[a-z0-9]{4}){3}(\-[a-z0-9]{12})",
     *     "uuid": "([a-z0-9]{8})(\-[a-z0-9]{4}){3}(\-[a-z0-9]{12})"
     * })
     */
    public function deleteAction(Request $request, $platform, $uuid)
    {
        $platform_repository = (new PlatformPeer())->getLdapManager()->getRepository('platform');
        $platform = $platform_repository->getPlatformByUUID($platform);

        try {
            $serverPeer =  new ServerPeer($platform->getDn());
            $serverPeer->deleteServer($uuid);    
            
        } catch (LdapConnectionException $e) {
                echo "Failed to delete server!".PHP_EOL;
                echo $e->getMessage().PHP_EOL;
        }

        return $this->redirectToRoute('_server', array('platform' => $platform->getEntryUUID()));                
    }

}
