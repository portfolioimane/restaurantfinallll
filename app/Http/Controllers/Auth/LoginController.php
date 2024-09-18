<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }

    /**
     * Handle the post-login redirect.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function authenticated(Request $request, $user)
    {
        // Redirect based on user role
        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard'); // Redirect to admin dashboard
        } elseif ($user->role === 'driver') {
            return redirect()->route('driver.orders.index'); // Redirect to driver orders
        } elseif ($user->role === 'customer') {
            return redirect('/'); // Redirect to home page for customer
        }

        // Default redirection (optional, can be removed if all cases are handled)
        return redirect($this->redirectTo);
    }
}
