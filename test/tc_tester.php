<?php
class TcTester extends TcBase {

	var $message;

	function _setUp(){
		$this->message = "_setUp() called";
	}

	function test(){
		$this->assertEquals(1,1);
		$this->assertEquals(null,0);
		$this->assertEquals(true,1);

		$this->assertTrue(true);
		$this->assertFalse(false);

		$this->assertNotEquals(1,2);

		// methods assertContains and assertNotContains do not work with strings anymore
		// $this->assertContains("mother","ATK15? Holy great mother of God, it's happening!");
		// $this->assertNotContains("father","ATK14? Holy great mother of God, it's happening!");

		$this->assertStringContains("mother","ATK14? Holy great mother of God, it's happening!");
		$this->assertStringContains("ATK14?","ATK14? Holy great mother of God, it's happening!");
		$this->assertStringNotContains("father","ATK14? Holy great mother of God, it's happening!");
		$this->assertStringNotContains("ATK14?!","ATK14? Holy great mother of God, it's happening!");

		$this->assertEquals("_setUp() called",$this->message);
	}
}
