<?php
class TcTestCase1 extends TcBase {

	function test(){
		$this->assertContains("test_case_1.php",$GLOBALS["_TEST"]["FILENAME"]);
		$this->assertContains("test_case_1.php",$GLOBALS["_TEST_COPY"]["FILENAME"]);
	}
}
