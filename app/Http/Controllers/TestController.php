<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Hash;
use \Conekta\Resource;
use \Conekta\Requestor;
use \Conekta\Util;
use \Conekta\Exceptions;
use \Conekta\Conekta;
class TestController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create_customer(){
        $validCustomer = [
            'name' => "Payment Link Name",
            'email' => "juan.perez@dominio.com"
          ];
          $customer = Customer::create($validCustomer);
    
    }
    public function create_order(){
      
    }
}
