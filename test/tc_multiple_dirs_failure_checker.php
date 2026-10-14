<?php
class TcMultipleDirsFailureChecker extends TcBase {

	function test(){
		$run_unit_tests = $_SERVER["argv"][0];

		$cmd = "$run_unit_tests dir1/ dir3/";
		exec($cmd,$output,$result_code);

		$this->assertEquals(1,$result_code);

		$output = join("\n",$output);
		$this->assertStringContains("--- dir1/tc_test_1_in_dir_1.php",$output);
		$this->assertStringContains("--- dir1/tc_test_2_in_dir_1.php",$output);
		$this->assertStringContains("--- dir3/tc_failing_test_in_dir_3.php",$output);
	}
}
