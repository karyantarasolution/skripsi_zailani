<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EmailVerificationPromptController extends Controller
{
    /**
     * Display the email verification prompt.
     */
    public function __invoke(Request $request): RedirectResponse|View
    {
        $route = in_array($request->user()->role, ['super_admin', 'admin_kantor', 'kasir'])
            ? 'admin.dashboard'
            : 'dashboard';

        return $request->user()->hasVerifiedEmail()
                    ? redirect()->intended(route($route, absolute: false))
                    : view('auth.verify-email');
    }
}
