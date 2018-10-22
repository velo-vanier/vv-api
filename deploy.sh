#!/bin/bash
ENV=$1
if [ $# -ne 3 ]; then
    echo $0: usage: $0 PROFILE REPO_URL REPO_NAME
    exit 1
fi

PROFILE="$1"
REPO_URL="$2.dkr.ecr.us-east-2.amazonaws.com"
REPO_NAME="$3"

echo "Profile: "$PROFILE
echo "Repo URL: "$REPO_URL
echo "Repo Name: "$REPO_NAME
echo

$(aws ecr get-login --no-include-email --region us-east-2 --profile $PROFILE)

docker build -f docker/php71-fpm/Dockerfile -t $REPO_NAME-data .
docker tag $REPO_NAME-fpm:latest $REPO_URL/$REPO_NAME-fpm:latest
docker push $REPO_URL/$REPO_NAME-fpm:latest

docker build -f docker/nginx/Dockerfile -t $REPO_NAME-nginx .
docker tag $REPO_NAME-nginx:latest $REPO_URL/$REPO_NAME-nginx:latest
docker push $REPO_URL/$REPO_NAME-nginx:latest

docker build -f docker/data/Dockerfile -t $REPO_NAME-data .
docker tag $REPO_NAME-data:latest $REPO_URL/$REPO_NAME-data:latest
docker push $REPO_URL/$REPO_NAME-data:latest
