Source
https://www.digitalocean.com/community/tutorials/how-to-create-a-self-signed-ssl-certificate-for-nginx-in-ubuntu-20-04-1
## Setup Nginx with SSL
- lakukan update OS `sudo apt update`, (opsional: Jalankan upgrade `sudo apt upgrade`)
- Instal nginx `sudo apt install nginx`
- Instal SSL module `sudo openssl req -x509 -nodes -days 365 -newkey rsa:2048 -keyout /etc/ssl/private/nginx-selfsigned.key -out /etc/ssl/certs/nginx-selfsigned.crt`
- Jalankan command berikut untuk melakukan edit file **self-signed.conf** `sudo nano /etc/nginx/snippets/self-signed.conf`
- Copy dan paste blok kode dibawah
- 

    ssl_certificate /etc/ssl/certs/nginx-selfsigned.crt;
    ssl_certificate_key /etc/ssl/private/nginx-selfsigned.key;

- Simpan file
- Lakukan command berikut untuk melakukan edit file **ssl-params.conf** `sudo nano /etc/nginx/snippets/ssl-params.conf`
- Kemudian copy and paste blok kode dibawah
- 

	ssl_protocols TLSv1.3;
	ssl_prefer_server_ciphers on;
	ssl_dhparam /etc/nginx/dhparam.pem; 
	ssl_ciphers EECDH+AESGCM:EDH+AESGCM;
	ssl_ecdh_curve secp384r1;
	ssl_session_timeout  10m;
	ssl_session_cache shared:SSL:10m;
	ssl_session_tickets off;
	ssl_stapling on;
	ssl_stapling_verify on;
	resolver 8.8.8.8 8.8.4.4 valid=300s;
	resolver_timeout 5s;
	# Disable strict transport security for now. You can uncomment the following
	# line if you understand the implications.
	#add_header Strict-Transport-Security "max-age=63072000; includeSubDomains; preload";
	add_header X-Frame-Options DENY;
	add_header X-Content-Type-Options nosniff;
	add_header X-XSS-Protection "1; mode=block";

- Lakukan command berikut untuk melakukan modifikasi pada file **default** `sudo nano /etc/nginx/sites-available/default`
- Hapus tagar/comment (#) pada blok kode
- 

    listen 443 ssl default_server;
    listen [::]:443 ssl delfault_server;
- Tambahkan blok kode berikut diatas `root` untuk menyisipkan module **self-signed.conf** dan **ssl-params.conf**
- 

    include snippets/self-signed.conf;
    include snippets/ssl-params.conf;

- Kemudian jalankan kode ini secara berurut untuk melakukan konfigurasi ***firewall***
- `sudo ufw allow 'Nginx Full'`
- `sudo ufw delete allow 'Nginx HTTP'`
- `sudo ufw allow 'OpenSSH'`
- Kemudian cek status firewall `sudo ufw status`
- Apabila ***status inactive*** maka jalankan command sebagai berikut `sudo ufw enable` 
- Dan jalankan command berikut untuk melakukan generate certification `sudo openssl dhparam -out /etc/nginx/dhparam.pem 4096`
- Lalu cek status nginx apabila generate certification telah selesai dengan command berikut `sudo nginx -t`
- Dan terakhir restart dan reload nginx 
- `sudo systemctl restart nginx`
- `sudo systemctl reload nginx`
