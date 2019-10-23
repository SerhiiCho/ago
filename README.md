<h2 align="center">Ago</h2>
<p align="center">

<a href=""><img src="https://travis-ci.org/SerhiiCho/ago.svg?branch=master" alt=""></a>
[![Latest Stable Version](https://poser.pugx.org/serhii/ago/v/stable)](https://packagist.org/packages/serhii/ago)
[![Latest Stable Version](https://poser.pugx.org/serhii/ago/v/stable)](https://packagist.org/packages/serhii/ago)
[![Total Downloads](https://poser.pugx.org/serhii/ago/downloads)](https://packagist.org/packages/serhii/ago)
[![License](https://poser.pugx.org/serhii/ago/license)](https://packagist.org/packages/serhii/ago)
<a href="https://php.net/" rel="nofollow"><img src="https://camo.githubusercontent.com/2b1ed18c21257b0a1e6b8568010e6e8f3636e6d5/68747470733a2f2f696d672e736869656c64732e696f2f62616467652f7068702d253345253344253230372e312d3838393242462e7376673f7374796c653d666c61742d737175617265" alt="Minimum PHP Version" data-canonical-src="https://img.shields.io/badge/php-%3E%3D%207.1-8892BF.svg" style="max-width:100%;"></a>

</p>

Date/time converter into "n time ago" format. Supports Russian and English languages.

## Example

Default language is English. Optionally you can set the language in your application by calling `set()` method and passing flag 'ru' or 'en';

```php
Serhii\Lang::set('ru');
```

## Usage

For outputting post publishing date or something else you can just pass the date to method `take()`. It will count the interval between now and given date and returns needed format.

```php
use Serhii\Ago\Ago;

Ago::take('2019-10-23 10:46:00'); // after 10 seconds outputs: 10 seconds ago
```

If you want to show last user login like if user is online or not, you can pass `Ago::ONLINE` constant as the seconds argument. All it does is just displaying **Online** if date interval withing 60 seconds.

```php
use Serhii\Ago\Ago;

Ago::take('2019-10-23 10:46:00', Ago::ONLINE);
```

## Quick Start

```bash
composer require serhii/ago
```