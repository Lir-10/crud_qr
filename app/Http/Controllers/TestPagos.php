<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Conekta\Conekta;
use ConektaCheckoutComponents;
use Conekta\Checkout;
use App\Models\User;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Hash;

class TestPagos extends Controller
{   
  private $client;
  private $clientId;
  private $secret;
  
      public function __construct()
      {
          $this->client = new Client([
              // 'base_uri' => 'https://api-m.paypal.com'
              'base_uri' => 'https://api-m.sandbox.paypal.com'
          ]);
      
          $this->clientId = env('PAYPAL_CLIENT_ID');
          $this->secret = env('PAYPAL_SECRET');
      }
      
      private function getAccessToken(){

        $response = $this->client->request('POST', '/v1/oauth2/token', [
          'headers' => [
              'Accept' => 'application/json',
              'Content-Type' => 'application/x-www-form-urlencoded',
          ],
          'body' => 'grant_type=client_credentials',
          'auth' => [
              $this->clientId, $this->secret, 'basic'
            ]
        ]
     );

    $data = json_decode($response->getBody(), true);
    return $data['access_token'];
}



      public function process($orderId, Request $request)
      {
          $accessToken = $this->getAccessToken();
      
          $requestUrl = "/v2/checkout/orders/$orderId/capture";
      
          $response = $this->client->request('POST', $requestUrl, [
              'headers' => [
                  'Accept' => 'application/json',
                  'Content-Type' => 'application/json',
                  'Authorization' => "Bearer $accessToken"
              ]
          ]);
      
          $data = json_decode($response->getBody(), true);
      
          dd($data);
          // ...

          if ($data['status'] === 'COMPLETED') {
           
        
            // Obtener el paymentId y el monto pagado, de $data
            $payPalPaymentId = $data['purchase_units'][0]['payments']['captures'][0]['id'];
            $amount = $data['purchase_units'][0]['payments']['captures'][0]['amount']['value'];
        
            // Registrar un pago exitoso en la BD
            $payment = $this->registerSuccessfulPayment($solution, $amount, $payPalPaymentId);
        
            // Dar una respuesta de error si el pago no se pudo registrar
            if (!$payment) {
                return $this->responseFailure();
            }
        
            // Dar una respuesta de éxito si todo salió bien
            return [
                'success' => true,
                'url' => "dashboard/sucess",
                'payment_id' => $payment->id,
                'amount' => $amount
            ];
        }
        
        // Dar una respuesta de error si el status no es COMPLETED
        return $this->responseFailure();
      }



    /*public function Validate(){
        if($this->card=="" || $this->name=="" || $this->description=="" || $this->total=="" ||)
    }
    */

/*    public function payment() {
        Conekta::setApiKey("key_g3lldWl93zu3kUIc1hFFu7j");
        try {
            $charge = Conekta_Charge::create(array(
            "amount" => 5000,
            "currency" => "MXN",
            "description" => "CPMX5 Payment",
            "reference_id"=> "orden_de_id_interno",
            "card" => $_POST['conektaTokenId'] //"tok_a4Ff0dD2xYZZq82d9"
            ));
        } catch (Conekta_Error $e) {
           return View::make('payment',array('message'=>$e->getMessage()));
        }
        
        return View::make('payment',array('message'=>$charge->status));
        
    }
    */

}
