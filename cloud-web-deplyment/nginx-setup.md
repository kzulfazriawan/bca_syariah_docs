
# Guide Manual Instalasi Ubuntu Nginx BSIT2023

## Instalasi Nginx dengan SSL
1. Lakukan update OS dengan command `sudo apt update`
2. Jalankan upgrade OS `sudo apt upgrade -y`
3. Lakukan instalasi SSL dan requirement nya `sudo openssl req -x509 -nodes -days 365 -newkey rsa:2048 -keyout /etc/ssl/private/nginx-selfsigned.key -out /etc/ssl/certs/nginx-selfsigned.crt`
4. Ubah file ***self-signed.conf*** pada module nginx didalam folder **/etc/nginx/snippets/self-signed.conf**, dengan command berikut `sudo nano /etc/nginx/snippets/self-signed.conf`
5. Copy dan paste block code dibawah dengan cara highlight code dibawah dan Klik kanan pada terminal:
   
    ```nginx
    ssl_certificate /etc/ssl/certs/nginx-selfsigned.crt;
    ssl_certificate_key /etc/ssl/private/nginx-selfsigned.key;
    ```
6. Setelah itu simpan file dengan cara **Ctrl+X**, lalu **Y** dan **Enter**
7. Ubah file ***ssl-params.conf*** pada direktori **/etc/nginx/snippets/ssl-params.conf**, dengan command berikut `sudo nano /etc/nginx/snippets/ssl-params.conf`
8. Copy dan paste lagi block code dibawah dengan cara highlight semua code dibawah dan Klik kanan pada terminal:
   
    ```nginx
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

    ```

