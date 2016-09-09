<?php
namespace Flutterwave;

class Transaction {

  /**
   * urls to endpoints on staging and production server
   * @var [type]
   */
  private static $accountResources = [
    "staging" => [
      "status" => "http://staging1flutterwave.co:8080/pwc/rest/card/mvva/status"
    ],
    "production" => [
      "status" => "https://prod1flutterwave.co:8181/pwc/rest/card/mvva/status"
    ]
  ];

  public static function status($ref) {
    $key = Flutterwave::getApiKey();
    $ref = FlutterEncrypt::encrypt3Des($ref, $key);
    $resource = self::$accountResources[Flutterwave::getEnv()]["status"];
    $resp = (new ApiRequest($resource))
              ->addBody("trxreference", $ref)
              ->addBody("merchantid", Flutterwave::getMerchantKey())
              ->makePostRequest();
    return $resp;
  }
}
