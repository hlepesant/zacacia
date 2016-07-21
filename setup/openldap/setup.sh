#!/bin/bash

export DEBIAN_FRONTEND="noninteractive"

echo "slapd slapd/root_password password password" |debconf-set-selections
echo "slapd slapd/root_password_again password password" |debconf-set-selections
echo "slapd slapd/internal/adminpw password password" |debconf-set-selections
echo "slapd slapd/internal/generated_adminpw password password" |debconf-set-selections
echo "slapd slapd/password2 password password" |debconf-set-selections
echo "slapd slapd/password1 password password" |debconf-set-selections
echo "slapd slapd/domain string zarafa.com" |debconf-set-selections
echo "slapd shared/organization string Zarafa" |debconf-set-selections
echo "slapd slapd/backend string MDB" |debconf-set-selections
echo "slapd slapd/purge_database boolean true" |debconf-set-selections
echo "slapd slapd/move_old_database boolean true" |debconf-set-selections
echo "slapd slapd/allow_ldap_v2 boolean false" |debconf-set-selections
echo "slapd slapd/no_configuration boolean false" |debconf-set-selections

apt-get install -y slapd ldap-utils

apt-get clean

dpkg-reconfigure slapd

/bin/cp qmail.schema /etc/ldap/schema/qmail.schema
/bin/cp zarafa.schema /etc/ldap/schema/zarafa.schema
/bin/cp zacacia.schema /etc/ldap/schema/zacacia.schema
 
/bin/mkdir /tmp/slapd.d

/usr/sbin/slaptest -f /opt/WebSites/zacacia/setup/openldap/zacacia.conf -F /tmp/slapd.d/

/bin/cp "/tmp/slapd.d/cn=config/cn=schema/cn={4}qmail.ldif" "/etc/ldap/slapd.d/cn=config/cn=schema"
/bin/cp "/tmp/slapd.d/cn=config/cn=schema/cn={5}zarafa.ldif" "/etc/ldap/slapd.d/cn=config/cn=schema"
/bin/cp "/tmp/slapd.d/cn=config/cn=schema/cn={6}zacacia.ldif" "/etc/ldap/slapd.d/cn=config/cn=schema"

chown openldap:openldap '/etc/ldap/slapd.d/cn=config/cn=schema/cn={4}qmail.ldif'
chown openldap:openldap '/etc/ldap/slapd.d/cn=config/cn=schema/cn={5}zarafa.ldif'
chown openldap:openldap '/etc/ldap/slapd.d/cn=config/cn=schema/cn={6}zacacia.ldif'

/etc/init.d/slapd restart

## if [ -f "pwd.ldif" ]
## then
## 	/usr/bin/ldapmodify -Y EXTERNAL -H ldapi:/// -f /tmp/pwd.ldif
## fi

if [ -f "olcLog.ldif" ]
then
    mkdir -p /var/log/openldap
    touch /var/log/openldap/ldap.log
    chown openldap:openldap /var/log/openldap
    /usr/bin/ldapmodify -Y EXTERNAL -H ldapi:/// -f olcLog.ldif
fi

if [ -f "olcDbIndex.ldif" ]
then
	/usr/bin/ldapmodify -Y EXTERNAL -H ldapi:/// -f olcDbIndex.ldif
fi

# if [ -f "zacacia.ldif" ]
# then
# 	/usr/bin/ldapadd -x -D cn=admin,dc=zarafa,dc=com -w password -f zacacia.ldif
# fi

/etc/init.d/slapd stop
rm /var/lib/ldap/*
slapadd -l zacacia.ldif 
chown -R openldap:openldap /var/lib/ldap
/etc/init.d/slapd start
