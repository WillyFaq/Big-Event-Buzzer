# Big Event Buzzer 

## Getting Started
Aplikasi untuk menampilkan waktu perseta. Serta otomatis menyalakan buzzer(sound) jika waktu habis. dan audio visualizer dari microphone.

## features : 
- Tambah band
- Menampilkan waktu (Countdown)
- Buzzer otomatis ketika waktu habis.
- audio visualizer

## Requirement (before install)
* [Node.js (v8.11.2 Recomended)](https://nodejs.org/download/release/v8.11.2/) - untuk socket communication
* [php webserver (Ex: Xampp)](https://www.apachefriends.org/download.html) - atau php webserver lainnya

## Installation
- clone/download repository
- taruh di htdocs (jika memakai xampp)

## Cara Penggunaan : 
- buka <project_dir>/assets/js/config.js
- sesuiakan server + port : 3800 dan lama waktu (dalam detik), contoh : 
'''
var _server = 'http://127.0.0.1:3800';
var tot_time = 900;// 15 menit
'''
- hidupkan node server, double click start_server.bat
- Buka browser, ketikkan <ip php webserver>/<project_dir>, contoh :
'''
http://127.0.0.1/buzzer
'''
- Untuk menabahkan band, ketikan <ip php webserver>/<project_dir>/band.php, contoh :
'''
http://127.0.0.1/buzzer/band.php
'''

## Powered By :
- [preziotte - party-mode](http://github.com/preziotte/party-mode)

