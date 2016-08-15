<?php
namespace Flutterwave;

use Flutterwave\FlutterEncrypt;

/**
 *
 */
class Disbursement {

  //@var array resources
  private static $resources = [
    "staging" => "http://staging1flutterwave.co:8080/pwc/rest/pay/send",
    "production" => ""
  ];

  /**
   * can be used to disburse funds
   * @param double/float $amount
   * @param string $uniqueRef
   * @param string $sender name of the sender
   * @param array $destination
   * @param string $narration
   * @return ApiResponse
   */
  public static function send($amount, $uniqueRef, $sender, $destination, $narration) {
    FlutterValidator::validateClientCredentialsSet();
    //TODO: validate keys of destination is correct
    $key = Flutterwave::getApiKey();
    $encryptedAmount = FlutterEncrypt::encrypt3Des($amount, $key);
    $encryptedRef = FlutterEncrypt::encrypt3Des($uniqueRef, $key);
    $encryptedBank = FlutterEncrypt::encrypt3Des($destination['bankCode'], $key);
    $encryptedNarration = FlutterEncrypt::encrypt3Des($narration, $key);
    $encryptedRecipientAccount = FlutterEncrypt::encrypt3Des($destination['recipientAccount'], $key);
    $encryptedRecipientName = FlutterEncrypt::encrypt3Des($destination['recipientName'], $key);
    $encryptedSender = FlutterEncrypt::encrypt3Des($sender, $key);
    $country = FlutterEncrypt::encrypt3Des($destination['country'], $key);
    $currency = FlutterEncrypt::encrypt3Des($destination['currency'], $key);
    $merchantKey = Flutterwave::getMerchantKey();

    $resource = self::$resources[Flutterwave::getEnv()];
    $resp = (new ApiRequest($resource))
              ->addBody("merchantid", $merchantKey)
              ->addBody("transferamount", $encryptedAmount)
              ->addBody("uniquereference", $encryptedRef)
              ->addBody("destbankcode", $encryptedBank)
              ->addBody("narration", $encryptedNarration)
              ->addBody("recipientaccount", $encryptedRecipientAccount)
              ->addBody("recipientname", $encryptedRecipientName)
              ->addBody("sendername", $encryptedSender)
              ->addBody("country", $country)
              ->addBody("currency", $currency)
              ->makePostRequest();
    return $resp;
  }
}
