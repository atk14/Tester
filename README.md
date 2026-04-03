Tester
======

Tester is a PHPUnit loader that abstracts PHPUnit's API changes across different PHP versions. This means you can use the same test suites for different PHP versions in your project. In fact, Tester makes it much easier to port your project to a new PHP version.

Statements:
- Testing should be easy as heck!
- Source code of test cases should be durable. No one wants to rewrite the tests for the new version of PHPUnit.


Installation
------------

Installation only for a specific project.

    composer require --dev atk14/tester

Global instalation.

    composer global require atk14/tester

In case of global instalation, it is convenient to have path `$HOME/.config/composer/vendor/bin/` in the `$PATH` environment variable.

Checking that all required dependencies are met.

    $ run_unit_tests --check-dependencies && echo "ok"
    # or
    $ run_unit_tests -c && echo "ok"


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

It doesn't matter that the TcBase class isn't defined. The tester will create it if necessary.

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

You can run selected test cases by entering them at the command line.

    $ run_unit_tests tc_first_test_case
    $ run_unit_tests tc_first_test_case tc_strings

Usually, it is necessary to load and initialize something before running tests. The file initialize.php, if exists, is loaded automatically.

    <?php
    // file: test/initialize.php
    require_once(__DIR__ . "/../src/lib/our_magical_library.php");

If necessary, you can define the TcBase class.

    <?php
    // file: test/tc_base.php
    class TcBase extends TcSuperBase {

      function _setUp(){
        // something that should be done before every test
      }

      function _tearDown(){
        // something that should be done after every test
      }
    }

The class TcSuperBase is prepared for you by the Tester.

Dangerous tests
---------------
Sometimes you don't want to execute some test files automatically unless you specify them on command line.
Prefix such files with exclamation mark.

    $ run_unit_tests

    $ run_unit_tests \!tc_gangerous_test_case.php
    $ run_unit_tests '!tc_gangerous_test_case.php'

Automatization in testing
-------------------------
    
    cd test && \
    ../vendor/bin/run_unit_tests && \
    echo "TESTS ARE OK" && exit 0 || \
    echo "THERE WERE ERRORS" && exit 1

[//]: # ( vim: set ts=2 et: )
