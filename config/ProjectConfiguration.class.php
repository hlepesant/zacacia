<?php

require_once dirname(__FILE__).'/../lib/vendor/symfony/lib/autoload/sfCoreAutoload.class.php';
sfCoreAutoload::register();

class ProjectConfiguration extends sfProjectConfiguration
{
  public function setup()
  {
    $this->enablePlugins('sfProtoculousPlugin');

    sfConfig::set('sf_logging_enabled', true);
  
    sfConfig::set('projetctName', 'MinivISP');
    sfConfig::set('projetctDesc', 'Zarafa Identity Lifecycle Wanager');

    sfConfig::set('widgetNameFormat', 'minidata');
    sfConfig::set('widgetFormaterName', 'MinivISP');
    #sfConfig::set('navigation_look', 'dropdown');
    sfConfig::set('navigation_look', 'link');

# Ldap Internal
    sfConfig::set('ldap_host', "localhost");
    sfConfig::set('ldap_use_ssl', false);
    sfConfig::set('ldap_root_dn', "cn=admin,dc=minivisp,dc=org");
    sfConfig::set('ldap_root_pw', "minivisp");
    sfConfig::set('ldap_bind_dn', 'ou=MinivISP,dc=minivisp,dc=org');

    sfConfig::set('domain_pattern', '/^([a-z0-9]([-a-z0-9]*[a-z0-9])?\\.)+((a[cdefgilmnoqrstuwxz]|aero|arpa)|(b[abdefghijmnorstvwyz]|biz)|(c[acdfghiklmnorsuvxyz]|cat|com|coop)|d[ejkmoz]|(e[ceghrstu]|edu)|f[ijkmor]|(g[abdefghilmnpqrstuwy]|gov)|h[kmnrtu]|(i[delmnoqrst]|info|int)|(j[emop]|jobs)|k[eghimnprwyz]|l[abcikrstuvy]|(m[acdghklmnopqrstuvwxyz]|mil|mobi|museum)|(n[acefgilopruz]|name|net)|(om|org)|(p[aefghklmnrstwy]|pro)|qa|r[eouw]|s[abcdeghijklmnortvyz]|(t[cdfghjklmnoprtvwz]|travel)|u[agkmsyz]|v[aceginu]|w[fs]|y[etu]|z[amw])$/i');

    sfConfig::set('uid_min', 10001);
    sfConfig::set('gid_min', 10001);
    sfConfig::set('default_gid_number', 10000);

    sfConfig::set('kilobyte', 1024);
    sfConfig::set('megabyte', (int)(1024 * 1024));
    sfConfig::set('quota_soft_ratio', (float)(90 / 100));
    sfConfig::set('quota_warn_ratio', (float)(80 / 100));

    sfConfig::set('user_default_quota', 250);
  }
}
