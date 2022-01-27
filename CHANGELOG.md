# Release Notes

----

## v2.3.0 (2022-01-27)

- Added deprecation notice when you try to use `Option::UPCOMING` option;
- Closed [issue #34](vhttps://github.com/SerhiiCho/ago/issues/34). Changed `trans` method to except future dates and return correct result.

----

## v2.2.1 (2022-01-16)

- Fixed mistake in composer.json file with carbon library being as a dev dependency.

----

## v2.2.0 (2022-01-16)

- Added support for timestamps to `TimeAgo::trans()` method and not just strings.
- Added support for DateTime and DateTimeImmutable to `TimeAgo::trans()` method.
- Added support for Carbon and CarbonImmutable to `TimeAgo::trans()` method.
- Added more tests to make sure that new features are working correctly.

----

## v2.1.3 (2022-01-16)

- Added more info to README.md file about using second argument in Lang::set() method.
- Improved performance of the program by caching included translations and reusing them.

----

## v2.1.2 (2022-01-16)

- Added flags to supported languages table in README.md file.
- Added ability to overwrite translations. Closes issue [#20](https://github.com/SerhiiCho/ago/issues/20).
- Added more info to README.md file.

----

## v2.1.1 (2021-12-05)

- Added support for PHP 8.1

----

## v2.1.0 (2021-12-04)

- Other bug fixes with language rules.
- Code refactoring
- Bug fix with English language 0 seconds ago.

```diff
- 0 second ago
+ 0 seconds ago
```

----

## v2.0.8 (2021-12-04)

- Added more types for phpstan static analyzer.
- Added CHANGELOG.md file to the root of the project.

----

## v2.0.7 (2021-04-11)

- Fixed typo in composer.json file.

----

## v2.0.6 (2021-03-15)

- Added php8 to composer.json file.

----

## v2.0.5 (2020-12-06)

- Added new option UPPER that convert number to uppercase.
- Refactored the code.

----