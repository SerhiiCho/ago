<h2 align="center">Ago</h2>

[![Build Status](https://img.shields.io/endpoint.svg?url=https%3A%2F%2Factions-badge.atrox.dev%2FSerhiiCho%2Fago%2Fbadge&style=flat)](https://actions-badge.atrox.dev/SerhiiCho/ago/goto)
[![Build Status](https://travis-ci.com/SerhiiCho/ago.svg?branch=master)](https://travis-ci.com/SerhiiCho/ago)
[![Latest Stable Version](https://poser.pugx.org/serhii/ago/v/stable)](https://packagist.org/packages/serhii/ago)
[![Total Downloads](https://poser.pugx.org/serhii/ago/downloads)](https://packagist.org/packages/serhii/ago)
[![License](https://poser.pugx.org/serhii/ago/license)](https://packagist.org/packages/serhii/ago)
<a href="https://php.net/" rel="nofollow"><img src="https://camo.githubusercontent.com/2b1ed18c21257b0a1e6b8568010e6e8f3636e6d5/68747470733a2f2f696d672e736869656c64732e696f2f62616467652f7068702d253345253344253230372e312d3838393242462e7376673f7374796c653d666c61742d737175617265" alt="Minimum PHP Version" data-canonical-src="https://img.shields.io/badge/php-%3E%3D%207.1-8892BF.svg" style="max-width:100%;"></a>

Date/time converter into "n time ago" format that supports multiple languages. You can easily contribute any language that you wish.

## Example

Default language is English. Optionally you can set the language in your application by calling `set()` method and passing a flag `ru` for Russian or `en` for English language. You can see supported languages in the next section.

```php
Serhii\Ago\Lang::set('ru');
```

## Supported languages

| Language      |  Short representation |
| :------------ |:----------------------|
| English       | en                    |
| Russian       | ru                    |

## Usage

[Example usage on repl.it](https://repl.it/@SerhiiCho/Usage-of-ago-package)

For outputting post publishing date or something else you can just pass the date to method `ago()`. It will count the interval between now and given date and returns needed format. Internally given date will be parsed by `strtotime()` PHP's function.

```php
Serhii\Ago\TimeAgo::trans('now - 10 seconds'); // output: 10 seconds ago
```

## Options

As the seconds argument `ago` method excepts array of options. Here is an example of passed options.

```php
Serhii\Ago\TimeAgo::trans('yesterday', ['no-suffix']); // output: 1 day
```

## Available options

| Option        |  Description              |
| :------------ |:--------------------------|
| online        | Display "Online" if date interval within 60 seconds. After 60 seconds output will be the same as usually "x time ago" format. |
| no-suffix     | Remove suffix from date and have "5 minutes" instead of "5 minutes ago". |
| upcoming      | Without this option passed time will be subtracted from current time, but with this option it will take given time and subtract current time. It is useful if you need to display a counter for some date in future. Suffix will be also removed.|

## Contributing

For any contribution information you can read [CONTRIBUTE.md](https://github.com/SerhiiCho/ago/blob/master/CONTRIBUTE.md)

## Quick Start

```bash
composer require serhii/ago
```
