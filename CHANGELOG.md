# Release Notes

## v3.2.5 (2024-09-08)
- Formatted code with Pint
- Update `README.md` file
- Update composer packages

## v3.2.4 (2024-04-14)
- Modified `LICENSE` file
- Updated composer packages

## v3.2.3 (2024-03-28)
- Added more information to `README.md` file
- Update `nestbot/carbon` package from `^3.0` to `^3.2.1`

## v3.2.2 (2024-03-09)
- Formatted `CHANGELOG.md` file
- Small code refactoring
- Added a new badge to a `README.md` file
- Moved scripts from `Makefile` to `composer.json`
- Removed slashes before each PHP native function

## v3.2.1 (2024-02-16)
- Added a "License" section to `README.md` file
- Added more tests
- Refactored tests

## v3.2.0 (2024-02-15)
- Added support for the German language

## v3.1.0 (2024-02-11)
- Updated `nestbot/carbon` package from `^2.2` to `^3.0`
- Updated `phpstan/phpstan` package from `0.12.x-dev` to `^1.10.57`
- Changed `sandfoxme/private-access` to `arokettu/private-access` package because of the deprecation of the first one

## v3.0.6 (2024-01-22)
- Removed badge from readme.md file
- Added description to each case in `Option` enum

## v3.0.5 (2023-11-14)
- Added support for PHP 8.3

## v3.0.4 (2023-09-06)
- Added support for PHP 8.2
- Connected Pint package to the project

## v3.0.3 (2022-10-09)
- Code refactoring. Making everything look nicer;

## v3.0.2 (2022-01-28)
- Removed comment in code examples in `CONTRIBUTE.md` file
- Typo in `README.md` file

## v3.0.1 (2022-01-28)
- Removed budge from `README.md` file that shows stable release
- Added `Option::JUST_NOW` option that print `Just now` if time is within 1 minute
- Added throwing `InvalidOptionsException` when you pass `JUST_NOW` and `ONLINE` options at the same time

## v3.0.0 (2022-01-27)
- Added banner image to a `README.md` file
- Removed option UPPER that convert number to uppercase. Because I don't want this package to depend on mb string extension

## v2.3.1 (2022-01-27)
- Added more information to `CONTRIBUTE.md` file
- Added support for Dutch language

## v2.3.0 (2022-01-27)
- Added deprecation notice when you try to use `Option::UPCOMING` option
- Closed [issue #34](vhttps://github.com/SerhiiCho/ago/issues/34). Changed `trans` method to except future dates and return correct result

## v2.2.1 (2022-01-16)
- Fixed mistake in composer.json file with carbon library being as a dev dependency

## v2.2.0 (2022-01-16)
- Added support for timestamps to `TimeAgo::trans()` method and not just strings
- Added support for DateTime and DateTimeImmutable to `TimeAgo::trans()` method
- Added support for Carbon and CarbonImmutable to `TimeAgo::trans()` method
- Added more tests to make sure that new features are working correctly

## v2.1.3 (2022-01-16)
- Added more info to README.md file about using second argument in Lang::set() method
- Improved performance of the program by caching included translations and reusing them

## v2.1.2 (2022-01-16)
- Added flags to supported languages table in README.md file
- Added ability to overwrite translations. Closes issue [#20](https://github.com/SerhiiCho/ago/issues/20)

## v2.1.1 (2021-12-05)
- Added support for PHP 8.1

## v2.1.0 (2021-12-04)
- Other bug fixes with language rules
- Code refactoring
- Bug fix with English language 0 seconds ago

```diff
- 0 second ago
+ 0 seconds ago
```

## v2.0.8 (2021-12-04)
- Added more types for PHPStan static analyzer
- Added CHANGELOG.md file to the root of the project

## v2.0.7 (2021-04-11)
- Fixed typo in composer.json file

## v2.0.6 (2021-03-15)
- Added php8 to composer.json file

## v2.0.5 (2020-12-06)
- Added new option UPPER that convert number to uppercase
- Refactored the code