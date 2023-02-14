# Guide Manual Instalasi Tomcat pada Ubuntu BSIT2023
## Instalasi Tomcat

1. Lakukan update pada system dengan perintah `sudo apt update`
2. Instal versi Java yang dibutuhkan, untuk kasus ini kita akan memakai java versi 17 karena Tomcat hanya dapat berjalan dengan java versi diatas 10
```sh
1. cd ~
2. sudo apt install -y libc6-x32 libc6-i386
3. wget https://download.oracle.com/java/17/latest/jdk-17_linux-x64_bin.deb
4. sudo dpkg -i jdk-17_linux-x64_bin.deb
5. sudo update-alternatives --install /usr/bin/java java /usr/lib/jvm/jdk-17/bin/java 1
6. sudo update-alternatives --install /usr/bin/javac javac /usr/lib/jvm/jdk-17/bin/javac 1
```
3. Kemudian cek java dan javac version dengan perintah `java -v` dan `javac -v`
4. Buat 1 user untuk tomcat `sudo useradd -m -U -d /opt/tomcat -s /bin/false tomcat`
5. Ikuti perintah dibawah untuk melakukan instalasi tomcat pada versi tertentu seperti 10.1.4
```sh
1. VERSION=10.1.4
2. wget https://www-eu.apache.org/dist/tomcat/tomcat-10/v${VERSION}/bin/apache-tomcat-${VERSION}.tar.gz -P /tmp
3. sudo tar -xf /tmp/apache-tomcat-${VERSION}.tar.gz -C /opt/tomcat/
4. sudo chown -R tomcat: /opt/tomcat
5. sudo sh -c 'chmod +x /opt/tomcat/apache-tomcat-10.1.4/bin/*.sh'
```
6. Buat service unit file untuk tomcat dengan command `sudo touch /etc/systemd/system/tomcat.service`
7. Ubah file yang baru saja dibuat dengan command `sudo nano /etc/systemd/system/tomcat.service`
8. Lalu copy dan paste kode dibawah pada editor nano
```
[Unit]
Description=Tomcat 10 servlet container
After=network.target

[Service]
Type=forking

User=tomcat
Group=tomcat

Environment="JAVA_HOME=/usr/lib/jvm/java-17_jdk-linux-x64"
Environment="JAVA_OPTS=-Djava.security.egd=file:///dev/urandom -Djava.awt.headless=true"

Environment="CATALINA_BASE=/opt/tomcat/apache-tomcat-10.1.4"
Environment="CATALINA_HOME=/opt/tomcat/apache-tomcat-10.1.4"
Environment="CATALINA_PID=/opt/tomcat/apache-tomcat-10.1.4/temp/tomcat.pid"
Environment="CATALINA_OPTS=-Xms512M -Xmx1024M -server -XX:+UseParallelGC"

ExecStart=/opt/tomcat/apache-tomcat-10.1.4/bin/startup.sh
ExecStop=/opt/tomcat/apache-tomcat-10.1.4/bin/shutdown.sh

[Install]
WantedBy=multi-user.target

```
9. Simpan, lalu masuk kedalam direktori project java dan ubah beberapa dependency pada **pom.xml** (Maven)
10. Masukan dependency yang diperlukan oleh tomcat.
11. Lakukan perintah `mvn clean install package` untuk melakukan instalasi dependency dan compile project menjadi package untuk didistribusikan.
12. Copy dan paste file **.jar** yang ada didalam direktori ***target*** ke dalam ***/opt/tomcat/apache-tomcat/webapps/*** dengan beberapa perintah berikut
```sh
sudo -su tomcat
cp target/<nama file package>.jar /opt/tomcat/apache-tomcat-10.1.4/webapps/
```
13. Jalankan service tomcat yang sudah dibuat dengan command `sudo systemctl start tomcat.service`
14. Kita dapat langsung melakukan test dengan `curl http://localhost:8080`
15. Apabila sudah muncul tampilan website spring boot kita dengan bentuk source code HTML tag, maka setup telah selesai