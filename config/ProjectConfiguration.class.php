<?php

require_once dirname(__FILE__).'/../lib/vendor/symfony/lib/autoload/sfCoreAutoload.class.php';
sfCoreAutoload::register();

class ProjectConfiguration extends sfProjectConfiguration
{
  public function setup()
  {
    sfConfig::set('sf_logging_enabled', true);

    sfConfig::set('projetctName', 'Zacacia');
    sfConfig::set('projetctDesc', 'zarafa + ldap = Zacacia');

    sfConfig::set('widgetNameFormat', 'zdata');
    sfConfig::set('widgetFormaterName', 'Zacacia');

# Ldap Internal
    sfConfig::set('ldap_host', "localhost");
    sfConfig::set('ldap_use_ssl', false);
    sfConfig::set('ldap_root_dn', "cn=admin,dc=zarafa,dc=com");
    sfConfig::set('ldap_root_pw', "TheTreeThatHidesTheForest");
    sfConfig::set('ldap_base_dn', 'ou=Zacacia,ou=Applications,dc=zarafa,dc=com');

# Zarafa Internal
    sfConfig::set('zarafaHttpPort', 236);
    sfConfig::set('zarafaSslPort', 237);

    sfConfig::set('domain_pattern', '/^([a-z0-9]([-a-z0-9]*[a-z0-9])?\\.)+((a[cdefgilmnoqrstuwxz]|aero|arpa)|(b[abdefghijmnorstvwyz]|biz)|(c[acdfghiklmnorsuvxyz]|cat|com|coop)|d[ejkmoz]|(e[ceghrstu]|edu)|f[ijkmor]|(g[abdefghilmnpqrstuwy]|gov)|h[kmnrtu]|(i[delmnoqrst]|info|int)|(j[emop]|jobs)|k[eghimnprwyz]|l[abcikrstuvy]|(m[acdghklmnopqrstuvwxyz]|mil|mobi|museum)|(n[acefgilopruz]|name|net)|(om|org)|(p[aefghklmnrstwy]|pro)|qa|r[eouw]|s[abcdeghijklmnortvyz]|(t[cdfghjklmnoprtvwz]|travel)|u[agkmsyz]|v[aceginu]|w[fs]|y[etu]|z[amw])$/i');
    sfConfig::set('hostname_pattern', '/^(([a-z0-9]+|([a-z0-9]+[-]+[a-z0-9]+))[.])+(AC|AD|AE|AERO|AF|AG|AI|AL|AM|AN|AO|AQ|AR|ARPA|AS|ASIA|AT|AU|AW|AX|AZ|BA|BB|BD|BE|BF|BG|BH|BI|BIZ|BJ|BM|BN|BO|BR|BS|BT|BV|BW|BY|BZ|CA|CAT|CC|CD|CF|CG|CH|CI|CK|CL|CM|CN|CO|COM|COOP|CR|CU|CV|CX|CY|CZ|DE|DJ|DK|DM|DO|DZ|EC|EDU|EE|EG|ER|ES|ET|EU|FI|FJ|FK|FM|FO|FR|GA|GB|GD|GE|GF|GG|GH|GI|GL|GM|GN|GOV|GP|GQ|GR|GS|GT|GU|GW|GY|HK|HM|HN|HR|HT|HU|ID|IE|IL|IM|IN|INFO|INT|IO|IQ|IR|IS|IT|JE|JM|JO|JOBS|JP|KE|KG|KH|KI|KM|KN|KP|KR|KW|KY|KZ|LA|LB|LC|LI|LK|LR|LS|LT|LU|LV|LY|MA|MC|MD|ME|MG|MH|MIL|MK|ML|MM|MN|MO|MOBI|MP|MQ|MR|MS|MT|MU|MUSEUM|MV|MW|MX|MY|MZ|NA|NAME|NC|NE|NET|NF|NG|NI|NL|NO|NP|NR|NU|NZ|OM|ORG|PA|PE|PF|PG|PH|PK|PL|PM|PN|PR|PRO|PS|PT|PW|PY|QA|RE|RO|RS|RU|RW|SA|SB|SC|SD|SE|SG|SH|SI|SJ|SK|SL|SM|SN|SO|SR|ST|SU|SV|SY|SZ|TC|TD|TEL|TF|TG|TH|TJ|TK|TL|TM|TN|TO|TP|TR|TRAVEL|TT|TV|TW|TZ|UA|UG|UK|US|UY|UZ|VA|VC|VE|VG|VI|VN|VU|WF|WS|XN|XN|XN|XN|XN|XN|XN|XN|XN|XN|XN|YE|YT|YU|ZA|ZM|ZW)[.]?$/i');
    sfConfig::set('company_pattern', '/^([a-z0-9]+)$/i');

#
# Quota : http://doc.zarafa.com/6.40/Administrator_Manual/en-US/html/_multi_tenancy_configurations.html#_quota_levels
#
# Company Quota
# - Global Company Quota
    sfConfig::set('global_company_quota_warn', 0);
# - Specific Company Quota (select in options )
    sfConfig::set('options_company_quota_warn', array(
        '5120'    => '5 Go',
        '10240'   => '10 Go',
        '25600'   => '25 Go',
        '51200'   => '50 Go',
        '102400'  => '100 Go',
        '512000'  => '500 Go',
        '1024000' => '1 To',
    ));
#
# User Quota
# - Global User Quota
    sfConfig::set('server_user_quota_hard', 250);
    sfConfig::set('server_user_quota_warn', ceil(sfConfig::get('server_quota_hard') * sfConfig::get('warnQuota')));
    sfConfig::set('server_user_quota_soft', ceil(sfConfig::get('server_quota_hard') * sfConfig::get('softQuota')));
# - Company User Quota
# - Specific User Quota
# - Options for select
    sfConfig::set('options_user_quota_hard', array(
        '256'  => '250 Mo',
        '512'  => '500 Mo',
        '1024' => '1 Go',
        '2048' => '2 Go',
        '0'    => 'Unlimited',
    ));
    sfConfig::set('ratio_quota_hard', 1.00 );
    sfConfig::set('ratio_quota_soft', 0.90 );
    sfConfig::set('ratio_quota_warn', 0.80 );

    #sfConfig::set('server_user_quota_default', sfConfig::get('server_user_quota_hard'));
    sfConfig::set('server_user_quota_default', 0);
# End Quota

    sfConfig::set('username_format', '%s%s'); // hlepesant
    #sfConfig::set('username_format', '%s.%s'); // h.lepesant
    #sfConfig::set('username_format', '%s_%s'); // h_lepesant
    sfConfig::set('uid_min', 10001);
    sfConfig::set('gid_min', 10001);
    sfConfig::set('default_gid_number', 10000);


    sfConfig::set('awk', '/usr/bin/awk');
    sfConfig::set('ping', '/bin/ping');
    sfConfig::set('grep', '/bin/grep');

    sfConfig::set('undefined', '_undefined_');
  }
}
