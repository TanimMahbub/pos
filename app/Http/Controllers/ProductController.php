<?php

namespace App\Http\Controllers;
use App\Models\Product;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    function ProductPage():View {
        return view('pages.dashboard.product-page');
    }

    function ProductList(Request $request) {
        $user_id = $request->header('id');
        return Product::where('user_id', $user_id)->get();
    }

    function ProductCreate(Request $request) {
        $user_id = $request->header('id');
        $category_id = $request->input('category_id');

        $img = $request->file('img');
        $t = time();
        $file_name = $img->getClientOriginalName();
        $img_name = "{$user_id}-{$t}-{$file_name}";
        $img_url = "uploads/{$img_name}";
        $img->move(public_path('uploads'), $img_name);

        return Product::create([
            'name' => $request->input('name'),
            'price' => $request->input('price'),
            'unit' => $request->input('unit'),
            'img_url' => $img_url,
            'category_id' => $category_id,
            'user_id' => $user_id
        ]);
    }

    function ProductByID(Request $request) {
        $user_id = $request->header('id');
        $product_id = $request->input('id');
        return Product::where('id', $product_id)->where('user_id', $user_id)->first();
    }

    function ProductDelete(Request $request) {
        $user_id = $request->header('id');
        $product_id = $request->input('id');
        $filePath = $request->input('file_path');
        File::delete($filePath);
        return Product::where('id', $product_id)->where('user_id', $user_id)->delete();
    }

    function ProductUpdate(Request $request) {
        $user_id = $request->header('id');
        $product_id = $request->input('id');
        $category_id = $request->input('category_id');

        if($request->hasFile('img')) {
            $img = $request->file('img');
            $t = time();
            $file_name = $img->getClientOriginalName();
            $img_name = "{$user_id}-{$t}-{$file_name}";
            $img_url = "uploads/{$img_name}";
            $img->move(public_path('uploads'), $img_name);
            $filePath = $request->input('file_path');
            File::delete($filePath);

            return Product::where('id', $product_id)->where('user_id', $user_id)->update([
                'name' => $request->input('name'),
                'price' => $request->input('price'),
                'unit' => $request->input('unit'),
                'img_url' => $img_url,
                'category_id' => $category_id,
            ]);
        }else {
            return Product::where('id', $product_id)->where('user_id', $user_id)->update([
                'name' => $request->input('name'),
                'price' => $request->input('price'),
                'unit' => $request->input('unit'),
                'category_id' => $category_id,
            ]);
        }
    }
}
