[![Build Status](https://img.shields.io/endpoint.svg?url=https%3A%2F%2Factions-badge.atrox.dev%2FSerhiiCho%2Fago%2Fbadge&style=flat)](https://actions-badge.atrox.dev/SerhiiCho/ago/goto)
[![Latest Stable Version](https://poser.pugx.org/serhii/ago/v/stable)](https://packagist.org/packages/serhii/ago)
[![Total Downloads](https://poser.pugx.org/serhii/ago/downloads)](https://packagist.org/packages/serhii/ago)
[![License](https://poser.pugx.org/serhii/ago/license)](https://packagist.org/packages/serhii/ago)
<a href="https://php.net/" rel="nofollow"><img src="https://camo.githubusercontent.com/2b1ed18c21257b0a1e6b8568010e6e8f3636e6d5/68747470733a2f2f696d672e736869656c64732e696f2f62616467652f7068702d253345253344253230372e312d3838393242462e7376673f7374796c653d666c61742d737175617265" alt="Minimum PHP Version" data-canonical-src="https://img.shields.io/badge/php-%3E%3D%207.1-8892BF.svg" style="max-width:100%;"></a>

Date/time converter into "n time ago" format that supports multiple languages. You can easily contribute any language that you wish.

[Contributing a language](https://github.com/SerhiiCho/ago/blob/master/CONTRIBUTE.md)

## Languages

Default language is English. Optionally you can set the language in your application by calling `set()` method and passing a flag `ru` for Russian or `en` for English language. You can see supported languages in the next section.

```php
Serhii\Ago\Lang::set('ru');
```

#### Supported languages

<table>
  <thead>
    <tr>
      <th>Language</th>
      <th>Short representation</th>
    </tr>
  </thead>
  <tbody>
     <tr>
      <td>English</td>
      <td>en</td>
    </tr>
    <tr>
      <td>Russian</td>
      <td>ru</td>
    </tr>
    <tr>
      <td>Ukrainian</td>
      <td>uk</td>
    </tr>
  </tbody>
</table>

## Usage

For outputting post publishing date or something else you can just pass the date to method `trans()`. It will count the interval between now and given date and returns needed format. Internally given date will be parsed by `strtotime()` PHP's internal function.

```php
use Serhii\Ago\TimeAgo;

TimeAgo::trans('now - 10 seconds'); // output: 10 seconds ago
```

## Options

As the seconds argument `trans` method excepts array of options or single option. Here is an example of passed options.

```php
use Serhii\Ago\Option;
use Serhii\Ago\TimeAgo;

TimeAgo::trans('yesterday'); // output: 1 day ago
TimeAgo::trans('yesterday', Option::NO_SUFFIX); // output: 1 day
TimeAgo::trans('now', Option::ONLINE); // output: online
TimeAgo::trans('now', [Option::ONLINE, Option::UPPER]); // output: ONLINE
```

#### Available options

All options are available in `Serhii\Ago\Option::class` as constants.

<table>
  <thead>
    <tr>
      <th>Option</th>
      <th>Description</th>
    </tr>
  </thead>
  <tbody>
     <tr>
      <td>Option::ONLINE</td>
      <td>Display "Online" if date interval within 60 seconds. After 60 seconds output will be the same as usually "x time ago" format.</td>
    </tr>
    <tr>
      <td>Option::NO_SUFFIX</td>
      <td>Remove suffix from date and have "5 minutes" instead of "5 minutes ago".</td>
    </tr>
    <tr>
      <td>Option::UPCOMING</td>
      <td>Without this option passed time will be subtracted from current time, but with this option it will take given time and subtract current time. It is useful if you need to display a counter for some date in future.</td>
    </tr>
    <tr>
      <td>Option::UPPER</td>
      <td>Set output to uppercase.</td>
    </tr>
  </tbody>
</table>

## Quick Start

```bash
composer require serhii/ago
```
