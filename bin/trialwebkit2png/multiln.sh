#! /bin/bash
#time  xvfb-run -a -s "-screen 0 1024x768x24" /var/www/squid-pacific/ugur/bin/trialwebkit2png/multi.sh
PAGECOUNT='550';
for i in {1..550}
do
   
    /usr/bin/python /var/www/squid-pacific/ugur/bin/trialwebkit2png/webkit2png.py file:///var/www/testing/thumbnail/index.html  | convert - -thumbnail x200 /var/www/squid-pacific/ugur/bin/trialwebkit2png/thumbnails/out$i.png &
    if [ $(($i % 10)) -eq 0 ]
        then
        wait
    fi
done
wait

