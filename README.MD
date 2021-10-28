# Smeify Laravel Package

## Smeify is a Stable Automated Solution for Airtime and Data businesses in Nigeria, this package helps you integrate smeify easily into your laravel application.

## Installation

[PHP](https://php.net) 7.4.3+  and [Composer](https://getcomposer.org) are required.

To get the latest version of adewalecharles/smeify, simply require it

```bash
composer require adewalecharles/smeify
```

Or add the following line to the require block of your `composer.json` file.

```
"adewalecharles/smeify": "1.0.*"
```

You'll then need to run `composer install` or `composer update` to download it and have the autoloader updated.



Once adewalecharles/smeify is installed, you need to register the service provider. Open up `config/app.php` and add the following to the `providers` key.

```php
'providers' => [
    ...
    AdewaleCharles\Smeify\SmeifyServiceProvider::class,
    ...
]

```

## Configuration

You can publish the configuration file using this command:

```bash
php artisan vendor:publish --provider="AdewaleCharles\Smeify\SmeifyServiceProvider"
```

A configuration-file named `smeify.php` with some sensible defaults will be placed in your `config` directory:

```php
<?php
/*
 * This file is part of the adewalecharles/smeify package.
 *
 * (c) Adewale Ogundiran Charles <shyprince1@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
return [

    /*
    |--------------------------------------------------------------------------
    | Authentication Defaults
    |--------------------------------------------------------------------------
    |
    | This is the authentication credentials you will need to use this package
    |
    */

    'identity' => env('SMEIFY_IDENTITY', null),

    'password' => env('SMEIFY_PASSWORD', null),

];

```

# Usage
Open your .env file and add your smeify login credentials like so:

```php
SMEIFY_IDENTITY = *your smeify username or email*
SMEIFY_PASSWORD = xxxxxxxx
```
*If you are using a hosting service like heroku, ensure to add the above details to your configuration variables.*

## General Usage

To get your list of data plans from smeify all you need to do is call Smeify helper method like so

```php
<?php

namespace App\Http\Controllers;

use AdewaleCharles\Smeify\Http\Smeify;
use Illuminate\Http\Request;

class TestController extends Controller
{

     public function index()
    {

        return Smeify::getDataPlans();
    }

}

```

To get all your list of transactions from smeify all you need to do is call Smeify helper method like so

```php
public function index()
    {

        return Smeify::getTransactions();
    }
```
