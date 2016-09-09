<?php

use Flutterwave\Flutterwave;
use Flutterwave\Transaction;
use Flutterwave\Card;
use Flutterwave\Currencies;
use Flutterwave\AuthModel;

class TransactionTest extends PHPUnit_Framework_TestCase {
  public function setUp() {
    $merchantKey = "tk_tdyrSMQo8a";
    $apiKey = "tk_NabYp2XjZ6G9WwdFruzK";
    Flutterwave::setMerchantCredentials($merchantKey, $apiKey);
  }

  public function testEmpty() {
    $card = [
      "card_no" => "4604504564868571",
      "cvv" => "812",
      "expiry_month" => "08",
      "expiry_year" => "18"
    ];
    $resp = Card::charge($card, 1000, uniqid(), Currencies::NAIRA, "PIN", "test", "");
    $data = $resp->getResponseData();
    print_r($data);
    return $data['transactionreference'];
  }

  /**
   *
   * @depends testEmpty
   */
  public function testTransactionStatus($ref) {
    $resp = Transaction::status($ref);
    $data = $resp->getResponseData();

    $this->assertTrue($resp->isSuccessResponse());
    $this->assertTrue(!empty($data));
    $this->$this->assertEquals("00", $data['responsecode']);
    $this->$this->assertEquals($transactionReference, $data['transactionreference']);
  }
}
