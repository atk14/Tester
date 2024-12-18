<?php
// This needs to run together with TcTearDownB:
// $ run_unit_tests tc_tear_down_a.php tc_tear_down_b.php
class TcTearDownA extends TcBase {

	function _tearDown(){
		touch(__DIR__ . "/tmp/tear_down_check_file");
	}

	function test(){
		$this->assertFalse(file_exists(__DIR__ . "/tmp/tear_down_check_file"));
	}
}
