<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();
        return view('dashboard/users', compact('users'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard/create_user');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        // Generar QR

        \QrCode::size(100)
                ->format('svg')
                ->generate($user->email, public_path('qrs\qr_' . str_replace(' ', '_', $user->name)  . '.svg'));

        // Actualizamos ruta de qR
        $user->qr = 'qr_' . str_replace(' ', '_', $user->name)  . '.svg';
        $user->save();

        return redirect()->route('user.index')
        ->with('success', 'User created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        return view('dashboard/edit_user', compact('user'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */



    public function update(Request $request, $id)
    {
        $data = [
            'name' => $request->name,
            'email' => $request->email
        ];

        User::where('id', $id)->update($data);

        $user = User::find($id);

        if ($user->qr == null) {
            \QrCode::size(100)
                ->format('svg')
                ->generate($user->email, public_path('qrs\qr_' . str_replace(' ', '_', $user->name)  . '.svg'));

            // Actualizamos ruta de qR
            $user->qr = 'qr_' . str_replace(' ', '_', $user->name)  . '.svg';
            $user->save();
        }

        return redirect()->route('user.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id)->delete();
        return redirect()->route('user.index')
        ->with('Completado', 'Usuario eliminado correctamente');
    }

    /**
     * Obtener la ruta del QR del usuario.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showqr($id){
        $user = User::find($id);

        return response()->json(['route' => $user->qr], 200);
    }

}
