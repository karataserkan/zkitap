#!/bin/bash

find . -type f -iname "*.php" > filelist && xgettext --keyword=__ --keyword=_e --keyword=_en:1,2 --keyword=_n:1,2   --from-code='UTF-8' --force-po --join-existing -n -i -o messages.po -p protected/locale/messages/en_US --files-from=filelist

