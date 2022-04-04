<?php
class TcTestCase2 extends TcBase {

	function test(){
		$this->assertContains("test_case_2.php",$GLOBALS["_TEST"]["FILENAME"]);
		$this->assertContains("test_case_2.php",$GLOBALS["_TEST_COPY"]["FILENAME"]);
	}
}
