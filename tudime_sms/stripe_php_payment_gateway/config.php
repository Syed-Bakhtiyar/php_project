<?php
header('Content-Type: application/json; Charset=UTF-8');
require('stripe-php-master/init.php');

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$number = $_POST['number'];
$exp_month = $_POST['exp_month'];
$exp_year = $_POST['exp_year'];
$cvc = $_POST['cvc'];

$name = $_POST['name'];
$line1 = $_POST['line1'];
$postal_code = $_POST['postal_code'];
$city = $_POST['city'];
$state = $_POST['state'];
$country = $_POST['country'];

$amount = $_POST['amount']*100;




//require_once('/path/to/stripe-php/init.php');

//$publishableKey="pk_test_51HdyVDIcN6xdTxj27TzUindLuR7BfsKRuM2IaarFIo8Gz1gFvvirMCCXAvbDJAgdUfMAYnT0xQ6WdXFQMRmrpFqL00WbPwqXd8";  // test key
$publishableKey="pk_live_51Hla1pF2i6ViGnO30MRJmlIAv3DoVKVEgdBwMCn9qqDrQvteJI9cF0EoEu8D15oQrM1O4FHpM1nvEVUiKlQBk7G400Np8MvKcH";  // production  key

//$secretKey="sk_test_51HdyVDIcN6xdTxj221YBXKazVgpRTlybIfcghuHJfC4KjEbPNin2eSJZFvGHkzdQRe6HRuFe4H3haICpVtUO72R500lig61UkH"; // test key
$secretKey="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"; // production  key

\Stripe\Stripe::setApiKey($secretKey);


//\Stripe\Stripe::setApiKey($secretKey);
try{
$stripe = new \Stripe\StripeClient(
  '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'
);
$data = $stripe->tokens->create([
  'card' => [
    'number' => $number,
    'exp_month' => $exp_month,
    'exp_year' => $exp_year,
    'cvc' => $cvc,
  ],
]);
}catch(\Stripe\Exception\CardException $e) {
  // Since it's a decline, \Stripe\Exception\CardException will be caught
  //echo 'Status is:' . $e->getHttpStatus() . '\n';
  //echo 'Type is:' . $e->getError()->type . '\n';
  //echo 'Code is:' . $e->getError()->code . '\n';
  // param is '' in this case
  //echo 'Param is:' . $e->getError()->param . '\n';
  //echo 'Message is:' . $e->getError()->message . '\n';
  
  $response = array("status" => "error", "error_message" => "Payment is invalid. ".$e->getError()->message, "success_message" => '', "data" => "");
  echo json_encode($response);
  die;
} catch (\Stripe\Exception\RateLimitException $e) {
  // Too many requests made to the API too quickly
} catch (\Stripe\Exception\InvalidRequestException $e) {
  // Invalid parameters were supplied to Stripe's API
} catch (\Stripe\Exception\AuthenticationException $e) {
  // Authentication with Stripe's API failed
  // (maybe you changed API keys recently)
} catch (\Stripe\Exception\ApiConnectionException $e) {
  // Network communication with Stripe failed
} catch (\Stripe\Exception\ApiErrorException $e) {
  // Display a very generic error to the user, and maybe send
  // yourself an email
} catch (Exception $e) {
  // Something else happened, completely unrelated to Stripe
}
if(isset($data['id'])){
	\Stripe\Stripe::setVerifySslCerts(false);

	$token=$data['id'];

	/*$data=\Stripe\Charge::create(array(
		"amount"=>5555,
		"currency"=>"zar",
		"description"=>"Programming with Sourav Desc",
		"source"=>$token,
		
	));*/
	
	
	
	/*$payment_intent = \Stripe\Charge::create([
  'description' => 'Software development services',
  'shipping' => [
    'name' => 'Jenny Rosen',
    'address' => [
      'line1' => '510 Townsend St',
      'postal_code' => '98140',
      'city' => 'San Francisco',
      'state' => 'CA',
      'country' => 'US',
    ],
  ],
  'amount' => 1500,
  'currency' => 'usd',
  //'payment_method_types' => ['card'],
  "source"=>$token,
]);*/

$payment_intent = \Stripe\Charge::create([
  'description' => 'Software development services',
  'shipping' => [
    'name' => $name,
    'address' => [
      'line1' => $line1,
      'postal_code' => $postal_code,
      'city' => $city,
      'state' => $state,
      'country' => $country,
    ],
  ],
  'amount' => $amount,
  'currency' => 'usd',
  //'payment_method_types' => ['card'],
  "source"=>$token,
]);

	$response = array("status" => "success", "error_message" => "", "success_message" => "Payment is successfull.", "data" => $payment_intent);
}

echo json_encode($response);
//echo '<pre>';
//print_r($data);

?>