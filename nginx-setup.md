
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
