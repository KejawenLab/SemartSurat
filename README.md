# Semart Surat

[![Build Status](https://travis-ci.org/KejawenLab/SemartSurat.svg?branch=master)](https://travis-ci.org/KejawenLab/SemartSurat)
[![Coverage Status](https://coveralls.io/repos/github/KejawenLab/SemartSurat/badge.svg?branch=master)](https://coveralls.io/github/KejawenLab/SemartSurat?branch=master)
[![PHPStan](https://img.shields.io/badge/style-level%20max-brightgreen.svg?style=flat-square&label=phpstan)](https://github.com/phpstan/phpstan)

## Tentang

**Semart Surat** adalah sebuah skeleton atau boilerplate atau kerangka awal untuk memulai sebuah proyek. Dibangun dengan menggunakan framework [Symfony](https://symfony.com) dan berbagai bundle serta diramu oleh Developer yang telah berpengalaman lebih dari **7 tahun** menggunakan Symfony.


Ditujukan untuk memudahkan Developer dalam mengerjakan proyek tanpa perlu dipusingkan dengan berbagai pengaturan-pengaturan yang bersifat rutinitas dan berulang.
Memiliki beberapa fitur dasar seperti pengaturan user, group, menu dan hak akses yang dapat diatur dengan mudah melalui menu yang telah kami siapkan.

## Fitur Semart Surat

- Pengaturan User

- Pengaturan Group

- Pengaturan Menu

- Pengaturan Hak Akses

- Pengaturan Aplikasi

- SQL Editor

- CRUD Generator

- Pengurutan

- Pencarian

- Multiple File Upload

- User Context Filter


## Kebutuhan Sistem

- PHP 7.2 atau lebih baru

- MySQL/MariaDB/PostgreSQL sebagai RDBMS

- Redis Server sebagai Session Storage

- Composer sebagai Dependencies Management


## Cara Instalasi (Menggunakan Composer)

- Clone repositori dengan `git clone` command:

```
git clone https://github.com/KejawenLab/SemartSurat.git Semart
```

atau dengan `composer create-project` command:

```
composer create-project -sdev kejawenlab/semart-skeleton Semart
```

- Masuk ke direktori `Semart` dengan perintah `cd Semart`

- Ubah konfigurasi database

```bash
# database driver (for this case you must set as pdo_mysql)
DATABASE_DRIVER=pdo_mysql
# database version
DATABASE_SERVER_VERSION=5.7
# charset
DATABASE_CHARSET=utf8mb4

# specify db url with format
# DATABASE_URL=mysql://{user}:{password}@{host}:{port}/{db}
# IF your database doesn't use password, you can use format:
# DATABASE_URL=mysql://{user}@{host}:{port}/{db}, eg:
#
#    DATABASE_URL=mysql://root@127.0.0.1:3306/semart
#
DATABASE_URL=mysql://root:aden@localhost:3306/semart

```

- Jalankan perintah `composer update --prefer-dist -vvv`

- Jalankan perintah `php bin/console semart:install`

- Jalankan perintah `php bin/console server:run` untuk menjalankan web server

- Buka browser pada alamat `http://localhost:8000` atau sesuai port yang tampil ketika menjalankan perintah diatas

- Gunakan username `admin` dan password `semartadmin` untuk masuk ke aplikasi

## Cara Instalasi (Menggunakan Docker)

- Clone repositori dengan `git clone` command:

```
git clone https://github.com/KejawenLab/SemartSurat.git Semart
```

atau dengan `composer create-project` command:

```
composer create-project -sdev kejawenlab/semart-skeleton Semart
```

- Masuk ke direktori `Semart` dengan perintah `cd Semart`

- Ubah konfigurasi pada file `docker-compose.yml`

```yaml
services:
    app:
        build: .
        environment:
            NGINX_WEBROOT: /semart/public
            APP_ENV: dev
            APP_SECRET: 2a46d7812648fc10df43fa9431d5f75d
            DATABASE_DRIVER: pdo_mysql
            DATABASE_SERVER_VERSION: 5.7
            DATABASE_CHARSET: utf8mb4
            DATABASE_URL: mysql://root:aden@localhost:3306/semart
            REDIS_URL: redis://session
```

- Jalankan perintah `docker-compose up -d`

- Masuk ke container `app` dengan perintah `docker-compose exec app bash`

- Jalankan perintah `php bin/console semart:install` dari dalam container `app`

- Buka browser pada alamat `http://localhost:8080`

- Gunakan username `admin` dan password `semartadmin` untuk masuk ke aplikasi

## Dokumentasi Lengkap

- [Penggunaan Dasar](doc/usage.md)

- [Pengaturan Hak Akses](doc/permission.md)

- [Konfigurasi Menu](doc/menu.md)

- [Pencarian dan Sorting](doc/search_sort.md)

- [Event System](doc/event.md)

- [User Context](doc/user_context.md)

## Unit Testing

```bash
php vendor/bin/phpunit
```

## Preview

* Login

![Login](doc/imgs/login.png "Login")

* Menu List

![Menu List](doc/imgs/menu_list.png "Menu List")

* Roles

![Roles](doc/imgs/roles.png "Roles")

* Setting List

![Setting List](doc/imgs/setting_list.png "Setting List")

* User Form

![User Form](doc/imgs/user_form.png "User Form")

* User List

![User List](doc/imgs/user_list.png "User List")

* Query Runner

![Query Runner](doc/imgs/query_runner.png "Query Runner")

## Kontributor

Terima kasih kepada semua [kontributor](https://github.com/KejawenLab/SemartSurat/graphs/contributors)
