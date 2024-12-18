<?php
// This needs to run together with TcTearDownA:
// $ run_unit_tests tc_tear_down_a.php tc_tear_down_b.php
class TcTearDownB extends TcBase {

	function _tearDown(){
		unlink(__DIR__ . "/tmp/tear_down_check_file");
	}

	function test(){
		$this->assertTrue(file_exists(__DIR__ . "/tmp/tear_down_check_file"));
	}
}
