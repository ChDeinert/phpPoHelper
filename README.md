# phpPoHelper

[![Software License][ico-license]](LICENSE)

This package helps working on Gettext Po Files by converting each entry into an Object.

## Current state

The package is a Work in Progress on not ready for production use, yet.

### What it does

- Read a Po File and create an Object
- Manage Po File Entries in an Collection
    - Add file references to an entry
    - Add Flags to an entry
    - Edit the msgstr of an entry
- Manage the Po File Header entry
    - Set the title
    - Set the language
    - Set the Po revision date
- Write a (very basic) Po File from an Object

### What it doesn't

But eventually will:
- Manage plural Entries
- Parse Multi line Entries (it currently only takes the first line which tends to be empty on these)
- Parse and manage Comments on an Entry
- Parse and manage message Context (msgctxt) of an Entry
- Parse and manage more of the Header Entry

And never will:
- Parse and manage previous message context and id
- Search your Project for Gettext Strings
- Compile a Po File into an Mo File

## Requirements

Following PHP Versions are Supported/Tested

- PHP 7


## Testing

The Package uses Robo to run the tests. You can run them by running:

```
./vendor/bin/robo tests:run
```

Also you can check/fix your codestyle with [php-cs-fixer][php-cs-fixer-link] with following commands:

- To check your codestyle
```
./vendor/bin/robo style:check
```
- To check your codestyle and show the problems it finds
```
./vendor/bin/robo style:diff
```
- To automatically fix the problems it finds
```
./vendor/bin/robo style:fix
```

It also provides an automatic test runner, you can start with:
```
./vendor/bin/robo watch
```
This will check your codestyle and run the tests when a file in `/src` is changed. If a file in `/tests` is changed, it will only run the tests without checking the style.

## Credits

- [Christian Deinert][link-author]

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[link-author]: https://github.com/ChDeinert
