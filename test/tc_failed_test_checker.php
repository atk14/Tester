<?php
class TcFailedTestChecker extends TcBase {

	function test(){
		$run_unit_tests = $_SERVER["argv"][0];

		$failed_test = escapeshellarg("!tc_failed_test.php");
		$cmd = "$run_unit_tests $failed_test";
		exec($cmd,$output,$result_code);
		$this->assertEquals(1,$result_code);

		$successful_test = escapeshellarg("tc_successful_test.php");
		$cmd = "$run_unit_tests $successful_test";
		exec($cmd,$output,$result_code);
		$this->assertEquals(0,$result_code);
	}
}
