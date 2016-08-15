## Access Account Example
This example will show you how to move money from your verified access account to another
access account.

```PHP
use Flutterwave\AccessAccount;
use Flutterwave\Flutterwave;

//merchantKey and apiKey can be found in your flutter developer console
//env can be production or staging depending on your stage of development
Flutterwave::setClientCredentials($merchantKey, $apiKey, $env);

$ref = "746464"; //any valid reference
$debitAcc = "8744644"; //your account number to debit
$creditAcc = "7446464748"; //your account number to credit
$amount = 70000; //amount to debit and credit
$narration = "any narration is fine"; //your narration for the transaction
$result = AccessAccount::charge($ref, $amount, $debitAcc, $creditAcc, $narration);

if ($result->isSuccessfulResponse()) {
  echo("Transaction registered"); //now you need to validate the transaction using validate method
}

$data = $result->getResponseData();
$ref = $data['data']['transactionReference']; //use the transactionReference from the charge() response call
$amount = 1000;
$otp = "444"; //otp sent to the bank account owner
$token = $data['data']['transactionToken']; //use the token from the charge() response call
$result2 = AccessAccount::($ref, $amount, $otp, $token);

if ($result2->isSuccessfulResponse()) {
  echo("I have successfully sent the money");
}


//if for any reason the account owner did not get otp you can do resendOtp
AccessAccount::resendOtp($ref, $validationOption);


```
