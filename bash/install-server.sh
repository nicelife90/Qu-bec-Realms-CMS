#!/bin/bash

case "$1" in

        #########################################################################################
        #################################### INSTALL ############################################
        #########################################################################################
        install)

        # Init
        FILE="/tmp/out.$$"
        GREP="/bin/grep"

        # Make sure only root can run our script
        if [ "$(id -u)" != "0" ]; then
           echo "This script must be run as root" 1>&2
           exit 1
        fi

        #Initial update
        apt-get update -y
        apt-get upgrade -y

        #Install trinity prerequisite
        apt-get install git clang cmake make gcc g++ libmariadbclient-dev libssl1.0-dev libbz2-dev libreadline-dev libncurses-dev libboost-all-dev mysql-server p7zip apache2 php net-tools phpmyadmin -y
        update-alternatives --install /usr/bin/cc cc /usr/bin/clang 100
        update-alternatives --install /usr/bin/c++ c++ /usr/bin/clang 100

        #Secure MySQL
        mysql_secure_installation

        #Install phpmyadmin
        apt-get install phpmyadmin php-mbstring php-gettext
        phpenmod mcrypt
        phpenmod mbstring
        service apache2 restart

        #Download and compile Trinity Core
        cd ~/
        git clone -b 3.3.5 git://github.com/TrinityCore/TrinityCore.git
        cd TrinityCore
        mkdir build
        cd build
        cmake ../ -DCMAKE_INSTALL_PREFIX=/root/server -DTOOLS=1 #TO-DO: ADD variable for DTOOLS and for USER

        #Install Server
        make -j $(nproc) install

        #Download and Extract Last DB
        last_db="https://github.com/TrinityCore/TrinityCore/releases/download/TDB335.64/TDB_full_world_335.64_2018_02_19.7z"
        wget $last_db
        7zr e TDB_*
        yes | cp -f TDB_*.sql /root/server/bin

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

        cd ~/
        mysql -u $mysql_user -p$mysql_pass < TrinityCore/sql/create/create_mysql.sql

        #Prepare conf
        mv server/etc/authserver.conf.dist server/etc/authserver.conf
        mv server/etc/worldserver.conf.dist server/etc/worldserver.conf

        #Start server for first time
        server/bin/worldserver

        #create logs dir
        mkdir server/logs

        #edit conf file
        sed -i 's#LogsDir = ""#LogsDir = "../logs/"#g' server/etc/authserver.conf
        sed -i 's#LogsDir = ""#LogsDir = "../logs/"#g' server/etc/worldserver.conf
        sed -i 's#DataDir = "."#DataDir = "../data/"#g' server/etc/worldserver.conf

        #Get local IP
        local_ip="$(ifconfig | grep -Eo 'inet (addr:)?([0-9]*\.){3}[0-9]*' | grep -Eo '([0-9]*\.){3}[0-9]*' | grep -v '127.0.0.1')"

            ;;

        #########################################################################################
        ##################################### UPDATE ############################################
        #########################################################################################
        update)

        # Init
        FILE="/tmp/out.$$"
        GREP="/bin/grep"

        # Make sure only root can run our script
        if [ "$(id -u)" != "0" ]; then
           echo "This script must be run as root" 1>&2
           exit 1
        fi

        #Download and compile Trinity Core
        cd ~/TrinityCore/
        git pull origin 3.3.5
        cd TrinityCore
        rm -rf build
        mkdir build
        cd build
        cmake ../ -DCMAKE_INSTALL_PREFIX=/root/server -DTOOLS=1 #TO-DO: ADD variable for DTOOLS and for USER

        #Install Server
        make -j $(nproc) install

            ;;


        ##########################################################################################
        ##################################### EXTRACT-MAP ########################################
        ##########################################################################################
        extract-map)

        #Extract DBC MAPS VMAPS MMAPS
        wow=""
        if [ "$wow" == "" ]; then
          echo "Enter Full Path of Your World of Warcraft 3.3.5 Directory :";
          read wow
        fi

        #DBC MAPS
        cd $wow
        /root/server/bin/mapextractor
        mkdir /root/server/data
        cp -r dbc maps /root/server/data

        #VMAPS
        cd $wow
        /root/server/bin/vmap4extractor
        mkdir vmaps
        /root/server/bin/vmap4assembler Buildings vmaps
        cp -r vmaps /root/server/data

        #MMAPS
        cd $wow
        mkdir mmaps
        /root/server/bin/mmaps_generator
        cp -r mmaps /root/server/data

            ;;


        #########################################################################################
        ##################################### REPAIR ############################################
        #########################################################################################
        repair)

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

            mysql -u $mysql_user -p$mysql_pass < "DROP DATABASE world"

            ;;
        *)
            echo $"Usage: $0 {install|update|repair|extract-map}"
            exit 1

esac


