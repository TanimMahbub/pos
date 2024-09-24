<?php

namespace App\Http\Controllers;
use App\Models\Product;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    function ProductPage():View {
        return view('pages.dashboard.product-page');
    }

    function ProductCreate(Request $request) {}
    function ProductList(Request $request) {}
    function ProductByID(Request $request) {}
    function ProductDelete(Request $request) {}
    function ProductUpdate(Request $request) {}
}
