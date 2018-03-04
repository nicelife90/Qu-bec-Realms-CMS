#!/bin/bash

#Download and compile Trinity Core
cd /var/www/html/WoWServer/TrinityCore/
git pull origin 3.3.5
rm -rf build
mkdir build
cd build
cmake ../ -DCMAKE_INSTALL_PREFIX=/var/www/html/WoWServer/Server -DTOOLS=1

#Install Server
yes | make -j $(nproc) install