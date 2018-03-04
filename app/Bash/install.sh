#!/bin/bash


#Initial update
apt-get update -y
apt-get upgrade -y

#Install trinity prerequisite
apt-get install git clang cmake make gcc g++ libmariadbclient-dev libssl1.0-dev libbz2-dev libreadline-dev libncurses-dev libboost-all-dev p7zip -y
update-alternatives --install /usr/bin/cc cc /usr/bin/clang 100
update-alternatives --install /usr/bin/c++ c++ /usr/bin/clang 100

#Download and compile Trinity Core
cd /usr/local/
git clone -b 3.3.5 git://github.com/TrinityCore/TrinityCore.git
cd TrinityCore
mkdir build
cd build
y | cmake ../ -DCMAKE_INSTALL_PREFIX=/usr/local/WoWServer -DTOOLS=1 #TO-DO: ADD variable for DTOOLS and for USER

#Install Server
make -j $(nproc) install

#Download and Extract Last DB
last_db="https://github.com/TrinityCore/TrinityCore/releases/download/TDB335.64/TDB_full_world_335.64_2018_02_19.7z"
wget $last_db
7za e TDB_*
cp TDB_*.sql /root/server/bin

#Download Create File
create_file="https://github.com/TrinityCore/TrinityCore/blob/3.3.5/sql/create/create_mysql.sql"
wget $create_file

#Install DB
mysql_user=""
if [ "$mysql_user" == "" ]; then
  echo "Enter your MySQL User :";
  read mysql_user
fi

mysql_pass=""
if [ "$mysql_pass" == "" ]; then
  echo "Enter your MySQL Password :";
  read mysql_pass
fi

mysql -u $mysql_user -p$mysql_pass < ./create_mysql.sql



