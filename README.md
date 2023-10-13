<br>
<p align="center">
 <a href="https://www.youtube.com/watch?v=t9VWICGOD90&ab_channel=HITSRecords"><img src="https://github.com/haqiachd/ArenaFinder-Mobile/blob/main/images/logo-c2.png" alt="Logo Kelompok C2" width="195" height="155"></a>
</p>

<h3 align="center">ArenaFinder Mobile ~ Rest-API</h3>
<p align = "center">:computer: Merupakan Rest-API dari aplikasi mobile ArenaFinder :wink:</p>

<!-- Project Shields -->
<span align="center">

  [![Forks][forks-shield]][forks-url]
  [![Repo Size][repo-shield]][repo-url]
  [![Contributors][contributors-shield]][contributors-url]
  [![Last Commit][commit-shield]][commit-url]
  <!-- [![Stargazers][stars-shield]][stars-url] -->
  <!-- [![Issues][issues-shield]][issues-url] -->

  [repo-shield]: https://img.shields.io/github/repo-size/haqiachd/ArenaFinder-Mobile-RestApi.svg?style=for-the-badge
  [repo-url]: https://img.shields.io/github/repo-size/haqiachd/ArenaFinder-Mobile-RestApi.svg
  [contributors-shield]: https://img.shields.io/github/contributors/haqiachd/ArenaFinder-Mobile-RestApi.svg?style=for-the-badge
  [contributors-url]: https://github.com/haqiachd/ArenaFinder-Mobile-RestApi/graphs/contributors
  [forks-shield]: https://img.shields.io/github/forks/haqiachd/ArenaFinder-Mobile-RestApi.svg?style=for-the-badge
  [forks-url]: https://github.com/haqiachd/ArenaFinder-Mobile/network/members
  [stars-shield]: https://img.shields.io/github/stars/haqiachd/ArenaFinder-Mobile-RestApi.svg?style=for-the-badge
  [stars-url]: https://github.com/haqiachd/ArenaFinder-Mobile-RestApi/stargazers
  [commit-shield]: https://img.shields.io/github/last-commit/haqiachd/ArenaFinder-Mobile-RestApi.svg?style=for-the-badge
  [commit-url]: https://github.com/haqiachd/ArenaFinder-Mobile-RestApi/commits
  [issues-shield]: https://img.shields.io/github/issues/haqiachd/ArenaFinder-Mobile-RestApi.svg?style=for-the-badge
  [issues-url]: https://github.com/haqiachd/ArenaFinder-Mobile-RestApi/issues

</span>

<p align="center">
<a href="https://drive.google.com/drive/folders/1c9xHuEOusnqJxNEYW4B3H-rG1FlXcvvt?usp=sharing" target="_blank" style="font-weight: bold;">MySQL Database</a>
&nbsp;&nbsp;
<a href="https://github.com/haqiachd/ArenaFinder-Mobile" target="_blank" style="font-weight: bold;">Mobile Repository</a>
&nbsp;&nbsp;
<a href="https://github.com/mahen-alim/ArenaFinder-Web" target="_blank" style="font-weight: bold;">Website Repository</a>
&nbsp;&nbsp;
<a href="https://github.com/haqiachd/ArenaFinder-Mobile/blob/main/GUIDE.md" target="_blank" style="font-weight: bold;">Cara Instalasi ArenaFinder</a>
</p>

---

### Import MySQL Database di phpMyAdmin <a name = "satu"></a>
Download database [ArenaFinder](https://drive.google.com/drive/folders/1c9xHuEOusnqJxNEYW4B3H-rG1FlXcvvt?usp=sharing) lalu aktifkan Apache dan MySQL pada ```XAMPP``` kemudian buka [phpMyAdmin](http://localhost/phpmyadmin/index.php) di browser, buat database baru dengan nama ```arenafinder``` dan  import file database _arenafinder.sql_ yang telah didownload, dan akhiri dengan menekan tombol ```Import```.

### Clone Rest-API Mobile ArenaFinder <a name = "dua"></a>
 - Buka directory ```htdocs``` pada XAMPP.
 - Buka Git Bash Anda.
 - Ketik perintah berikut untuk meng-clone repositori dari GitHub.
   <br>
   ``` sh
   git clone https://github.com/haqiachd/ArenaFinder-Mobile-RestApi.git
   ```
 - Ketikan kode dibawah ini untuk menginstall packages yang diperlukan.
   ``` sh
   composer install
   ```
 - Ubah nama folder hasil clone github menjadi ```arenafinder```.
 - Selesai.
