<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class PaymentsController extends Controller
{
    public function create(Order $order) {
        return view('front.payments.create',[
            'order' => $order,
        ]);
    }
}
