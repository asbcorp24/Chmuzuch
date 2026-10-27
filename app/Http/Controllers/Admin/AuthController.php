<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
class AuthController extends Controller {
 public function login(): View {return view('admin.login');}
 public function authenticate(Request $r): RedirectResponse {$credentials=$r->validate(['email'=>'required|email','password'=>'required|string']);if(Auth::attempt($credentials,$r->boolean('remember'))){$r->session()->regenerate();return redirect()->intended(route('admin.dashboard'));}return back()->withErrors(['email'=>'Неверный e-mail или пароль.'])->onlyInput('email');}
 public function logout(Request $r): RedirectResponse {Auth::logout();$r->session()->invalidate();$r->session()->regenerateToken();return redirect()->route('admin.login');}
}