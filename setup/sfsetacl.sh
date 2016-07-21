#!/bin/bash

sudo setfacl -R -m u:"www-data":rwX -m u:hugues:rwX var
sudo setfacl -dR -m u:www-data:rwX -m u:hugues:rwX var
./bin/console cache:clear -e dev
./bin/console cache:clear -e prod
