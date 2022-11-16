@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Perfil</h1>
@stop

@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3">
                <div class="card-body box-profile">
                        <div class="text-center">
                            {!! QrCode::size(100)->generate
                            (Request::user()->email); !!}
                        </div>
                        <h3 class="profile-username text-center">{{ Auth::user()->name }}</h3>
                        <p class="text-muted text-center">{{ Auth::user()->email }}</p>
                        
                    </div>
                </div>

            <!--Menu Form -->
            <div class="col-md-9">
                    <div class="card">
                        <div class="card-header p-2">
                            <ul class="nav nav-pills">
                                
                                <li class="nav-item">
                                    <a class="nav-link" href="#pago" data-toggle="tab">
                                        Pago PayPal
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#pago2" data-toggle="tab">
                                        Pago Conekta
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#pago3" data-toggle="tab">
                                        Test
                                    </a>
                                </li>
                            </ul>                                                                               
                        </div>

                        <div class="card-body">
                            <div class="tab-content">
                                

                                <div class="tab-pane active" id="pago">                                                                                 
                                    <script src="https://www.paypal.com/sdk/js?client-id={{ env('PAYPAL_CLIENT_ID')}}&currency={{ env('PAYPAL_CURRENCY')}}"></script>
                                        
                                        <div id="paypal-button-container"></div>
                                        <script>
                                        paypal.Buttons({
                                            
                                            fundingSource: paypal.FUNDING.CARD,

                                            createOrder: (data, actions) => {
                                                return actions.order.create({
                                                    application_context: {
                                                        shipping_preference: "NO_SHIPPING"
                                                    },
                                                    payer:{
                                                        email_address:"{{ Auth::user()->email }}",
                                                        
                                                    },
                                                    purchase_units:[{
                                                        amount:{
                                                            value:'50'
                                                        }
                                                    }]
                                                    
                                                });
                                            return fetch("/paypal/process" + data.orderID, { method:post })
                                            
                                            .then((response) => response.json())
                                            .then((order) => order.id);
                                            
                                            },
                                            
                                            onApprove: (data, actions) => {
                                                console.log('data', data);
                                                console.log('actions', actions);
                                            }
                                        }).render('#paypal-button-container');
                                        </script>                                                                         
                                </div>

                                
                                <div class="tab-pane" id="pago2">  
s
                                </div>    
                                <div class="tab-pane" id="pago3">
                                
                                <form id="card-form">
                                    
                                    <input type="hidden" name="conektaTokenId" id="conektaTokenId" value="">

                                    <div class="card">
                                        <div class="card-header">
                                            <div class="row display-tr">
                                                <h3>Pago en línea</h3>

                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label>
                                                        Nombre del tarjetahabiente
                                                    </label>
                                                    <input value="Juan Ramirez Ledesma" data-conekta="card[name]" class="form-control" name="name" id="name"  type="text" >
                                                </div>
                                                <div class="col-md-6">
                                                        <label>
                                                            Número de tarjeta
                                                        </label>
                                                        <input value="4242424242424242" name="card" id="card" data-conekta="card[number]" class="form-control"   type="text" maxlength="16" >
                                                </div>
                                            </div>

                                            <div class="row">
                                                    <div class="col-md-6">
                                                        <label>
                                                            CVC
                                                        </label>
                                                        <input value="399" data-conekta="card[cvc]" class="form-control"  type="text" maxlength="4" >
                                                    </div>
                                                    <div class="col-md-6">
                                                            <label>
                                                                Fecha de expiración (MM/AA)
                                                            </label>
                                                            <div>
                                                                <input style="width:50px; display:inline-block" value="11" data-conekta="card[exp_month]" class="form-control"  type="text" maxlength="2" >
                                                                <input style="width:50px; display:inline-block" value="20" data-conekta="card[exp_year]" class="form-control"  type="text" maxlength="2" >

                                                            </div>
                                                    </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <label><span>Email</span></label>
                                                    <input class="form-control" type="text" name="email" id="email" maxlength="200" value="lir@gmail.com">
                                                </div>
                                                <div class="col-md-4">
                                                    <label>Concepto</label>
                                                    <input class="form-control" type="text" name="description" id="description" maxlength="100" value="producto1">
                                                </div>
                                                <div class="col-md-4">
                                                    <label>Monto</label>
                                                    <input class="form-control" type="number" name="total" id="total" value="30">
                                                </div>
                                            
                                            </div>
                                            <br>
                                            <div class="row">
                                                    <div class="col-md-12" style="text-align:center;">
                                                    <button class="btn btn-success btn-lg">
                                                        <i class="fa fa-check-square"></i> PAGAR
                                                    </button>
                                                    </div>
                                                
                                            </div>

                                        </div>
                                    </div>
                                
                                    
                                </form>                                                                
                                </div>
                                    
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
    
@stop

@section('js')
    <script> console.log('Hi!'); </script>
    <script type="text/javascript">
            jQuery(function($) {
                
                
                var conektaSuccessResponseHandler;
                conektaSuccessResponseHandler = function(token) {
                    var $form;
                    $form = $("#card-form");

                    /* Inserta el token_id en la forma para que se envíe al servidor */
                    $form.append($("<input type=\"hidden\" name=\"conektaTokenId\" />").val(token.id));

                    /* and submit */
                    $form.get(0).submit();
                };
                
                conektaErrorResponseHandler = function(token) {
                    console.log(token);
                };
                
                $("#card-form").submit(function(event) {
                    event.preventDefault();
                    var $form;
                    $form = $(this);

                    /* Previene hacer submit más de una vez */
                    $form.find("button").prop("disabled", true);
                    Conekta.token.create($form, conektaSuccessResponseHandler, conektaErrorResponseHandler);
                    /* Previene que la información de la forma sea enviada al servidor */
                    return false;
                });

            });

        </script>
@stop