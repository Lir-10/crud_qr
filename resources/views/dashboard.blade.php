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
                            <b>Usuario registrado desde: </b> <a class="float-right">{{ Auth::user()->created_at }}</a>
                        </li>

                    </div>
                </div>
                <div class="col-md-9">
                    <div class="card">
                        <div class="card-header p-2">
                            <ul class="nav nav-pills">
                                <li class="nav-item"><a class="nav-link active" href="#settings" data-toggle="tab">Ajustes</a></li>
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
                      </div>
                     </div>
                 </div>
            </div>
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script> console.log('Hi!'); </script>
@stop