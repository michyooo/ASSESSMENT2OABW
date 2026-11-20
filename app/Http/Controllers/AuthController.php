<?php
 
namespace App\Http\Controllers;
 
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
 
class AuthController extends Controller
{
    public function showRegister()
    {
        return view('auth.register');
    }
 
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);
 
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
 
            // Password wajib di-hash
            'password' => Hash::make($validated['password']),
 
            // Jangan mengambil role dari request
            'role' => 'pemohon',
        ]);
 
        Auth::login($user);
 
        $request->session()->regenerate();
 
        return redirect()->route('dashboard');
    }
 
    public function showLogin()
    {
        return view('auth.login');
    }
 
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
 
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
 
            return redirect()->intended(route('dashboard'));
        }
 
        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }
 
    public function logout(Request $request)
    {
        Auth::logout();
 
        $request->session()->invalidate();
        $request->session()->regenerateToken();
 
        return redirect()->route('login');
    }
}
