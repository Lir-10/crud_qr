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
                                    <script src="https://www.paypal.com/sdk/js?client-id=AZTLHy4blP-oJB7i1RT1cJ8fefNGbXjbZW5DYI09XJ_zxZ5d_UFLwR2Exerg0pg_2haDAbd7UusI6wrP"></script>
                                        <!-- Set up a container element for the button -->
                                        <div id="paypal-button-container"></div>
                                        <script>
                                        paypal.Buttons({
                                            // Order is created on the server and the order id is returned
                                            createOrder: (data, actions) => {
                                                return actions.order.create({
                                                    purchase_units:[{
                                                        amount:{
                                                            value:'50'
                                                        }
                                                    }]
                                                });
                                            return fetch("/api/orders", {
                                                method: "post",
                                                // use the "body" param to optionally pass additional order information
                                                // like product ids or amount
                                            })
                                            .then((response) => response.json())
                                            .then((order) => order.id);
                                            },
                                            // Finalize the transaction on the server after payer approval
                                            onApprove: (data, actions) => {
                                            return fetch(`/api/orders/${data.orderID}/capture`, {
                                                method: "post",
                                            })
                                            .then((response) => response.json())
                                            .then((orderData) => {
                                                // Successful capture! For dev/demo purposes:
                                                console.log('Capture result', orderData, JSON.stringify(orderData, null, 2));
                                                const transaction = orderData.purchase_units[0].payments.captures[0];
                                                alert(`Transaction ${transaction.status}: ${transaction.id}\n\nSee console for all available details`);
                                                // When ready to go live, remove the alert and show a success message within this page. For example:
                                                // const element = document.getElementById('paypal-button-container');
                                                // element.innerHTML = '<h3>Thank you for your payment!</h3>';
                                                // Or go to another URL:  actions.redirect('thank_you.html');
                                            });
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
                                    
                                    <script>
                                        Conekta.setPublicKey("key_EkPdspW48AMiqMXnbKBFuHz");
                                        
                                        var conektaSuccessResponseHandler= function(token){                                        
                                            $("#conektaTokenId").val(token.id);                                        
                                            jsPay();
                                        };
                                        var conektaErrorResponseHandler =function(response){
                                            var $form=$("#card-form");
                                            alert(response.message_to_purchaser);
                                        }
                                        $(document).ready(function(){
                                            $("#card-form").submit(function(e){
                                                e.preventDefault();                                            
                                                var $form=$("#card-form");
                                                Conekta.Token.create($form,conektaSuccessResponseHandler,conektaErrorResponseHandler);
                                            })
                                            
                                        })

                                        function jsPay(){
                                            let params=$("#card-form").serialize();
                                            let url="pay.php";                                        
                                            $.post(url,params,function(data){
                                                if(data=="1"){
                                                    alert("Se realizo el pago :D");
                                                    jsClean();
                                                }else{
                                                    alert(data)
                                                }
                                            
                                            })

                                        }

                                        function jsClean(){
                                            $(".form-control").prop("value","");
                                            $("#conektaTokenId").prop("value","");
                                        }
                                    </script>
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