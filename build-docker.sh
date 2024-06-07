#!/bin/sh
# cd /home/www
# pwd
# git pull
docker stop um-ws
docker rm um-ws
docker rmi um-ws:develop
docker build . -t um-ws:develop
docker run -itd --name um-ws -v /Users/olie/SemicolonProjects/um-ws/project/src/main/resources:/root/resources -e "APPLICATION_PROPERTIES_LOCATION=/root/resources" -e "SPRING_PROFILES_ACTIVE=dev" --restart unless-stopped -p 8080:8080 um-ws:develop .
sleep 20s
docker logs um-ws
