

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