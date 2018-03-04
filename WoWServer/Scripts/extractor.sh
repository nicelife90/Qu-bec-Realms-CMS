#!/bin/bash

#Extract DBC MAPS VMAPS MMAPS
wow=""
if [ "$wow" == "" ]; then
  echo "Enter Full Path of Your World of Warcraft 3.3.5 Directory :";
  read wow
fi

#DBC MAPS
cd $wow
/var/www/html/WoWServer/Server/bin/mapextractor
mkdir /var/www/html/WoWServer/Server/data
cp -r dbc maps /var/www/html/WoWServer/Server/data

#VMAPS
cd $wow
/var/www/html/WoWServer/Server/bin/vmap4extractor
mkdir vmaps
/var/www/html/WoWServer/Server/bin/vmap4assembler Buildings vmaps
cp -r vmaps /var/www/html/WoWServer/Server/data

#MMAPS
cd $wow
mkdir mmaps
/var/www/html/WoWServer/Server/bin/mmaps_generator
cp -r mmaps /var/www/html/WoWServer/Server/data
