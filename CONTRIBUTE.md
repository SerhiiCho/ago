# Contribute another language

If you want to contribute support for a language that is not currently supported, all you need to do is to copy/paste 3 files and change them to match the language that you want to add. Then add 1 line to README.md file. Here is my [commit](https://github.com/SerhiiCho/ago/commit/cdd2ad09dacbb57e0c76b1aae39824d76ec1b928) for supporting Ukrainian language that shows changes that I did. You need to add 3 files for supporting another language. Here are 4 steps that you need to follow.

### 1 Step. Adding translation

Translation files live in `resources/trans` directory. Here is the example of the language file for Russian language.

```php
return [
    'ago' => 'назад',
    'online' => 'В сети',
    // Seconds
    'second' => 'секунда',
    'seconds' => 'секунды',
    'seconds-special' => 'секунд',
    // Minutes
    'minute' => 'минута',
    'minutes' => 'минуты',
    'minutes-special' => 'минут',
    // ... etc ...
];
```

Every translation file return array of translations. Note that `'second-special'` key is optional and can be used for languages that have not only singular and plural form for words like **day**, **minute**, etc... but more.

### 2 Step. Adding rules

Rules live in `resources/rules` directory. Here is the example of the rule file for Russian language.

```php
return function (int $number, int $last_digit): array {
    return [
        'single' => $last_digit === 1 || $number === 0,
        'plural' => $last_digit >= 2 && $last_digit < 5,
        'special' => [
            $number >= 5 && $number <= 20,
            $last_digit === 0,
            $last_digit >= 5 && $last_digit <= 9,
        ],
    ];
};
```

Every rule file should return a callback function with 2 parameters. The callback returns array of associative array. The array contains rules for 3 forms.

- `signle` form for words in a single form, like minute, day, year, etc.
- `plural` form for words in a plural form, like minutes, days, years, etc.
- `special` *(optional)* form for special cases, for example in Russian, and Ukrainian we have special forms for words: **недель**, **месяцев**, etc. They are different from single and plural form. So we need to have separate rules for them.

Each form has a boolean rule or array of boolean rules. In Russian example we say that we want to use `single` form when last digit of the number is equal to 1 or number is 0. Now when we see date `1 day ago` in Russian the output will be `1 день назад`, which is the correct translation that we got from `resources/lang/ru.php` file where we have line `'day' => 'день'`. We can give either boolean to each rule or array of booleans when we have many cases for the form. In our example we have 3 cases for `special` form. If one of them will be true, special form will be applied.

### 3 Step. Adding tests

Tests for all translations are live in `tests/Translations` directory. Just copy one of the existing tests and change it whatever you want to match your language. Just make sure you have enough cases to cover specifics of your language. If you don't know about [PHPUnit Data Providers](https://phpunit.de/manual/3.7/en/writing-tests-for-phpunit.html) you might want to read about it.

### 4 Step. Add 1 line to README.md file

After all tests are passing, you need to do last step and add language support to README.md file to **Supported languages** section.
