#!/bin/bash
customerId="4162"
password=`echo 'L+n6*5di/&'`
timestampServerAddress="http://tzd.kamusm.gov.tr"
timestampServerPort="80"

scriptPath="$(dirname "$(readlink -f "$0")")"
hostName=`hostname`

if [ "$hostName" = "lindneo" ]
then
        targetMAC="00:16:3e:69:ae:57"
        targetIP="31.210.53.80"
        targetIF="eth0"
elif [ "$hostName" = "baracuda" ]
then
        targetMAC="08:00:27:a5:b1:7e"
        targetIP="94.103.35.20"
        targetIF="wlan0"
else
	targetMAC="6c:71:d9:bf:27:7b"
	targetIP="192.168.1.21"
	targetIF="wlan0"
fi

# exported functions
checkBalance(){
	balance=`java -jar zamane.jar -k $timestampServerAddress $timestampServerPort $customerId $password|awk '{print $3}'`
	if echo $balance | egrep -q '^[0-9]+$';
	then
		status=1
   		printf '{"status":%d,"result":%d}\n' $status $balance
	else
		status=0
   		printf '{"status":%d,"result":{"message":"balance cannot be checked right now!"}}\n' $status
	fi
}

doStamp()
{
	if [ -f "$1" ]
	then
		filePath=$(basename "$1")
		fileName="${filePath%.*}"
		stampPath=$filePath".zd"
		`rm -f $stampPath`
		stamp=`java -jar zamane.jar -z $filePath $timestampServerAddress $timestampServerPort $customerId $password`	
		if [ -f "$stampPath" ]
		then
			stampFile=$scriptPath"/"$stampPath
			status=1
			if [ "$2" = "" ]
			then
				printf '{"status":%d,"result":{"path":%s,"message":%s}}\n' $status $stampFile "$stamp"
			else
				`mv $stampFile $2; rm -f $stampFile`
				printf '{"status":%d,"result":{"path":%s,"message":%s}}\n' $status $2 "$stamp"
			fi
		else
			status=0
	   		printf '{"status":%d,"result":{"message":"timestamp could not be created!"}}\n' $status	
		fi
	else
		status=0
   		printf '{"status":%d,"result":{"message":"file not found!"}}\n' $status		
	fi


	#echo $balance
}

checkStamp()
{
	echo "checkstamp"
	checkstamp=`java -jar zamane.jar -c $1 $2`
	if [ -f "$1" -a -f "$2" ]
	then
		status=1
   		printf '{"status":%d,"result":{"message":"stamp confimed!"}}\n' $status		
	else
		status=0
   		printf '{"status":%d,"result":{"message":"files do not exist!"}}\n' $status		
	fi
}
  
#helper functions
authenticateSoftware(){
	retrievedMAC=`ifconfig -a $targetIF | grep $targetIF | awk '{print $5}'`
	retrievedIP=`ifconfig -a $targetIF | grep "inet addr"| awk '{split($2,result,":");print result[2];}'`;
	echo $retrievedIP $retrievedMAC $targetIP $targetMAC 
	if [ "$retrievedMAC" != "$targetMAC" -o  "$retrievedIP" != "$targetIP" ]
	then
		exit	
   	fi
}

#main
#authenticateSoftware
if [ "$1" = "checkBalance" ]
then
	checkBalance
elif [ "$1" = "doStamp" ]
then
	doStamp $2 $3
	#2:file to be stamped,
	#3:the path to be stored into if requested(optional)
elif [ "$1" = "checkStamp" ]
then
	checkStamp $2 $3
	#2:file path
	#3:stamp path
else
	echo "sdfsddsf"
fi

