
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
