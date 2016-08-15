<?php
use Flutterwave\FlutterEncrypt;

class FlutterEncryptTest extends \PHPUnit_Framework_TestCase {

  public function testEncryptWorks() {
    $b = new FlutterEncrypt();
    $result = $b->encrypt3Des("Ridwan", "tk_NabYp2XjZ6G9WwdFruzK");
    $this->assertNotEmpty($result);
  }
}
