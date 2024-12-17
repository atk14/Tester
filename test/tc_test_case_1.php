<?php
class TcTestCase1 extends TcBase {

	function test(){
		$this->assertTrue((bool)strpos($GLOBALS["_TEST"]["FILENAME"],"test_case_1.php"));
		$this->assertTrue((bool)strpos($GLOBALS["_TEST_COPY"]["FILENAME"],"test_case_1.php"));
	}
}
