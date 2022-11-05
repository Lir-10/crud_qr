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
                        <ul class="list-group list-group-unbordered mb-3">
                            <li class="list-group-item">
                                <b>Usuario registrado desde: </b> 
                                <a class="float-right">{{ Auth::user()->created_at }}</a>
                            </li>
                        </ul>
                    </div>
                </div>

            <!--Menu Form -->
            <div class="col-md-9">
                    <div class="card">
                        <div class="card-header p-2">
                            <ul class="nav nav-pills">
                                <li class="nav-item">
                                    <a class="nav-link active" href="#settings" data-toggle="tab">
                                        Ajustes
                                    </a>
                                </li>

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
                            </ul>                                                                               
                        </div>

                        <div class="card-body">
                            <div class="tab-content">
                                <div class="tab-pane active" id="settings">
                                    <form class="form-horizontal" action="{{ route('user.update', Auth::user()->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="form-group row">
                                            <label for="inputName" class="col-sm-2 col-form-label">Nombre</label>
                                            <div class="col-sm-10">
                                                <input type="name" class="form-control" id="name" placeholder="{{ Auth::user()->name }}"  required>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="inputEmail" class="col-sm-2 col-form-label">Correo</label>
                                            <div class="col-sm-10">
                                                <input type="email" class="form-control" id="email" placeholder="{{ Auth::user()->email }}" required>
                                            </div>
                                        </div>                                       
                                        <div class="form-group row">
                                            <div class="offset-sm-2 col-sm-10">
                                                <div class="checkbox">
                                                    <label>
                                                        <input type="checkbox"> I agree to the <a href="#">terms and conditions</a>
                                                    </label>
                                                 </div>
                                            </div>
                                        </div>
                                       <div class="form-group row">
                                           <div class="offset-sm-2 col-sm-10">
                                               <button type="submit" class="btn btn-danger">Guardar</button>
                                             </div>
                                        </div>
                                   </form>
                                </div>

                                <div class="tab-pane" id="pago">                                                                                 
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
                                    <script src="https://pay.conekta.com/v1.0/js/components.js"></script>
                                    <conekta-button 
                                        locale="es"
                                        size="medium" 
                                        border="rounded" 
                                        color="snowberry" 
                                        logoConekta="show" 
                                        checkoutId="21994fc0acb34d529e7e0a0b2667d67d">
                                    </conekta-button>
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
@stop