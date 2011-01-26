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
    sfConfig::set('projetctDesc', 'Identity Lifecycle Wanager for Zarafa');

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

# Zarafa Internal
    sfConfig::set('zarafaHttpPort', 236);
    sfConfig::set('zarafaSslPort', 237);

    sfConfig::set('domain_pattern', '/^([a-z0-9]([-a-z0-9]*[a-z0-9])?\\.)+((a[cdefgilmnoqrstuwxz]|aero|arpa)|(b[abdefghijmnorstvwyz]|biz)|(c[acdfghiklmnorsuvxyz]|cat|com|coop)|d[ejkmoz]|(e[ceghrstu]|edu)|f[ijkmor]|(g[abdefghilmnpqrstuwy]|gov)|h[kmnrtu]|(i[delmnoqrst]|info|int)|(j[emop]|jobs)|k[eghimnprwyz]|l[abcikrstuvy]|(m[acdghklmnopqrstuvwxyz]|mil|mobi|museum)|(n[acefgilopruz]|name|net)|(om|org)|(p[aefghklmnrstwy]|pro)|qa|r[eouw]|s[abcdeghijklmnortvyz]|(t[cdfghjklmnoprtvwz]|travel)|u[agkmsyz]|v[aceginu]|w[fs]|y[etu]|z[amw])$/i');
    sfConfig::set('hostname_pattern', '/^(([a-z0-9]+|([a-z0-9]+[-]+[a-z0-9]+))[.])+(AC|AD|AE|AERO|AF|AG|AI|AL|AM|AN|AO|AQ|AR|ARPA|AS|ASIA|AT|AU|AW|AX|AZ|BA|BB|BD|BE|BF|BG|BH|BI|BIZ|BJ|BM|BN|BO|BR|BS|BT|BV|BW|BY|BZ|CA|CAT|CC|CD|CF|CG|CH|CI|CK|CL|CM|CN|CO|COM|COOP|CR|CU|CV|CX|CY|CZ|DE|DJ|DK|DM|DO|DZ|EC|EDU|EE|EG|ER|ES|ET|EU|FI|FJ|FK|FM|FO|FR|GA|GB|GD|GE|GF|GG|GH|GI|GL|GM|GN|GOV|GP|GQ|GR|GS|GT|GU|GW|GY|HK|HM|HN|HR|HT|HU|ID|IE|IL|IM|IN|INFO|INT|IO|IQ|IR|IS|IT|JE|JM|JO|JOBS|JP|KE|KG|KH|KI|KM|KN|KP|KR|KW|KY|KZ|LA|LB|LC|LI|LK|LR|LS|LT|LU|LV|LY|MA|MC|MD|ME|MG|MH|MIL|MK|ML|MM|MN|MO|MOBI|MP|MQ|MR|MS|MT|MU|MUSEUM|MV|MW|MX|MY|MZ|NA|NAME|NC|NE|NET|NF|NG|NI|NL|NO|NP|NR|NU|NZ|OM|ORG|PA|PE|PF|PG|PH|PK|PL|PM|PN|PR|PRO|PS|PT|PW|PY|QA|RE|RO|RS|RU|RW|SA|SB|SC|SD|SE|SG|SH|SI|SJ|SK|SL|SM|SN|SO|SR|ST|SU|SV|SY|SZ|TC|TD|TEL|TF|TG|TH|TJ|TK|TL|TM|TN|TO|TP|TR|TRAVEL|TT|TV|TW|TZ|UA|UG|UK|US|UY|UZ|VA|VC|VE|VG|VI|VN|VU|WF|WS|XN|XN|XN|XN|XN|XN|XN|XN|XN|XN|XN|YE|YT|YU|ZA|ZM|ZW)[.]?$/i');


    sfConfig::set('uid_min', 10001);
    sfConfig::set('gid_min', 10001);
    sfConfig::set('default_gid_number', 10000);

    sfConfig::set('kilobyte', 1024);
    sfConfig::set('megabyte', (int)(1024 * 1024));
    sfConfig::set('quota_soft_ratio', (float)(90 / 100));
    sfConfig::set('quota_warn_ratio', (float)(80 / 100));

    sfConfig::set('user_default_quota', 250);

    sfConfig::set('awk', '/usr/bin/awk');
    sfConfig::set('ping', '/bin/ping');
    sfConfig::set('grep', '/bin/grep');
  }
}
