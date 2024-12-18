Change Log
==========

All notable changes to the Tester will be documented in this file.

[0.5] - 2024-12-18
------------------

* Tester is compatible with phpunit/phpunit in version ~4.8|~5.7|~6.0|~7.5|~8.5|~9.6
* Added aliases for backwards compatibility with PHP<7.1
  - `TcSuperBase::_setUp()` is alias for `TcSuperBase::setUp()`
  - `TcSuperBase::_tearDown()` is alias for `TcSuperBase::tearDown()`

[0.4.1] - 2024-12-17
--------------------

* 8622428 - Package tester is compatible with PHP>=5.6
* 0f9d29d - Script run_unit_tests improved

[0.4] - 2022-05-06
------------------

* d527c65 - Added methods assertStringContains and assertStringNotContains, resp. assertContains and assertNotContains if they dont exist
* fa40058 - Dependency on phpunit/phpunit updated: "~4.8|~5.7|~6.0" -> "~4.8|~5.7|~6.0|~7.5"

[0.3.1] - 2022-04-04
--------------------

* 516574d - Global variable `$_TEST` is defined before the initialization file is being loaded

[0.3] - 2020-10-30
------------------

- Tester is working in PHP8
- Package phpunit/phpunit is used in versions ~4.8|~5.7|~6.0

[0.2] - 2020-02-14
------------------

- Presence of required dependencies can be check by calling ```run_unit_tests --check-dependencies```

[0.1.1] - 2019-07-12
--------------------

- Fixed: SCRIPT is stated with absolute path in passthru()

[0.1] - 2019-03-15
------------------

- First official release
