<?php

namespace ZacaciaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use LdapTools\Configuration;
use LdapTools\LdapManager;
use LdapTools\Exception\LdapConnectionException;


class PlatformController extends Controller
{
    public function indexAction()
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

        echo "Found ".$platforms->count()." platforms.";
        echo "<ul>";
        foreach ($platforms as $platform) {
            echo "<li>Platform: ".$platform->getCn();
        }
        echo "</ul>";

        $ldapObject = $ldap->createLdapObject();


        try {
            $new_platform = $ldapObject->create('Platform')
                ->in('ou=Platforms,ou=Zacacia,ou=Applications,dc=zarafa,dc=com')
                ->setDn('cn=StLouis,ou=Platforms,ou=Zacacia,ou=Applications,dc=zarafa,dc=com')
                ->with([
                    'objectClass' => ['top', 'organizationalRole', 'zacaciaPlatform'],
                    'cn' => 'StLouis',
                    'zacaciaStatus' => 'enable'
                ])
                ->execute();
        } catch (LdapConnectionException $e) {
            echo "Failed to add user!".PHP_EOL;
            echo $e->getMessage().PHP_EOL;
        }

        exit;

        return $this->render('ZacaciaBundle:Platform:index.html.twig');
    }
}
