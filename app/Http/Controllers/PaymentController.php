<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function allPayemnt(){

        $payments = Payment::all();
        return Inertia::render('admin/payments/all-payments', [
            'payments' => $payments,
        ]);
    }
}
