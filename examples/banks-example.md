## Banks list
This a tutorial on how to get a list of financial institutions in Nigeria
```PHP
use Flutterwave\Banks;
use Flutterwave\Flutterwave;

//merchantKey and apiKey can be found in your flutter developer console
//env can be production or staging depending on your stage of development
//you must always remember to set client credentials before any operation
Flutterwave::setClientCredentials($merchantKey, $apiKey, $env);

$result = Banks::allBanks();
//$result is an instance of ApiResponse class which has
//methods like getResponseData(), getStatusCode(), getResponseCode(), isSuccessfulResponse()
```
