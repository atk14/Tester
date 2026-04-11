<?php
class TcExitingTestChecker extends TcBase {

	function test(){
		$run_unit_tests = $_SERVER["argv"][0];

		$failed_test = escapeshellarg("!tc_exiting_test.php");
		exec("$run_unit_tests $failed_test",$output,$result_code);
		$this->assertEquals(1,$result_code);
	}
}
