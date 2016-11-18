#!/bin/bash

#-------------------#
#----- Helpers -----#
#-------------------#

usage() {
    echo "$0 [COMMAND] [ARGUMENTS]"
    echo "  Commands:"
    echo "  - start: boots up docker with docker-compose"
    echo "  - stop: shuts down the docker-compose stack"
    echo "  - composer: run composer"
    echo "  - bower: run bower"
    echo "  - console: run console"
}

fn_exists() {
    type $1 2>/dev/null | grep -q 'is a function'
}

COMMAND=$1
shift
ARGUMENTS=${@}

#--------------------#
#----- Commands -----#
#--------------------#

composer() { 
    docker-compose exec symfony composer ${@};
}

bower() {  
    docker-compose exec nodejs bower ${@};
}

console() { 
    docker-compose exec symfony bin/console ${@};
}

start() {
    docker-compose up -d
}

stop() {
    docker-compose stop
}


#---------------------#
#----- Execution -----#
#---------------------#

fn_exists $COMMAND
if [ $? -eq 0 ]; then
    $COMMAND $ARGUMENTS
else
    usage
fi