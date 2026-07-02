<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class EmailVerificationNotificationController extends Controller
{
    /**
     * Send a new email verification notification.
     */
    public function store(Request $request): RedirectResponse
    {
        $route = in_array($request->user()->role, ['super_admin', 'admin_kantor', 'kasir'])
            ? 'admin.dashboard'
            : 'dashboard';

        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->intended(route($route, absolute: false));
        }

        $request->user()->sendEmailVerificationNotification();

        return back()->with('status', 'verification-link-sent');
    }
}