9. Setelah itu simpan file dengan cara **Ctrl+X**, lalu **Y** dan **Enter**
10. Modifikasi file ***default*** pada direktori **/etc/nginx/sites-available/** dengan lakukan command berikut `sudo nano /etc/nginx/sites-available/default`
11. Arahkan kursor kebawah hingga menemukan block kode yang di comment seperti dibawah ini:
    
    ```nginx
    # listen 443 ssl default_server;
    # listen [::]:443 ssl delfault_server;
    ```

12. Hapus tagar(#) untuk membuka baris code tersebut menjadi seperti dibawah ini:
    
    ```nginx
    listen 443 ssl default_server;
    listen [::]:443 ssl delfault_server;
    ```

13. Arahkan kursor kebawah hingga menemukan baris kode `root`, kemudian sisipkan diatas baris kode `root` dengan block code dibawah ini:
    
    ```nginx
    include snippets/self-signed.conf;
    include snippets/ssl-params.conf;
    ```

14. Block code tersebut akan menyisipkan file ***self-signed.conf*** dan ***ssl-params.conf*** yang sebelumnya sudah diubah kedalam ***default*** 
15. Setelah itu simpan file dengan cara **Ctrl+X**, lalu **Y** dan **Enter**
16. Pada step ini konfigurasi **Nginx** telah selesai
17. Kemudian lakukan konfigurasi pada firewall.
18. Lakukan command berikut `sudo ufw allow 'Nginx Full'` untuk menambahkan full-feature nginx kedalam firewall.
19. Lakukan command berikut `sudo ufw delete allow 'Nginx HTTP'` untuk menambahkan feature **nginx-http**
20. Langkah terakhir adalah membuka firewall untuk OpenSSH agar tetap terkoneksi : `sudo ufw allow 'OpenSSH'`
21. Cek status firewall dengan command berikut: `sudo ufw status`
22. Apabila ***status inactive*** maka jalankan command sebagai berikut `sudo ufw enable` untuk mengaktifkan firewall
23. Apabila login terputus atau tidak ada respon pada terminal, Tutup sesi kemudian buka **PuTTY** kembali dan login kembali dengan credentials yang disediakan.
24. Jalankan command berikut untuk melakukan generate certification SSL `sudo openssl dhparam -out /etc/nginx/dhparam.pem 4096`
25. Tunggu hingga proses selesai
26. Lalu cek status nginx apabila generate certification telah selesai dengan command berikut `sudo nginx -t`
27. Langkah terakhir adalah melakukan *restart* dan *reload* pada *Nginx*
28. Lakukan command restart nginx `sudo systemctl restart nginx.service` atau `sudo systemctl restart nginx`
29. Lakukan command reload nginx `sudo systemctl reload nginx.service` atau `sudo systemctl reload nginx`
30. Buka browser dan masukan alamat http://dns_isntance_aws/, apabila muncul koneksi tidak aman, tekan tombol ***Advance*** dan ***Proceed unsafe***

---
# Instalasi Frontend dan Backend pada Nginx dan Ubuntu

1. Pergi ke direktori ***/var/www/*** dengan command sebagai berikut `cd /var/www/`
2. Ubah permission owner direktori html dengan perintah `sudo chown ubuntu:ubuntu -R html/`
3. Masuk ke direktori ***html*** (`cd html/`) dan jalankan git clone repository bca_syariah_docs `git clone https://github.com/kzulfazriawan/bca_syariah_docs.git`
4. Ubah semua permission kembali menjadi Root, dengan cara pergi ke parent direktori `cd ..` dan lakukan `sudo chown root:root -R html/`
5. Masuk kembali kedalam direktori html `cd html/` dan ubah ownership direktori ***backend*** dan ***frontend*** menjadi ubuntu `sudo chown -R ubuntu:ubuntu -R frontend/` dan `sudo chown -R ubuntu:ubuntu -R backend/`
6. Kemudian cek ownership dan list file dengan command `ls -al`
7. Apabila ownership dan group direktori **frontend** dan **backend** adalah ***ubuntu:ubuntu*** maka step telah selesai

## Instalasi Frontend
1. Lakukan instalasi NodeJS versi LTS dan NPM dengan langkah berikut
```
1. cd ~
2. curl -sL https://deb.nodesource.com/setup_18.x -o nodesource_setup.sh
3. sudo ./nodesource_setup.sh
```
2. Instalasi NodeJS dengan langkah perintah berikut
```
1. sudo apt update
2. sudo apt install -y nodejs
```
3. Cek versi nodejs dengan perintah berikut `node -v` dan cek versi npm dengan perintah `npm -v`
4. Apabila sudah terinstal dengan versi yang sesuai yaitu ***node*** versi ***18***
5. Masuk kedalam direktori /var/www/html/bca_syariah_docs/frontend/ dengan perintah berikut `cd /var/www/html/bca_syariah_docs/frontend/`
6. Lalu jalankan instalasi npm dengan perintah `npm install`
7. Dan jalankan build development pada npm dengan perintah `nohup npm run dev > logfile.out &`
8. Masuk kedalam direktori /etc/nginx/sites-available/ dengan perintah `cd /etc/nginx/sites-available`
9. Lalu ubah file ***default*** dengan perintah berikut `sudo nano default`
10. Pada baris kode `root` ubah `root  /var/www/html` menjadi `root  /var/www/html/bca_syariah_docs/frontend/`
11. Lalu restart dan reload service nginx 
```
1. sudo systemctl restart nginx.service
2. sudo systemctl reload nginx.service
```
12. Buka browser dan jalankan https://<ip_instance_aws>/
    
## Instalasi Backend

1. Lakukan instalasi PHP dan beberapa dependency nya
```
1. sudo apt update
2. sudo apt install php php-zip php-xml php-gd php-dev php-gzip php-cli php-fpm php-mysql php-odbc unzip
```
2. Apabila instalasi telah selesai cek versi php yang terinstal dengan perintah berikut `php -v`
3. Kemudian instalasi composer dengan mengikuti perintah dibawah
```
1. cd ~
2. curl -sS https://getcomposer.org/installer -o /tmp/composer-setup.php
3. php -r "if (hash_file('SHA384', '/tmp/composer-setup.php') === '$HASH') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
4. sudo php /tmp/composer-setup.php --install-dir=/usr/local/bin --filename=composer
```
4. Apabila instalasi tersebut selesai bisa di cek versi composer tersebut dengan perintah `composer`
5. Kemudian masuk kedalam direktori /var/www/html/bca_syariah_docs/backend/ dengan mengikuti perintah `cd /var/www/html/bca_syariah_docs/backend/`
6. Jalankan perintah `composer update` untuk melakukan update dependency
7. Setelah itu ubah permission pada direktori storage menjadi ***all permission*** dengan perintah `sudo chmod 777 -R storage/`
8. Kemudian jalankan `php artisan key:generate` untuk membuat kunci security token pada aplikasi
9. Ubah konfigurasi database dan lainnya pada **.env**, apabila .env belum ada bisa laukan copy dengan perintah seperti berikut `cp .env.example .env`
10. Setelah konfigurasi, kita kembali ke direktori /etc/nginx/sites-available/ dengan perintah `cd /etc/nginx/sites-available/`
11. Copy file ***default*** dan paste menjadi ***default.backend*** pada perintah `cp default default.backend`
12. Ubah beberapa konfigurasi pada default.backend seperti **listen**, **root**, **index** dan **location** pada block code server seperti contoh dibawah:
```nginx
listen 8001 default_server;
listen [::]:8001 delfault_server;

# komen listen 443 karena menggunakan custom TCP port
# listen 443 ssl default_server;
# listen [::]:443 ssl delfault_server;

root /var/www/html/bca_syariah_docs/backend/public;
index index.html index.php;

location / {
    # ubah /=400 menjadi /index.php$is_args$args;
    try_files $uri $uri/ /index.php$is_args$args;
}

# tambahkan blok kode dibawah ini
location ~ \.php$ {
    fastcgi_split_path_info ^(.+\.php)(/.+)$;
    fastcgi_pass 127.0.0.1:9001;
    fastcgi_index index.php;
    include fastcgi.conf;
}
```
13. Kemudian masuk ke dalam direktori /etc/php/8.x/fpm/pool.d/ dengan perintah `cd /etc/php/<versi php kalian>/fpm/pool.d/`
14. Ubah 1 baris konfigurasi pada www.conf dengan perintah `sudo nano www.conf`, dan ubah baris **listen** seperti diabawah
```
listen=127.0.0.1:9001
```
15. Simpan dan restart service php-fpm `sudo systemctl restart php-fpm.service` atau `sudo service php-fpm restart`
16. Buat symbolic-link pada **/etc/nginx/sites-enabled/** yang menuju pada file **/etc/nginx/sites-available/default.backend/** dengan menggunakan perintah `sudo ln -s /etc/nginx/sites-available/default.backend /etc/nginx/sites-enabled/default.backend`
17. Lakukan restart dan reload nginx pada system `sudo systemctl restart nginx.service` dan `sudo systemctl reload nginx.service`
18. Untuk melakukan testing bisa gunakan command `curl http://localhost:8001`
19. Lakukan perubahan security-group pada instance AWS dan tambahkan 1 **custom TCP 8001**, simpan dan buka browser dengan alamat http://<public_dns_ipv4>:8001/
20. Selamat konfigurasi sudah selesai pada frontend dan backend
