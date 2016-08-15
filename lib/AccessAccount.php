<?php
namespace Flutterwave;
use Flutterwave\FlutterEncrypt;
use Flutterwave\FlutterValidator;

class AccessAccount {

  /**
   * urls to endpoints on staging and production server
   * @var [type]
   */
  private static $accountResources = [
    "staging" => [
      "order" => "http://staging1flutterwave.co:8080/pwc/rest/accessbank/pay",
      "validate" => "http://staging1flutterwave.co:8080/pwc/rest/accessbank/pay/validate",
      "resendOtp" => "http://staging1flutterwave.co:8080/pwc/rest/accessbank/pay/resendotp"
    ],
    "production" => ""
  ];

  /**
   * debit from and make payments to only access bank accounts
   * @param  string $ref       unique transaction reference
   * @param  int|float|double $amount    amount to send
   * @param  string $debitAcc  account to debit
   * @param  string $creditAcc account to credit
   * @param   string $narration description to send with the payment
   * @return ApiResponse
   */
  public static function charge($ref, $amount, $debitAcc, $creditAcc, $narration) {
    FlutterValidator::validateClientCredentialsSet();
    $key = Flutterwave::getApiKey();
    $encryptedDebitAcc = FlutterEncrypt::encrypt3Des($debitAcc, $key);
    $encryptedRef = FlutterEncrypt::encrypt3Des($ref, $key);
    $encryptedAmount = FlutterEncrypt::encrypt3Des($amount, $key);
    $encryptedCreditAcc = FlutterEncrypt::encrypt3Des($creditAcc, $key);
    $encryptedNarration = FlutterEncrypt::encrypt3Des($narration, $key);

    $resource = self::$accountResources[Flutterwave::getEnv()]["order"];
    $resp = (new ApiRequest($resource))
              ->addBody("trxref", $encryptedRef)
              ->addBody("accountNumber", $encryptedDebitAcc)
              ->addBody("merchantid", Flutterwave::getMerchantKey())
              ->addBody("creditAccountNumber", $encryptedCreditAcc)
              ->addBody("narration", $encryptedNarration)
              ->addBody("amountToPay", $encryptedAmount)
              ->makePostRequest();
    return $resp;
  }

  /**
   * validate a payment order
   * @param  string $ref    unique reference
   * @param  int|double|float $amount amount to send
   * @param  string $otp    otp sent to debit account owner
   * @param  string $token  token from order response data
   * @return ApiResponse
   */
  public static function validate($ref, $amount, $otp, $token) {
    FlutterValidator::validateClientCredentialsSet();
    $key = Flutterwave::getApiKey();
    $encryptedRef = FlutterEncrypt::encrypt3Des($ref, $key);
    $encryptedAmount = FlutterEncrypt::encrypt3Des($amount, $key);
    $encryptedOtp = FlutterEncrypt::encrypt3Des($otp, $key);
    $encryptedToken = FlutterEncrypt::encrypt3Des($token, $key);

    $resource = self::$accountResources[Flutterwave::getEnv()]["validate"];
    $resp = (new ApiRequest($resource))
              ->addBody("merchantid", Flutterwave::getMerchantKey())
              ->addBody("trxref", $encryptedRef)
              ->addBody("amountToPay", $encryptedAmount)
              ->addBody("otp", $encryptedOtp)
              ->addBody("accountToken", $encryptedToken)
              ->makePostRequest();
    return $resp;
  }

  /**
   * resend otp for certain transaction if otp not received
   * @param  string $ref   transaction reference
   * @param  int $validationOption can be 1, 2, or 3
   * @return ApiResponse
   */
  public static function resendOtp($ref, $validationOption) {
    FlutterValidator::validateClientCredentialsSet();
    $key = Flutterwave::getApiKey();
    $encryptedRef = FlutterEncrypt::encrypt3Des($ref, $key);
    $encryptedOption = FlutterEncrypt::encrypt3Des($ValidationAssetOption, $key);
    $merchantKey = Flutterwave::getMerchantKey();

    $resource = self::$accountResources[Flutterwave::getEnv()]["resendOtp"];
    $resp = (new ApiRequest($resource))
              ->addBody("merchantid", $merchantKey)
              ->addBody("validateoption", $encryptedOption)
              ->addBody("trxref", $encryptedRef)
              ->makePostRequest();
    return $resp;
  }
}
