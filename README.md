<h2 align="center">Ago</h2>

[![Build Status](https://travis-ci.com/SerhiiCho/ago.svg?branch=master)](https://travis-ci.com/SerhiiCho/ago)
[![Latest Stable Version](https://poser.pugx.org/serhii/ago/v/stable)](https://packagist.org/packages/serhii/ago)
[![Total Downloads](https://poser.pugx.org/serhii/ago/downloads)](https://packagist.org/packages/serhii/ago)
[![License](https://poser.pugx.org/serhii/ago/license)](https://packagist.org/packages/serhii/ago)
<a href="https://php.net/" rel="nofollow"><img src="https://camo.githubusercontent.com/2b1ed18c21257b0a1e6b8568010e6e8f3636e6d5/68747470733a2f2f696d672e736869656c64732e696f2f62616467652f7068702d253345253344253230372e312d3838393242462e7376673f7374796c653d666c61742d737175617265" alt="Minimum PHP Version" data-canonical-src="https://img.shields.io/badge/php-%3E%3D%207.1-8892BF.svg" style="max-width:100%;"></a>

Date/time converter into "n time ago" format. Supports Russian and English languages.

## Example

Default language is English. Optionally you can set the language in your application by calling `set()` method and passing flag 'ru' or 'en';

```php
Serhii\Ago\Lang::set('ru');
```

## Usage

For outputting post publishing date or something else you can just pass the date to method `ago()`. It will count the interval between now and given date and returns needed format.

```php
$now = date('Y-m-d H:i:s');
Serhii\Ago\Time::ago($now); // after 10 seconds outputs: 10 seconds ago
```

If you want to show last user login like if user is online or not, you can pass `Ago::ONLINE` constant as the seconds argument. All it does is just displaying **Online** if date interval within 60 seconds. After 60 seconds output will be the same as usually "x time ago" format.

```php
$now = date('Y-m-d H:i:s');
Time::ago($now, Time::ONLINE); // within 60 seconds output is: Online
```

If you want to remove suffix from date and have "5 minutes" instead of "5 minutes ago" there is a flag `Time::NO_SUFFIX` available for this operation.

```php
$now = date('Y-m-d H:i:s');
Time::ago($now, Time::NO_SUFFIX); // after 5 seconds output is: 5 seconds
```

## Quick Start

```bash
composer require serhii/ago
```
