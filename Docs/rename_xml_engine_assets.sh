#!/bin/bash

#Folder='/Volumes/VoigtKampff/DTO/XmlEngine_Assets/inbox/transportation/sonydto/'
Folder='/home/dcurras/Desarrollos/SitiosWeb/MTV/xmle/branches/currasd/Docs/inbox-test/conversion/itunesdto/'
Command='/home/dcurras/Desarrollos/SitiosWeb/MTV/xmle/branches/currasd/Docs/inbox-test/conversion/itunesdto/*.xml'

#	ls $Folder*.xml | awk '{print "mv "$Folder""$1" "$Folder""$1"'
#	ls $Folder*.xml | awk Desarrollos/SitiosWeb/MTV/xmle/branches/currasd/Docs/inbox-test/conversion/itunesdto/"$1" Desarrollos/SitiosWeb/MTV/xmle/branches/currasd/Docs/inbox-test/conversion/itunesdto/"$1".new"}' | sh


for fileName in `ls $Command; do
	echo "Moving file $fileName to $Folder... "
done
