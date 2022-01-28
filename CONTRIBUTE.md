[<< Go back to home](https://github.com/SerhiiCho/ago/blob/master/README.md)

# Contribute another language

- [How to make a PR](#how-to-make-a-pr)
- [1 Step. Adding translation](#1-step-adding-translation)
- [2 Step. Adding rules](#2-step-adding-rules)
- [3 Step. Adding tests](#3-step-adding-tests)
- [4 Step. Add 1 line to README.md file](#4-step-add-1-line-to-readmemd-file)

If you want to contribute support for a language that is fully supported, all you need to do is to copy/paste 3 files and change them to match the language that you want to add. Then add 1 line to README.md file. Here is my [commit](https://github.com/SerhiiCho/ago/commit/5a7d58569d6cd0af1d7981f3256f59ce19a6ad0e) for supporting Ukrainian language that shows changes that I did. You need to add 3 files for supporting another language. Here are 4 steps that you need to follow.

### How to make a PR

Before you start working on issue, add a comment to it, so that other folks know that someone is already working on it.

When you make a pull request, make sure that you don't pull it in the master branch. Pull it in the next package version. The name of the package version (Realease) matches the name of the branch. You can go to the [branches](https://github.com/SerhiiCho/ago/branches) page, and see what is the latest branch that is not merged, that branch is going to be the next package update.

### 1 Step. Adding translation

Translation files live in `resources/trans` directory. Here is the example of the language file for Russian language.

```php
return [
    'ago' => 'назад',
    'just_now' => 'Только что',
    'online' => 'В сети',
    'second' => 'секунда',
    'seconds' => 'секунды',
    'seconds-special' => 'секунд',
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
return static function (int $number, int $last_digit): array {
    return [
        'single' => [
            $number === 1,
            $last_digit === 1 && $number >= 21,
        ],
        'plural' => [
            $number >= 2 && $number < 5,
            $number >= 22 && $last_digit >= 2 && $last_digit < 5,
        ],
        'special' => [
            $number >= 5 && $number <= 20,
            $last_digit === 0,
            $last_digit >= 5 && $last_digit <= 9,
        ],
    ];
};
```

Every rule file should return a callback function with 2 parameters. The callback returns array of associative array. The array contains rules for 3 forms.

- `single` form for words in a single form, like minute, day, year, etc.
- `plural` form for words in a plural form, like minutes, days, years, etc.
- `special` *(optional)* form for special cases, for example in Russian, and Ukrainian we have special forms for words: **недель**, **месяцев**, etc. They are different from single and plural form. So we need to have separate rules for them.

Each form has a boolean rule or array of boolean rules. In Russian example we say that we want to use `single` form when last digit of the number is equal to 1 or number is 0. Now when we see date `1 day ago` in Russian the output will be `1 день назад`, which is the correct translation that we got from `resources/lang/ru.php` file where we have line `'day' => 'день'`. We can give either boolean to each rule or array of booleans when we have many cases for the form. In our example we have 3 cases for `special` form. If one of them will be true, special form will be applied.

### 3 Step. Adding tests

Tests for all translations are live in `tests/Translations` directory. Just copy one of the existing tests and change it whatever you want to match your language. Just make sure you have enough cases to cover specifics of your language. If you don't know about [PHPUnit Data Providers](https://phpunit.de/manual/3.7/en/writing-tests-for-phpunit.html) you might want to read about it.

### 4 Step. Add 1 line to README.md file

After all tests are passing, you need to do last step and add language support to README.md file to **Supported languages** section.

[<< Go back to home](https://github.com/SerhiiCho/ago/blob/master/README.md)
