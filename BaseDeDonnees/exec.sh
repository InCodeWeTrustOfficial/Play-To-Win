#!/bin/bash

IMAGE_NAME="projet_web_script_bd"

docker build -t $IMAGE_NAME .

docker run --rm $IMAGE_NAME python creation_BD.py

echo "FIN DU SCRIPT"

