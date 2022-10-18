@extends('adminlte::page')

@section('title', 'Usuarios')

@section('content_header')
    <h1>Crear Nuevo Usuario</h1>
@stop

@section('content')

<form method="POST" action="{{ route('user.store') }}">
@csrf
  <div class="mb-3">
    <label for="email" class="form-label" for="name">Nombre</label>
    <input type="name" class="form-control"id="name" name="name" type="text" :value="old('name')" required autofocus>
    
  </div>
  <div class="mb-3">
    <label for="email" class="form-label">Correo Electronico</label>
    <input type="email" class="form-control" id="email" name="email" type="text" :value="old('email')" required autofocus>
  </div>
  <div class="mb-3">
    <label for="password" class="form-label">Contraseña</label>
    <input type="password" id="password" class="form-control"
        type="password"
        name="password"
        required autocomplete="new-password" />
   </div>

   <div class="mt-4">
   <label for="password_confirmation" class="form-label"> Confirmar Contraseña</label>
   <input id="password_confirmation" class="form-control"
                 type="password"
                 name="password_confirmation" required />
    </div>
<br>
  <button type="submit" class="btn btn-success">Crear Usuario</button>
</form>



@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script> console.log('Hi!'); </script>
@stop