<h2 align="center">Ago</h2>

<p align="center">
    <a href="https://travis-ci.org/serhii/ago"><img src="https://travis-ci.org/SerhiiCho/ago.svg?branch=master"></a>
    <a href="https://packagist.org/packages/serhii/ago"><img src="https://poser.pugx.org/serhii/ago/d/total.svg" alt="Total Downloads"></a>
    <a href="https://packagist.org/packages/serhii/ago"><img src="https://poser.pugx.org/serhii/ago/v/stable.svg" alt="Latest Stable Version"></a>
</p>

Date/time converter into "n time ago" format. Supports Russian and English languages.

## Example

Default language is English. Optionally you can set the language in your application by calling lang method and passing flag 'ru' or 'en';

```php
Serhii\Ago::lang('ru');
```

## Usage

For outputting post publishing date or something else you can just pass the date to method ```take()```. It will count the interval between now and given date and returns needed format.

```php
Serhii\Ago::take('2019-10-23 10:46:00'); // after 10 seconds outputs: 10 seconds ago
```

If you want to show last user login like if user is online or not, you can pass `Ago::ONLINE` constant as the seconds argument. All it does is just displaying **Online** if date interval withing 60 seconds.

```php
Serhii\Ago::take('2019-10-23 10:46:00', Serhii\Ago::ONLINE);
```

## Quick Start

```bash
composer require serhii/ago
```