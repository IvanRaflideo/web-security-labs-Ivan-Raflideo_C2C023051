SQL Injection

Pada versi rentan, aplikasi menyusun perintah SQL langsung dari input pengguna tanpa proses validasi atau pemisahan antara data dan perintah. Hal ini memungkinkan penyerang memasukkan kode SQL tambahan seperti ' OR '1'='1 untuk memanipulasi hasil query dan mendapatkan akses tidak sah ke sistem.
Sebaliknya, versi aman menggunakan prepared statement yang memisahkan logika perintah dan data pengguna, sehingga input hanya dianggap sebagai nilai, bukan bagian dari perintah SQL. Dengan cara ini, serangan injeksi dapat dicegah karena query tidak bisa dimodifikasi oleh input pengguna.

2. Cross Site Scripting (XSS)

Versi rentan terjadi ketika aplikasi menampilkan input pengguna langsung ke halaman web tanpa melakukan penyaringan atau pengkodean khusus. Hal ini memungkinkan penyerang menanamkan skrip berbahaya seperti <script>alert('XSS')</script> yang kemudian dijalankan di browser korban.
Pada versi aman, setiap output yang berasal dari input pengguna harus melalui proses escaping atau encoding, misalnya dengan fungsi htmlspecialchars pada PHP, sehingga tag HTML tidak diinterpretasikan sebagai kode. Selain itu, penerapan Content Security Policy (CSP) dapat membantu membatasi eksekusi skrip dari sumber yang tidak terpercaya.

3. Kerentanan Upload File

Pada versi rentan, sistem mengizinkan pengguna mengunggah file tanpa memeriksa tipe atau ekstensi file. Kondisi ini memungkinkan penyerang mengunggah file berbahaya seperti skrip PHP yang dapat dijalankan di server dan memberikan akses penuh terhadap sistem.
Sementara pada versi aman, sistem menerapkan validasi ketat terhadap ekstensi dan tipe file yang diunggah, menyimpan file dengan nama acak atau UUID, serta menempatkannya di direktori yang tidak dapat diakses langsung dari web. Dengan demikian, file tidak dapat dieksekusi dan risiko serangan dapat diminimalkan.

4. Broken Access Control

Versi rentan dari masalah ini terjadi ketika sistem tidak memverifikasi apakah pengguna berhak mengakses data tertentu. Misalnya, pengguna dapat mengubah parameter id pada URL untuk melihat data pengguna lain tanpa otorisasi.
Pada versi aman, sistem memastikan setiap permintaan diverifikasi berdasarkan identitas dan hak akses pengguna yang sedang login. Data yang diambil harus sesuai dengan akun yang sedang aktif, dan kontrol akses berbasis peran (Role-Based Access Control) diterapkan untuk membatasi hak setiap pengguna sesuai fungsinya.
