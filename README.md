Tester
======

Statements:
- Testing should be easy as heck!
- Testing should be durable!

A test runner. Part of ATK14 Framework <http://www.atk14.net/>

Checking that all required dependencies are met:

    $ run_unit_tests --check-dependencies && echo "ok"
    # or
    $ run_unit_tests -c && echo "ok"

In working directory it searches for `tc_*.php` files. Every of them loads and runs tests.

    $ run_unit_tests

In file e.g. tc_currency.php it expects TcCurrency class (eventually tc_currency).

You can specify a list of test files to be executed

    $ run_unit_tests tc_account tc_bank_transfer

    eventually with .php suffix
    $ run_unit_tests tc_account.php tc_bank_transfer.php

Basic usage
-----------

In the project directory create directory test.

    $ mkdir test
    $ cd test

Place here first test case file tc_first_test_case.php in here:

    <?php
    // file: test/tc_first_test_case.php
    class TcFirstTestCase extends TcBase {

      function test_sum(){
        $this->assertEquals(6,3+3);
      }

      function test_multiplication(){
        $this->assertEquals(9,3*3);
      }
    }

Run tests from the first test case file:

    $ run_unit_tests
    --- tc_first_test_case.php


    Time: 00:00.012, Memory: 4.00 MB

    OK (2 tests, 0 assertions)

Put another test case file into the test direcotry:

    <?php
    // file: test/tc_strigs.php
    class TcStrings extends TcBase {

      function test(){
        $this->assertEquals("Hello World",join(" ",["Hello","World"]));
      }
    }

Run tests from both test case files:

    $ run_unit_tests 
    --- tc_first_test_case.php


    Time: 00:00.004, Memory: 4.00 MB

    OK (2 tests, 0 assertions)
    --- tc_strings.php


    Time: 00:00.004, Memory: 4.00 MB

    OK (1 test, 0 assertions)

Usually, it is necessary to load and initialize something before running tests. The file initialize.php, if exists, is loaded automatically.

    <?php
    // file: test/initialize.php
    require_once(__DIR__ . "/../src/lib/our_magical_library.php");


Dangerous tests
---------------
Sometimes you don't want to execute some test files automatically unless you specify them on command line.
Prefix such files with exclamation mark.

    $ run_unit_tests

    $ run_unit_tests \!tc_gangerous_test_case.php
    $ run_unit_tests '!tc_gangerous_test_case.php'

Automatization in testing
-------------------------

  $ cd /path/to/test_files/ && run_unit_tests && echo "TESTS ARE OK" || echo "THERE WERE ERRORS"

[//]: # ( vim: set ts=2 et: )
