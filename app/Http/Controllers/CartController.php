<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CartController extends Controller
{
    //
    public function cart(){
        return view('cart');
    }

    public function add_to_cart(Request $request){
        if ($request->session()->has('cart')) {
            # code...
            $cart = $request->session()->get('cart');
            $product_array_ids = array_column($cart, 'id');
            $id = $request->input('id');
            if (!in_array($id, $product_array_ids )) {
                # code...
                $name = $request->input('name');
                $image = $request->input('image');
                $price = $request->input('price');
                $quantity = $request->input('quantity');
                $sale_price = $request->input('sale_price');

                if ($sale_price != null) {
                    # code...
                    $price_to_charge = $sale_price;
                }else{
                    $price_to_charge = $price;
                }

                $product_array = array(
                    'id' => $id,
                    'name' => $name,
                    'price' => $price_to_charge,
                    'image' => $image,
                    'quantity' => $quantity
                );

                $card[$id] = $product_array;
                $request->session()->put('cart', $cart);
              
            }else{
                echo "<script>alert('product is already in cart');</script>";
            }
        }else{

        }
    }
}
