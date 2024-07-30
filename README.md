## Technical Test Fullstack Developer

### Ahmad Gozali

- Laravel
- Inertia JS
- VUE JS

## ERD
![image](https://github.com/user-attachments/assets/3c264311-e436-4d48-bcfc-e8f8ef6ffc5f)

## Instalasi

Berikut adalah langkah-langkah untuk menginstal dan menjalankan proyek ini di mesin lokal Anda.

Pastikan Anda telah menginstal PHP V8.2, Composer, dan Node.js di mesin Anda sebelum melanjutkan.

### Langkah-langkah Instalasi

1. Pastikan anda sudah extract proyek karyawan-app.zip:

2. Pindah ke direktori proyek:

`cd karyawan-app`

3. Copy .env.example rename menjadi .env kemudian atur database di .env

4. Instal dependensi PHP dengan Composer:

`composer install`

5. Install dependensi JavaScript dengan Node.js:

`npm install`
`php artisan migrate:fresh --seed`

6. Generate key aplikasi:

`php artisan key:generate`

7. Jalankan migrasi untuk membuat tabel database:

`php artisan migrate`

8. Jalankan server pengembangan lokal:

`php artisan serve`

dan

`npm run dev`

Akun login:

email : admin@dev.com
pass : password

## Thank You
