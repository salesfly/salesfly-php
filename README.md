# salesfly-php

[![Build Status](https://travis-ci.org/salesfly/salesfly-php.svg?branch=master)](https://travis-ci.org/salesfly/salesfly-php)

<!--[![codecov](https://codecov.io/gh/salesfly/salesfly-php/branch/master/graph/badge.svg)](https://codecov.io/gh/salesfly/salesfly-php)-->

PHP client for [Salesfly API](https://salesfly.com)&reg;

## Documentation

See the [PHP API docs](https://docs.salesfly.com/php/).

## Installation

You don't need this source code unless you want to modify the package. If you just
want to use the package, just run:

```bash
composer require salesfly/client
```

### Requirements

- PHP 7.2+

## Usage

The library needs to be configured with your account's API key. Get your own API key by signing up for a free [Salesfly account](https://salesfly.com).

```php
<?php
require __DIR__ . "/vendor/autoload.php";
use Salesfly\Client;

$apiKey = $_ENV["SALESFLY_APIKEY"]

$client = new Client($apiKey);
$location = $client->geoip->get("8.8.8.8");

echo "Country code: " . $location["country_code"];
```

## License and Trademarks

Copyright (c) 2018-20 UAB Salesfly.

Licensed under the [MIT license](https://en.wikipedia.org/wiki/MIT_License).

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.

Salesfly is a registered trademark of [UAB Salesfly](https://www.salesfly.com).
