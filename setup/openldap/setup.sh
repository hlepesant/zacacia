#!/bin/bash


/bin/cp qmail.schema /etc/ldap/schema/qmail.schema
/bin/cp zarafa.schema /etc/ldap/schema/zarafa.schema
/bin/cp zacacia.schema /etc/ldap/schema/zacacia.schema
 
/bin/mkdir /tmp/slapd.d
/usr/sbin/slaptest -f /root/zacacia.conf -F /tmp/slapd.d/
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

if [ -f "zacacia.ldif" ]
then
	/usr/bin/ldapadd -x -D cn=admin,dc=zarafa,dc=com -w password -f zacacia.ldif
fi
