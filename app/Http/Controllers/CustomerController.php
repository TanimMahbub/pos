<?php

namespace App\Http\Controllers;
use App\Models\Customer;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    function CustomerPage():View {
        return view('pages.dashboard.customer-page');
    }

    function CategoryCreate(Request $request) {
        $user_id = $request->header('id');
        return Customer::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'mobile' => $request->input('mobile'),
            'user_id' => $user_id
        ]);
    }

    function CategoryList(Request $request) {
        $user_id = $request->header('id');
        return Customer::where('user_id', $user_id)->get();
    }

    function CategoryByID(Request $request) {}

    function CategoryDelete(Request $request) {}

    function CategoryUpdate(Request $request) {}
}
