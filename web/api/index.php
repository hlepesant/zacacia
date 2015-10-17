<?php
require_once __DIR__ . '/../../vendor/autoload.php';

use Lcobucci\JWT\Builder;
use Lcobucci\JWT\Parser;

use LdapTools\Configuration;
use LdapTools\LdapManager;
use LdapTools\Exception\LdapConnectionException;


$app = new \Slim\Slim();


$app->get('/hello/:name', function ($name='hugues') {
    echo "Hello, $name";
});

$app->post('/signin', function () {

    var_dump($_GET);
    var_dump($_POST);
    exit;

    $token = (new Builder())->setIssuer('http://example.com') // Configures the issuer (iss claim)
        ->setAudience('http://example.org') // Configures the audience (aud claim)
        ->setId('4f1g23a12aa', true) // Configures the id (jti claim), replicating as a header item
        ->setIssuedAt(time()) // Configures the time that the token was issue (iat claim)
        ->setNotBefore(time() + 60) // Configures the time that the token can be used (nbf claim)
        ->setExpiration(time() + 3600) // Configures the expiration time of the token (exp claim)
        ->set('uid', 1) // Configures a new claim, called "uid"
        ->getToken(); // Retrieves the generated token

    echo $token;
});

$app->get('/platform/', function () {

        $config = (new Configuration())->load(__DIR__ . '/../../config/zacacia.yml');
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

        header("Content-Type: application/json");
        echo json_encode($data);
});

$app->get('/platform/:cn', function ($cn) {

        $config = (new Configuration())->load(__DIR__ . '/../../config/zacacia.yml');
        $ldap = new LdapManager($config);

        $query = $ldap->buildLdapQuery();

        $platform = $query->select()
            ->setBaseDn('ou=Platforms,ou=Zacacia,ou=Applications,dc=zarafa,dc=com')
            ->from('Platform')
            ->Where(['cn' => $cn])
            ->orderBy('cn')
            ->getLdapQuery()
            ->getSingleResult();

        $data = Array();

        $data['dn'] = $platform->getDn();
        $data['cn'] = $platform->getCn();
        $data['zacaciaStatus'] = $platform->getZacaciaStatus();

        header("Content-Type: application/json");
        echo json_encode($data);
});

$app->put('/platform/:cn', function ($cn) {

        print($cn);
        exit;
    
        $config = (new Configuration())->load(__DIR__ . '/../../config/zacacia.yml');
        $ldap = new LdapManager($config);

        $query = $ldap->buildLdapQuery();

        $platform = $query->select()
            ->setBaseDn('ou=Platforms,ou=Zacacia,ou=Applications,dc=zarafa,dc=com')
            ->from('Platform')
            ->Where(['cn' => $cn])
            ->orderBy('cn')
            ->getLdapQuery()
            ->getSingleResult();

        $data = Array();

        $data['dn'] = $platform->getDn();
        $data['cn'] = $platform->getCn();
        $data['zacaciaStatus'] = $platform->getZacaciaStatus();

        header("Content-Type: application/json");
        echo json_encode($data);
});

$app->run();
