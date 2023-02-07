`sudo apt install curl gnupg2 ca-certificates lsb-release debian-archive-keyring ubuntu-keyring`
`curl https://nginx.org/keys/nginx_signing.key | gpg --dearmor \
    | sudo tee /usr/share/keyrings/nginx-archive-keyring.gpg >/dev/null`
`sudo apt update`
`sudo apt install nginx-module-njs`