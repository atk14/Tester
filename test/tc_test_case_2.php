<?php
class TcTestCase2 extends TcBase {

	function test(){
		$this->assertTrue((bool)strpos($GLOBALS["_TEST"]["FILENAME"],"test_case_2.php"));
		$this->assertTrue((bool)strpos($GLOBALS["_TEST_COPY"]["FILENAME"],"test_case_2.php"));
	}
}
