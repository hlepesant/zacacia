<?php

namespace ZacaciaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

use LdapTools\Configuration;
use LdapTools\LdapManager;
use LdapTools\Query\LdapQueryBuilder;

use ZacaciaBundle\Entity\Platform;
use ZacaciaBundle\Entity\PlatformPeer;


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
     * @Route("/platform/{uuid}/edit", name="_platform_edit", requirements={
        "uuid": "([a-z0-9]{8})(\-[a-z0-9]{4}){3}(\-[a-z0-9]{12})"
     })
     */
    public function editAction(Request $request, $uuid)
    {
        $ldapPeer = new PlatformPeer();
        $platform = $ldapPeer->getLdapManager()->getRepository('platform')->getPlatformByUUID($uuid);

//        $platform = new Platform();
//        $platform->setCn($platform->getCn());
//        $platform->setZacaciastatus($platform->getZacaciaStatus());

        $form = $this->createFormBuilder($platform)
            ->setAction($this->generateUrl('_platform_edit', array('uuid' => $uuid)))
            ->add('cn', TextType::class, array('label' => 'Name', 'attr' => array('readonly' => 'readonly')))
            ->add('zacaciastatus', ChoiceType::class, array(
                'label' => 'Status',
                'choices' => array(
                    'Enable' => 'enable',
                    'Disable' => 'disable',
            )))
            ->add('entryUUID', HiddenType::class)
            ->add('save', SubmitType::class, array('label' => 'Update Platform'))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $platformPeer = new PlatformPeer();
            $platformPeer->updatePlaform($platform);

            return $this->redirectToRoute('_platform');
        }

        return $this->render('ZacaciaBundle:Platform:edit.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/platform/{uuid}/delete", name="_platform_delete", requirements={
        "uuid": "([a-z0-9]{8})(\-[a-z0-9]{4}){3}(\-[a-z0-9]{12})"
     })
     */
    public function deleteAction($uuid)
    {
        try {
            $ldapPeer = new PlatformPeer();
            $ldapPeer->deletePlatform($uuid, true);    
            
        } catch (LdapConnectionException $e) {
                echo "Failed to delete platform!".PHP_EOL;
                echo $e->getMessage().PHP_EOL;
        }

        return $this->redirectToRoute('_platform');
    }
}
