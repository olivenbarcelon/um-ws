[![GuardRails badge](https://api.guardrails.io/v2/badges/206057?token=fae57e14f5515599caf899247d1b28bda1ce9b7e9614274c55344c38ed066a7f)](https://dashboard.guardrails.io/gh/olivenbarcelon/repos/206057)
[![codecov](https://codecov.io/gh/olivenbarcelon/um-ws/branch/master/graph/badge.svg?token=V6A57RJLG9)](https://codecov.io/gh/olivenbarcelon/um-ws)
# um-ws
User Management System

**Setup Project**
<!-- * composer create-project --prefer-dist laravel/laravel:^5.8.* project -->
* git clone https://github.com/olivenbarcelon/um-ws.git 
* composer install

**Run Project**
* php artisan serve

**Run Test**
* vendor/bin/phpunit

**Developers**
* **Dependencies**
    * composer require tymon/jwt-auth:^1.0
        * php artisan vendor:publish --provider="Tymon\JWTAuth\Providers\LaravelServiceProvider"
        * php artisan jwt:secret
* **Artisan Command**
    * To make the changed in .env work
        * php artisan config:cache
    * For Queue
        * php artisan make:job UserCsvProcess
        * php artisan queue:table
        * php artisan queue:work
