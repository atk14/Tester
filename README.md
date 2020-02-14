Tester
======

A test runner. Part of ATK14 Framework <http://www.atk14.net/>
                                                                                                           
Checking that all required dependencies are met:
                                                                                                           
    $ run_unit_tests --check-dependencies && echo "ok"
    # or
    $ run_unit_tests -c && echo "ok"
                                                                                                           
In working directory it searches for tc_*.php files. Every of them loads and runs tests.
                                                                                                           
    $ run_unit_tests

In file e.g. tc_currency.php it expects TcCurrency class (eventually tc_currency).
                                                                                                           
You can specify a list of test files to be executed
                                                                                                           
    $ run_unit_tests tc_account tc_bank_transfer
                                                                                                           
    eventually with .php suffix
    $ run_unit_tests tc_account.php tc_bank_transfer.php

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
