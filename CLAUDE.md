# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## What this is

Tester (`atk14/tester`) is a single-file PHPUnit compatibility wrapper. It lets test suites written once keep working unmodified across PHPUnit ~4.8 through ~11.0 and PHP 5.6 through 8.x, by abstracting over PHPUnit's breaking API changes between major versions.

Essentially the entire implementation lives in `bin/run_unit_tests` (~440 lines, no other PHP source files). There is no `src/` directory and no autoloader entries in `composer.json` — this script *is* the library.

## Commands

Run the self-test suite (the project's own tests, located in `test/`):

```
cd test && ../bin/run_unit_tests
```

Run a single test case by file or class name:

```
cd test && ../bin/run_unit_tests tc_tester
cd test && ../bin/run_unit_tests tc_tester.php
```

Run multiple specific test cases:

```
cd test && ../bin/run_unit_tests tc_test_case_1 tc_test_case_2
```

Check that PHPUnit is installed/discoverable without running tests:

```
run_unit_tests --check-dependencies && echo "ok"
run_unit_tests -c && echo "ok"
```

Dangerous tests (filenames prefixed with `!`, e.g. `!tc_failed_test.php`) are skipped by a bare `run_unit_tests` run and must be named explicitly, with the `!` escaped or quoted:

```
../bin/run_unit_tests \!tc_failed_test.php
../bin/run_unit_tests '!tc_failed_test.php'
```

CI (`.github/workflows/tests.yml`) runs this exact test command across PHP 5.6–8.5 via a matrix, using `composer update` to pull the latest allowed PHPUnit for each PHP version.

There is no separate lint/build step — `composer.json` has empty `require-dev` and `autoload` blocks by design, since the library is the single executable script plus the dynamically-generated base classes it `eval()`s at runtime.

## Architecture

`bin/run_unit_tests` runs as a standalone PHP CLI script (not through PHPUnit's own CLI) and does the following, in order:

1. **PHPUnit discovery**: probes a prioritized list of candidate vendor paths (local `vendor/phpunit`, walking up parent directories; global composer home; `~/.composer`; `~/.config/composer`; `~/.phpenv/...`; `/usr/share/php/PHPUnit` for the legacy PHPUnit2 pear package) and requires whichever autoloader it finds first. This is what lets the same script work whether PHPUnit is installed locally, globally, or as the ancient PHPUnit2.
2. **Version branching via defined constants**: `PHPUNIT2`, `PHPUNIT`, `PHPUNIT10PLUS` are computed once at startup and gate nearly all subsequent logic. PHPUnit went through major internal API changes at versions 2, ~9/10 (new `TestRunner`/`Facade`/event system), so the script forks its behavior three ways rather than targeting one API.
3. **Dynamic base class generation via `eval()`**: `tc_super_base` / `TcSuperBase` classes are built at runtime (not as static PHP files) because which parent class to extend (`PHPUnit2_Framework_TestCase`, `PHPUnit_Framework_TestCase`, or `PHPUnit\Framework\TestCase`) and which `setUp()`/`tearDown()` signatures are legal (PHP 7.1+ requires `:void` return types) depend on the detected environment. This same step adds compatibility shims (`assertStringContains`, `assertStringNotContains`, and `assertContains`/`assertNotContains` aliases) only when the installed PHPUnit version doesn't already provide them.
4. **Test discovery**: scans the current working directory (after `chdir`-ing to whatever directory was passed in) for `tc_*.php`/`tc_*.inc` files. Files starting with `!` are "dangerous" and are excluded unless named explicitly on the command line. `initialize.inc`/`initialize.php` is loaded before tests if present; `tc_base.inc`/`tc_base.php` is loaded if present, otherwise `TcBase`/`tc_base` are auto-generated as plain subclasses of `TcSuperBase`/`tc_super_base`.
5. **Execution strategy — single vs. multiple test files**: if only one test file is being run, it executes in-process (so a single file's `exit()` calls, output, and `$_TEST` global behave predictably). If more than one file is selected, the script **re-invokes itself via `passthru()` once per file**, each in its own subprocess — this isolates test cases from each other (global state, defined constants, `exit()` calls in one file can't corrupt another) and aggregates exit codes.
6. **Per-PHPUnit-version test runner (`_test_runner()`)**: contains three separate code paths for actually building a `TestSuite`/`TestResult`/printer and running it — one for PHPUnit2, one for PHPUnit 10+ (using the new `Facade`/`Configuration\Builder`/`TestRunner`/`ShellExitCodeCalculator` event-driven API), and one for everything in between (PHPUnit 4–9, via `PHPUnit_Framework_TestSuite`/`PHPUnit\Framework\TestSuite` and listener-based `TestResult`). Each returns an object responding to `wasSuccessful()` so the rest of the script doesn't need to know which path was taken.
7. **Lifecycle naming**: test cases use `_setUp()`/`_tearDown()` (not PHPUnit's `setUp()`/`tearDown()`) — these are the user-overridable hooks; the generated base class's own `setUp()`/`tearDown()` call them internally. This indirection is what keeps user test code decoupled from PHPUnit's changing lifecycle method signatures across versions.

### Test suite structure (`test/`)

The project tests itself using its own tool (`run_unit_tests` testing `run_unit_tests`). Notable patterns:

- `tc_tester.php` exercises the compatibility shim assertions (`assertStringContains`, etc.) and `_setUp()`.
- "Dangerous" files (`!tc_failed_test.php`, `!tc_exiting_test.php`, `!tc_warning.php`) are fixtures deliberately written to fail, `exit()` early, or trigger a PHP warning — they are *not* run as part of the normal suite.
- Their corresponding `tc_*_checker.php` files invoke `run_unit_tests` as a subprocess (via `exec()`, using `$_SERVER["argv"][0]` to find the running binary) against the dangerous fixture and assert on the resulting exit code / output — i.e., the checker tests validate end-to-end CLI behavior rather than calling internals directly.
- When adding a new compatibility edge case (e.g., a PHPUnit version quirk), follow this pattern: add a dangerous/edge-case fixture prefixed with `!`, then a `*_checker.php` that shells out to `run_unit_tests` against it and asserts on exit code/output.

## Versioning

`CHANGELOG.md` is maintained manually and lists released versions with their git commit hashes/subjects. Update it when making a user-facing change, following the existing `[x.y.z] - YYYY-MM-DD` format.
