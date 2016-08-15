<?php
use Flutterwave\Banks;

class BanksTest extends PHPUnit_Framework_TestCase {
  public function testBanksList() {
    $resp = Banks::allBanks();
    $this->assertTrue($resp->isSuccessfulResponse());
  }
}
