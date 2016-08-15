## Ip Check Example
This is a template for you to use get information about an IP address throw Flutterwave API
```PHP
use Flutterwave\Ip;

$ipAddress = "127.0.0.1";
$result = Ip::check($ipAddress);
//$result is an instance of ApiResponse class which contains
//methods like getResponseData(), getStatusCode(), getResponseCode(), isSuccessfulResponse()
```
