<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class AccountController extends Controller
{
    public function index(): View
    {
        return view('customer.account.index');
    }
}
