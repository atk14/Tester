Tester
======

Tester is a PHPUnit wrapper that abstracts PHPUnit's API changes across different PHP and PHPUnit versions. This means you can use the same test suites regardless of which PHPUnit version is installed. Tester makes it much easier to keep your tests working as you upgrade PHP or PHPUnit.

Statements:
- Testing should be easy as heck!
- Source code of test cases should be durable. No one wants to rewrite the tests for the new version of PHPUnit.

Supported versions:
- PHP 5.6, 7.x, 8.x
- PHPUnit ~4.8 | ~5.7 | ~6.0 | ~7.5 | ~8.5 | ~9.6 | ~10.0 | ~11.0


Installation
------------

Installation only for a specific project:

    composer require --dev atk14/tester

Global installation:

    composer global require atk14/tester

In case of global installation, it is convenient to have the path `$HOME/.config/composer/vendor/bin/` in the `$PATH` environment variable.

Checking that all required dependencies are met:

    $ run_unit_tests --check-dependencies && echo "ok"
    # or
    $ run_unit_tests -c && echo "ok"


Basic usage
-----------

In the project directory, create a `test` directory:

    $ mkdir test
    $ cd test

Place a test case file `tc_first_test_case.php` in there:

    <?php
    // file: test/tc_first_test_case.php
    class TcFirstTestCase extends TcBase {

      function test_sum(){
        $this->assertEquals(6, 3 + 3);
      }

      function test_multiplication(){
        $this->assertEquals(9, 3 * 3);
      }
    }

The `TcBase` class doesn't need to be defined — Tester creates it automatically if the file `tc_base.php` is absent.

Run all tests in the directory:

    $ run_unit_tests
    --- tc_first_test_case.php


    Time: 00:00.012, Memory: 4.00 MB

    OK (2 tests, 2 assertions)

You can also run a specific test case or a subset of test cases:

    $ run_unit_tests tc_first_test_case
    $ run_unit_tests tc_first_test_case tc_strings

Or point `run_unit_tests` at a subdirectory:

    $ run_unit_tests path/to/test/


Initialization
--------------

Usually it is necessary to load and initialize something before running tests. The file `initialize.php`, if it exists in the test directory, is loaded automatically before each test case.

    <?php
    // file: test/initialize.php
    require_once(__DIR__ . "/../vendor/autoload.php");


TcBase and TcSuperBase
----------------------

Tester provides the `TcSuperBase` class (and its alias `tc_super_base`), which extends PHPUnit's `TestCase` and adds compatibility shims described below.

Your test cases should extend `TcBase`. If you don't create a `tc_base.php` file, Tester creates a plain `TcBase` that simply extends `TcSuperBase`. When you need shared setup, teardown, or helper methods across all your test cases, define `TcBase` yourself:

    <?php
    // file: test/tc_base.php
    class TcBase extends TcSuperBase {

      function _setUp(){
        // runs before each test method
      }

      function _tearDown(){
        // runs after each test method
      }
    }

Note that Tester uses `_setUp()` and `_tearDown()` instead of PHPUnit's `setUp()` and `tearDown()`. This is intentional — it avoids conflicts with PHPUnit's internal lifecycle and works consistently across all supported PHPUnit versions.


Compatibility shims
-------------------

Tester adds the following assertion methods to `TcSuperBase` when they are missing from the installed PHPUnit version:

- `assertStringContains($needle, $haystack, $message = "")` — asserts that `$haystack` contains `$needle` as a substring
- `assertStringNotContains($needle, $haystack, $message = "")` — asserts that `$haystack` does not contain `$needle`
- `assertContains($needle, $haystack, $message = "")` — alias for `assertStringContains`
- `assertNotContains($needle, $haystack, $message = "")` — alias for `assertStringNotContains`

This means you can use `assertStringContains` in your tests and they will work on both old and new PHPUnit versions.


Global variable `$_TEST`
------------------------

Before each test case file is loaded, the global variable `$_TEST` is set. It contains the full path to the currently executed test case file, which can be useful in `initialize.php`:

    <?php
    // file: test/initialize.php

    if(preg_match('/_theme_dark\.php$/', $_TEST["FILENAME"])){
      define("COLOR_BACKGROUND", "#000000");
      define("COLOR_TEXT",       "#999999");
    } else {
      define("COLOR_BACKGROUND", "#FFFFFF");
      define("COLOR_TEXT",       "#333333");
    }


Dangerous tests
---------------

Sometimes you don't want certain test files to run automatically — for example, tests that modify a production database or send real emails. Prefix such files with an exclamation mark:

    !tc_dangerous_test_case.php

These files are ignored by a plain `run_unit_tests` call:

    $ run_unit_tests
    # !tc_dangerous_test_case.php is skipped

To run a dangerous test explicitly, name it on the command line:

    $ run_unit_tests \!tc_dangerous_test_case.php
    # or
    $ run_unit_tests '!tc_dangerous_test_case.php'


Automation in CI
----------------

    cd test && \
    ../vendor/bin/run_unit_tests && \
    echo "TESTS ARE OK" && exit 0 || \
    echo "THERE WERE ERRORS" && exit 1

For use in shell scripts or Makefile targets, `run_unit_tests` exits with code `0` on success and `1` on failure, making it straightforward to integrate into any CI pipeline.

License
-------

Tester is free software distributed [under the terms of the MIT license](http://www.opensource.org/licenses/mit-license).

[//]: # ( vim: set ts=2 et: )
