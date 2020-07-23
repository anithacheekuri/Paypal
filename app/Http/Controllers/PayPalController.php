<?php
  
namespace App\Http\Controllers;
  
use Illuminate\Http\Request;
use Srmklive\PayPal\Services\ExpressCheckout;
use PayPalCheckoutSdk\Core\PayPalHttpClient;
use PayPalCheckoutSdk\Core\SandboxEnvironment;
use PayPalCheckoutSdk\Orders\OrdersCreateRequest;
class PayPalController extends Controller
{
    /**
     * Responds with a welcome message with instructions
     *
     * @return \Illuminate\Http\Response
     * 
     */

    public function execute(Request $request){
        

     
        $clientId = "AeEnHOmXys9LpmXWh7NFwoJKR5ZwSg5IadLuECUGMSd4BEM1W-5UNYJcTEwsF7KzIjw1uJsXatgKZ-2g";
        $clientSecret = "EAzFh3eDaAqEjRrJWuBV8oG55JNwNWcWyr7IE8R635B0WKc30VA7SPoSzj_Y83veH66N0rRoQF7_oWCL";
        
        $environment = new SandboxEnvironment($clientId, $clientSecret);
        $client = new PayPalHttpClient($environment);


        
      // Construct a request object and set desired parameters
// Here, OrdersCreateRequest() creates a POST request to /v2/checkout/orders

$paypalrequest = new OrdersCreateRequest();
$paypalrequest->prefer('return=representation');
$paypalrequest->body = [
                     "intent" => "CAPTURE",
                     "purchase_units" => [[
                         "reference_id" => "test_ref_id1",
                         "amount" => [
                             "value" => "100.00",
                             "currency_code" => "USD"
                         ]
                     ]],
                     "application_context" => [
                          "cancel_url" => "https://example.com/cancel",
                          "return_url" => "https://example.com/return"
                     ] 
                 ];
               
try {
    // Call API with your client and get a response for your call
    $response = $client->execute($paypalrequest);

 
    
    // If call returns body in response, you can get the deserialized version from the result attribute of the response
   
}catch (HttpException $ex) {
    echo $ex->statusCode;
    print_r($ex->getMessage());
}
     

     }
     public function aa(){


        return view('products.welcome');

     }
    public function payment(Request $request)
    {
        $data = [];
        $data['items'] = [
            [
                'name' => 'ItSolutionStuff.com',
                'price' => 100,
                'desc'  => 'Description for ItSolutionStuff.com',
                'qty' => 1
            ]
        ];
      $data['invoice_id'] = 1;
        $data['invoice_description'] = "Order #{$data['invoice_id']} Invoice";
        $data['return_url'] = route('payment.success');
        $data['cancel_url'] = route('payment.cancel');
        $data['total'] = 100;
  
        $provider = new ExpressCheckout;
  
            $response = $provider->setExpressCheckout($data);
    
        $response = $provider->setExpressCheckout($data, true);
      // return redirect('http://local.pal.com');
     
     //return redirect($response['http://http://local.pal.com']);
       return redirect($response['paypal_link']);
        
    }
   
    /**
     * Responds with a welcome message with instructions
     *
     * @return \Illuminate\Http\Response
     */
    public function cancel()
    {
        dd('Your payment is canceled. You can create cancel page here.');
    }
  
    /**
     * Responds with a welcome message with instructions
     *
     * @return \Illuminate\Http\Response
     */
    public function success(Request $request)
    {
        $response = $provider->getExpressCheckoutDetails($request->token);
  
        if (in_array(strtoupper($response['ACK']), ['SUCCESS', 'SUCCESSWITHWARNING'])) {
            dd('Your payment was successfully. You can create success page here.');
        }
  
        dd('Something is wrong.');
    }
}