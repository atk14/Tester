<?php
class TcWarningChecker extends TcBase {

	function test(){
		$run_unit_tests = $_SERVER["argv"][0];

		$warning_test = escapeshellarg("!tc_warning.php");
		exec("$run_unit_tests $warning_test",$output,$result_code);
		$output = join("\n",$output);
		$this->assertStringContains("Undefined variable",$output);
	}
}
