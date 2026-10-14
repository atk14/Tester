<?php
class TcMultipleDirs extends TcBase {

	function test(){
		$run_unit_tests = $_SERVER["argv"][0];

		$cmd = "$run_unit_tests dir1/tc_test_2_in_dir_1.php dir2/ tc_successful_test.php";

		exec($cmd,$output,$result_code);
		$this->assertEquals(0,$result_code);

		$tests = array_filter($output,function($l){ return !!preg_match('/^--- /',$l); });
		$tests = array_map(function($l){ return preg_replace('/^--- /','',$l); },$tests);
		$tests = array_values($tests);

		$this->assertEquals([
			"dir1/tc_test_2_in_dir_1.php",
			"dir2/tc_test_1_in_dir_2.php",
			"dir2/tc_test_2_in_dir_2.php",
			"tc_successful_test.php",
		],$tests);
	}
}
