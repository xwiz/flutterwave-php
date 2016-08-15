## Disbursement Example
With Flutterwave disbursement API, you can make payment to any financial institution in supported
countries.

```PHP
use Flutterwave\Disbursement;
use Flutterwave\Flutterwave;
use Flutterwave\Countries;
use Flutterwave\Currencies;

//merchantKey and apiKey can be found in your flutter developer console
//env can be production or staging depending on your stage of development
Flutterwave::setClientCredentials($merchantKey, $apiKey, $env);

$uniqueRef = "73646474"; //any unique reference you want to use
$amount = 10000; //amount to send
$sender = "Ridwan Olalere"; name of the sender
$banks = Banks::allBanks(); // this will return all banks with bank codes
$destination = array(
  "bankCode" => $banks['GTBank'],
  "recipientAccount" => "0983736454",
  "recipientName" => "Ayo Ayo",
  "country" => Countries::NIGERIA,
  "currency" => Currencies::NAIRA
);
$narration = "any description for this payment";

$result = Disbursement::send($amount, $uniqueRef, $sender, $destination, $narration);
//$result is an instance of ApiResponse class which has
//methods like getResponseData(), getStatusCode(), getResponseCode(), isSuccessfulResponse()

if ($result->isSuccessfulResponse()) {
  echo("I have successfully sent the money to you.");
}
```
