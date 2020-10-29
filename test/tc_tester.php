<?php
class TcTester extends TcBase {

	function test(){
		$this->assertEquals(1,1);
		$this->assertEquals(null,0);
		$this->assertEquals(true,1);

		$this->assertTrue(true);
		$this->assertFalse(false);

		$this->assertNotEquals(1,2);

		$this->assertContains("mother","ATK14? Holy great mother of God, it's happening!");
	}
}
