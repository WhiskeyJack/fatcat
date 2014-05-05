#!/bin/bash

# Parameters

PROGRAM_NAME=Feedme
VERSION=0.1
CHANGEDATE="April 27, 2014"
SCRIPTNAME=`basename $0`
TTYFOUND=false
WALLFOUND=true
NOTIFYFOUND=true
DATE=`date`
DIR=$( cd "$( dirname "$0" )" && pwd )
LOGFILE="$DIR/log/feedme.log"

FEEDCOMMANDON="echo 2=0% > /dev/servoblaster"
FEEDCOMMANDOFF="echo 2=50% > /dev/servoblaster"

DBNAME=catfeeder
DBUSER=cat
DBPASS=miauw

QUANTITY=0
SILENT=false
EVENTID=0
EVENTNAME=""
REPORTDB=false
NOACT=false
DEBUG=false
USELOG=true


usage(){
	echo "$PROGRAM_NAME v$VERSION ($CHANGEDATE)"
	echo " Usage: $SCRIPTNAME [arguments]"
	echo " Arguments:"
	echo "   -q  --quantity    quantity to feed (required)"
	echo "   -s  --silent      no output/broadcast to consoles"
	echo "   -e  --eventid     related eventid"
	echo "   -N  --eventname   related event name"
        echo "   -d  --debug       show debug output"
        echo "   -r  --reportdb    report result to db (requires eventid)"
        echo "   -n  --no-act      do not actually perform any action"
        echo "   -h  --help        this help message"
        echo "   -d  --debug       show debug output"
	exit 1
}

debug_param() {
	echo "Parameters:"
        echo "  quantity:   $QUANTITY"
        echo "  silent:     $SILENT"
        echo "  eventid:    $EVENTID"
        echo "  eventname:  $EVENTNAME"
        echo "  reportdb:   $REPORTDB"
        echo "  no-act:     $NOACT"
        echo "  debug:      $DEBUG"
	echo "  wall found: $WALLFOUND"
}


#check if at command is present
#command -v at >/dev/null 2>&1 || { 
#	echo " Program \"at\" not found. Cannot continue."
#	exit 0 
#}


# Parse arguments
#-quantity
#-silent
#-eventid
#-reportdb
#-no-act
#-help
#-debug
# http://stackoverflow.com/questions/2642707/shell-script-argument-parsing?answertab=votes#tab-top
# TEMP=$(getopt -n $PROGRAM_NAME -o p:P:cCkhnvVS --long domain-password:,pop3-password:,create,cron,kill,help,no-sync-passwords,version,verbose,skip-pop3 -- "$@")
TEMP=$(getopt -n $PROGRAM_NAME -o q:se:N:rnhd --long quantity:,silent,eventid:,name:reportdb,no-act,help,debug -- "$@") 

# check if we have at least one argument
if [ "$#" -lt 1 ]; then 
  echo "Error parsing arguments. Try $SCRIPTNAME --help"
  exit 0
fi


eval set -- "$TEMP"
while true; do
        case $1 in 
                -q|--quantity)
                        QUANTITY="$2"; shift; shift; continue
                ;;                                    
                -s|--silent)                            
                        SILENT=true; shift; continue  
                ;;                                    
                -e|--eventid)                            
                        EVENTID="$2"; shift; shift; continue  
                ;;                                    
                -N|--name)                            
                        EVENTNAME="$2"; shift; shift; continue  
                ;;                                    
                -h|--help)                            
                        usage                         
                        exit 0                        
                ;;                                    
                -r|--reportdb)               
                        REPORTDB=true; shift; continue 
                ;;                                    
                -n|--no-act)                 
                        NOACT=true; shift; continue
                ;;
                -d|--debug)                 
                        DEBUG=true; shift; continue
                ;;
                --)                                                                 
                        # no more arguments to parse                                
                        break                                                       
                ;;                                                                  
                *)                                                                  
                        printf "Unknown option %s\n" "$1"                           
                        exit 1                                                      
                ;;                                           
        esac                                                                        
done

#check if we have quantity
if [ "$QUANTITY" = "0" ]; then 
	echo "No quantity specified."
	exit 0
fi

#check if tty found / running from terminal
if [ -t 1 ] ; then 
   TTYFOUND=true 
fi


#check if wall is installed
command -v wall >/dev/null 2>&1 || { 
	WALLFOUND=false 
}

#check if notify-send is installed
command -v notify-send >/dev/null 2>&1 || { 
	NOTIFYFOUND=false 
}

## check debug
if [ "$DEBUG" = true ]; then
	debug_param
fi


## Perform feed action
MSG="Feeding $EVENTNAME with quantity $QUANTITY at $DATE"
if [ "$TTYFOUND" = true ]; then
	echo $MSG
fi
if [ "$WALLFOUND" = true ]; then
	# redirect output to prevent "wall: cannot get tty name: Inappropriate ioctl for device"
	echo $MSG | wall 2>&1
fi
if [ "$NOTIFYFOUND" = true ]; then
	notify-send -t 1000 "$PROGRAM_NAME" "$MSG"
fi
if [ "$USELOG" = true ]; then
	 echo "$MSG, eventid=$EVENTID" >> $LOGFILE 
fi
if [ "$EVENTID" -gt 0 ]; then
	SQL='UPDATE `catfeeder`.`event` SET `event_status_id` = '3' WHERE `event`.`id`='
    	SQL+="$EVENTID;"
	echo "Running SQL: $SQL" >> $LOGFILE	
	mysql --user=$DBUSER --password=$DBPASS $DBNAME -e "$SQL"
fi
## Running the command
eval $FEEDCOMMANDON
sleep $QUANTITY
eval $FEEDCOMMANDOFF
DATE=`date`
MSG="Feeding $EVENTNAME finished at $DATE"
if [ "$USELOG" = true ]; then
	 echo "$MSG, eventid=$EVENTID" >> $LOGFILE 
fi
if [ "$EVENTID" -gt 0 ]; then
	SQL='UPDATE `catfeeder`.`event` SET `event_status_id` = '4' WHERE `event`.`id`='
    	SQL+="$EVENTID;"
	echo "Running SQL: $SQL" >> $LOGFILE	
	mysql --user=$DBUSER --password=$DBPASS $DBNAME -e "$SQL"
fi
