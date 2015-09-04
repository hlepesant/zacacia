#!/bin/bash

DEBIAN_FRONTEND=noninteractive aptitude install -q -y

PASS='password'
DOMAIN='zarafa.com'
DN='dc=zarafa,dc=com'
ORGANIZATION='Zarafa'

apt-get update

cat << EOF | sudo debconf-set-selections
slapd slapd/root_password password ${PASS}
slapd slapd/root_password_again password ${PASS}
slapd slapd/internal/adminpw password ${PASS}
slapd slapd/internal/generated_adminpw password ${PASS}
slapd slapd/password2 password ${PASS}
slapd slapd/password1 password ${PASS}
slapd slapd/domain string ${DOMAIN}
slapd shared/organization string ${ORGANIZATION}
slapd slapd/backend string HDB
slapd slapd/purge_database boolean true
slapd slapd/move_old_database boolean true
slapd slapd/allow_ldap_v2 boolean false
slapd slapd/no_configuration boolean false
EOF

apt-get install -y slapd ldap-utils
dpkg-reconfigure -f noninteractive slapd

cp zacacia.conf /tmp/zacacia.conf
cp qmail.schema /etc/ldap/schema/qmail.schema
cp zarafa.schema /etc/ldap/schema/zarafa.schema
cp zacacia.schema /etc/ldap/schema/zacacia.schema
 
/bin/mkdir /tmp/slapd.d
/usr/sbin/slaptest -f /tmp/zacacia.conf -F /tmp/slapd.d/
/bin/cp "/tmp/slapd.d/cn=config/cn=schema/cn={4}qmail.ldif" "/etc/ldap/slapd.d/cn=config/cn=schema"
/bin/cp "/tmp/slapd.d/cn=config/cn=schema/cn={5}zarafa.ldif" "/etc/ldap/slapd.d/cn=config/cn=schema"
/bin/cp "/tmp/slapd.d/cn=config/cn=schema/cn={6}zacacia.ldif" "/etc/ldap/slapd.d/cn=config/cn=schema"
chown openldap:openldap '/etc/ldap/slapd.d/cn=config/cn=schema/cn={4}qmail.ldif'
chown openldap:openldap '/etc/ldap/slapd.d/cn=config/cn=schema/cn={5}zarafa.ldif'
chown openldap:openldap '/etc/ldap/slapd.d/cn=config/cn=schema/cn={6}zacacia.ldif'

/etc/init.d/slapd restart

hash_pw=`slappasswd -s ${PASS}`

cat << EOF > database.ldif
dn: olcDatabase={1}hdb,cn=config
changetype: modify
replace: olcRootPW
olcRootPW: ${hash_pw}

dn: olcDatabase={0}config,cn=config
changetype: modify
replace: olcRootPW
olcRootPW: ${hash_pw}

dn: cn=config
changetype: modify
replace: olcLogLevel
olcLogLevel: stats

dn: cn=config
changetype: modify
replace: olcLogFile
olcLogFile: /var/log/slapd.log
EOF


if [ -f "database.ldif" ]
then
	/usr/bin/ldapmodify -Y EXTERNAL -H ldapi:/// -f database.ldif
fi

if [ -f "zacacia.ldif" ]
then
	/usr/bin/ldapadd -x -D  cn=admin,dc=zarafa,dc=com -w password -f zacacia.ldif
fi

rm -rf /tmp/slap.d
rm /tmp/zacacia.conf
rm database.ldif
