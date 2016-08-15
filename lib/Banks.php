<?php
namespace Flutterwave;

/**
 * can get list of all banks
 */
class Banks {

  /**
   * urls to both staging and production server for banks
   * @var array
   */
  private static $resources = [
    "staging" => "http://staging1flutterwave.co:8080/pwc/rest/fw/banks/",
    "production" => ""
  ];

  /**
   *
   * @return [type] [description]
   */
  public static function allBanks() {
    $resouce = self::$resources[Flutterwave::getEnv()];
    $resp = (new ApiRequest($resouce))
              ->makePostRequest();
    return $resp;
  }
}
