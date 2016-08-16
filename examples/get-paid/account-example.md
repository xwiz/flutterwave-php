## Get Paid Account Example
This example will show you how to get paid from any bank account.

#### Account Flow
To get paid from any account you need to first tokenize the account by performing the
operation `initiate` then `validate`, in the validate operation the account owner will get
an otp which needs to be supplied to `validate` method then you can do `charge` account which
will then charge the account.

```PHP
use Flutterwave\Account;
use Flutterwave\Flutterwave;

//merchantKey and apiKey can be found in your flutter developer console
//env can be production or staging depending on your stage of development
$merchantKey = ""; //can be found on flutterwave dev portal
$apiKey = ""; //can be found on flutterwave dev portal
$env = "staging"; //this can be production when ready for deployment
Flutterwave::setMerchantCredentials($merchantKey, $apiKey, $env);

$accountNumber = ""; //account number you want to charge
$resp = Account::initiate($accountNumber);
if ($resp->isSuccessfulResponse()) {
  echo("Works");
}

$ref = $resp['data']['transactionReference'];
$otp = ""; //sent to account owners number
$billingAmount = 1000;
$narration = "payment for forLoop";
$resp2 = Account::validate($ref, $accountNumber, $otp, $billingAmount, $narration);

if ($resp2->isSuccessful()) {
  echo("Successfully validated");
}

//this method will charge an account after validating the account
$token = $resp2['data']['accountToken'];
$narration = "payment for forLoop";
$resp3 = Account::charge($token, $amount, $narration);

if ($resp3->isSuccessfulResponse()) {
  echo("We have successfully charged this account for you");
}




```
