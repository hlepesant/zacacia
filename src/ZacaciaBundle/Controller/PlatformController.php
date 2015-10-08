<?php

namespace ZacaciaBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

use LdapTools\Configuration;
use LdapTools\LdapManager;
use LdapTools\Exception\LdapConnectionException;


class PlatformController extends Controller
{
    /**
    * Lists all Platform entities.
    *
    * @Route("/platform", name="platform_list")
    * @Route("/platform/{cn}", name="platform_edit")
    */
    public function indexAction($cn=null)
    {
        if ( is_null($cn) )
            return $this->render('ZacaciaBundle:Platform:index.html.twig');
        else
            return $this->render('ZacaciaBundle:Platform:edit.html.twig');
    }
    
    /**
    * Add Platform entity.
    *
    * @Route("/platform/add", name="platform_add")
    */
    public function addAction()
    {
        return $this->render('ZacaciaBundle:Platform:add.html.twig');
    }
    


    /**
    * API : Lists all Platform entities.
    *
    * @Route("/api/platforms")
    * @Method("GET")
    */
    public function getallAction()
    {
        $config = (new Configuration())->load($this->container->get('kernel')->locateResource('@ZacaciaBundle/Resources/config/zacacia.yml'));
        $ldap = new LdapManager($config);

        $query = $ldap->buildLdapQuery();

        $platforms = $query->select()
            ->setBaseDn('ou=Platforms,ou=Zacacia,ou=Applications,dc=zarafa,dc=com')
            ->from('Platform')
            ->Where(['zacaciaStatus' => 'enable'])
            ->orderBy('cn')
            ->getLdapQuery()
            ->getResult();

        $data = Array();

        foreach( $platforms as $platform ) {
            $item = array();
            $item['dn'] = $platform->getDn();
            $item['cn'] = $platform->getCn();
            $item['zacaciaStatus'] = $platform->getZacaciaStatus();
            $data[] = $item;
        }

        return new JsonResponse($data);
    }
}