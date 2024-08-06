<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ImpersonateController extends Controller
{
    public function impersonate(User $user)
    {
        $this->middleware('permission:user');
        Auth::user()->impersonate($user);
        return jsonRedirect('dashboard.index', 'You are now impersonating ' . $user->name . '!');
    }

    public function leaveImpersonation()
    {

        if (Auth::user()->isImpersonated()) {
            Auth::user()->leaveImpersonation();
            return jsonRedirect('user.index', 'You have left impersonation mode!');
        }
    }
}
