# Contributing another language

If you want to contribute support for a language that is not currently supported, all you need to do is to copy/paste 3 files and change them to match the language that you want to add. Then add 1 line to README.md file. Here is my [commit](https://github.com/SerhiiCho/ago/commit/aa622a33dcd4a348b5a0cbf3807395bc62e413ba) for supporting Ukrainian language that shows changes that I did.

##### Files in lang directory

description

##### Files in rules directory

Here is the example of the rule file for Russian language.

```php
return function (int $number, int $last_digit): array {
    return [
        'single' => $last_digit === 1,
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
- `special` form for special cases, for example in Russian, and Ukrainian we have special forms for words: **недель**, **месяцев**, etc. They are different from single and plural form. So we need to have separate rules for them.

Each form has a boolean rule or array of boolean rules. In Russian example we say that we want to use `single` form when last digit of the number is equal to 1. Now when we see date `1 day ago` in Russian the output will be `1 день назад`, which is the correct translation that we got from `resources/lang/ru.php` file where we have line `'day' => 'день'`. We can give either boolean to each rule or array of booleans when we have many cases for the form. In our example we have 3 cases for `special` form. If one of them will be true, special form will be applied.


