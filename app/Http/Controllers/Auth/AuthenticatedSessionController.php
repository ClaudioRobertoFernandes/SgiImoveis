<?php

namespace App\Http\Controllers\Auth;

use App\Helpers\Consts;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Filament\Notifications\Notification;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $permited = User::isPermited($request->email);

        if ($permited['permited'] === 2) {


            $request->authenticate();

            $request->session()->regenerate();

            Auth::logoutOtherDevices($request->password);

            return redirect()->intended(RouteServiceProvider::HOME);
        }

        if ($permited['permited'] === 1){

            Notification::make()
                ->title('Ação não permitida')
                ->icon('heroicon-o-x-circle')
                ->iconColor('danger')
                ->send();
        }

        if ($permited['permited'] === 0){

            Notification::make()
                ->title('Usuário não cadastrado')
                ->icon('heroicon-o-x-circle')
                ->iconColor('danger')
                ->send();
        }

        return redirect('login');
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('welcome');
    }
}
