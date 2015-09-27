<?php

namespace ZacaciaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
#use Toyota\Component\Ldap\Core\Manager;
#use Toyota\Component\Ldap\Platform\Native\Driver;

use Dreamscapes\Ldap\Core\Ldap;


class PlatformController extends Controller
{
    public function indexAction()
    {
/*
        $params = array(
            'hostname'      => 'ldap',
            'port'          => 389,
            'base_dn'       => 'ou=Zacacia,ou=Applications,dc=zarafa,dc=com',
            'bind_dn'       => 'cn=admin,dc=zarafa,dc=com',
            'bind_password' => 'password',
            'options'       => array(
                LDAP_OPT_DEBUG_LEVEL => 7,
                LDAP_OPT_PROTOCOL_VERSION => 3
            )
        );


        $manager = new Manager($params, new Driver());

        try {
            $manager->connect();
        } catch ( ConnectionException $e ){
            print "error ldap : connect";
            exit;
        }
   
        try {
            $manager->bind('cn=admin,dc=zarafa,dc=com', 'password');
        } catch ( ConnectionException $e ){
            print "error ldap : bind";
            exit;
        }

        $results = $manager->search(false, 'ou=Platforms,ou=Zacacia,ou=Applications,dc=zarafa,dc=com', '(&(objectclass=zacaciaPlatform)(objectClass=top)(objectClass=organizationalRole))');
        print_r( $results );
        exit;

        foreach ($results as $node) {
            echo $node->getDn();
            foreach ($node->getAttributes() as $attribute) {
                echo sprintf('%s => %s', $attribute->getName(), implode(',', $attribute->getValues()));
            }
        }
        exit;
 */
        $con = new Ldap('ldap://ldap');
        $con->bind('cn=admin,dc=zarafa,dc=com', 'password');

        $res = $con->search('ou=Platforms,ou=Zacacia,ou=Applications,dc=zarafa,dc=com', '(&(objectclass=zacaciaPlatform)(objectClass=top)(objectClass=organizationalRole))');
        print_r($res->getEntries());

        exit;

        return $this->render('ZacaciaBundle:Platform:index.html.twig');
    }
}
