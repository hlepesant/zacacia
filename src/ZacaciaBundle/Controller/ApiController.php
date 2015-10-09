<?php

namespace ZacaciaBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

use LdapTools\Configuration;
use LdapTools\LdapManager;
use LdapTools\Exception\LdapConnectionException;


/**
 * @Route("/api")
 */
class ApiController extends Controller
{
    /**
    * API : Lists all Platform entities.
    *
    * @Route("/platform")
    * @Method("GET")
    */
    public function platformAction()
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

    /**
    * API : Lists all Platform entities.
    *
    * @Route("/platform/{cn}")
    * @Method("GET")
    */
    public function platformeditAction($cn)
    {
        $config = (new Configuration())->load($this->container->get('kernel')->locateResource('@ZacaciaBundle/Resources/config/zacacia.yml'));
        $ldap = new LdapManager($config);

        $query = $ldap->buildLdapQuery();

        $platform = $query->select()
            ->setBaseDn('ou=Platforms,ou=Zacacia,ou=Applications,dc=zarafa,dc=com')
            ->from('Platform')
            ->Where(['cn' => $cn])
            ->getLdapQuery()
            ->getSingleResult();

        $data = Array();

        $data['dn'] = $platform->getDn();
        $data['cn'] = $platform->getCn();
        $data['zacaciaStatus'] = $platform->getZacaciaStatus();

        return new JsonResponse($data);
    }
    
}
