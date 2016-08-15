<?php
use Flutterwave\AccessAccount;
use Flutterwave\Flutterwave;

class AccessAccountTest extends PHPUnit_Framework_TestCase {
  public function setUp() {
    Flutterwave::setMerchantCredentials("tk_tdyrSMQo8a", "tk_NabYp2XjZ6G9WwdFruzK");
  }

  public function testOrder() {
    $ref = "3445";
    $amount = 1000;
    $debitAcc = "0704580684";
    $creditAcc = "0706329119";
    $narration = "test";

    Flutterwave::setMerchantCredentials("tk_tdyrSMQo8a", "tk_NabYp2XjZ6G9WwdFruzK");
    $resp = AccessAccount::charge($ref, $amount, $debitAcc, $creditAcc, $narration);
    $this->assertTrue($resp->isSuccessfulResponse());
  }

}
