<?php

namespace App\Http\Controllers;

use App\Models\Usuarios;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class UsuariosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $usuarios = Usuarios::all();
        return view('dashboard'); 
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('register');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
       $request->validate([
            'usuario' => 'required|string|max:255|unique:usuarios,usuario',
            'correo' => ['required', 'email', 'unique:usuarios,correo', 'regex:/^[a-zA-Z0-9._%+-]+@disfarma\.hn$/i'],
            'password' => ['required', 'string', 'min:6'],
        ], [
            'correo.regex' => 'El correo debe ser institucional (@disfarma.hn).',
        ]);

        Usuarios::create([
            'usuario' => $request->usuario,
            'correo' => $request->correo,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('login')->with('success', 'Usuario registrado exitosamente.');}

    public function showLogin()
    {
        return view('page-login');
    }


    public function login(Request $request)
    {
        $credentials = $request->validate([
            'correo' => ['required', 'email', 'regex:/^[a-zA-Z0-9._%+-]+@disfarma\.hn$/i'],
            'password' => ['required'],
        ]);

        $remember = $request->boolean('remember');

        if (Auth::attempt(['correo' => $credentials['correo'], 'password' => $credentials['password']], $remember)) {
            $request->session()->regenerate();
            return redirect()->intended(route('dashboard'));
        }

        return back()->withErrors([
            'correo' => 'Las credenciales no son válidas',
        ])->onlyInput('correo');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
