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
            $this->calculateTotalCart($request);
            return view('cart');
        }else{
            $cart = array();
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
            $this->calculateTotalCart($request);
            return view('cart');
        }
    }


    public function remove_from_cart(Request $request){
        if ($request->session()->has('cart')) {
            # code...
            $id = $request->input('id');
            $cart = $request->session()->get('cart');
            unset($cart['id']);
            $request->session()->put('cart', $cart);
            $this->calculateTotalCart($request);
        }

        return view('cart');
    }

    public function edit_product_quantity(Request $request){
        if ($request->session()->has('cart')) {
            # code...
            $product_id = $request->input('id');
            $product_quantity = $request->input('quantity');
            if ($request->has('increase_product_quantity_btn')) {
                # code...
                $product_quantity++;
            }elseif ($request->has('decrease_product_quantity_btn')) {
                # code...
                $product_quantity--;
            }
            else {
                # code...
            }

            if ($product_quantity <= 0) {
                # code...
                $this->remove_from_cart($request);
            }
            
            $cart = $request->session()->get('cart');
            if (array_key_exists($product_id, $cart)) {
                # code...
                $card[$product_id]['quantity'] = $product_quantity;
                $request->session()->put('cart', $cart);
                $this->calculateTotalCart($request);
            }

           
        }

        return view('cart');
    }

    public function checkout(){
        return view('checkout');
    }

    public function place_order(Request $request){
        if ($request->session()->has('cart')) {

        }else{
            return redirect('/');
        }
    }

    
    public function calculateTotalCart(Request $request){
        $cart = $request->session()->has('cart');
        $total_price = 0;
        $total_quantity = 0;

        foreach ($cart as $id => $product) {
            # code...
            $product = $cart['id'];
            $price = $product['price'];
            $quantity = $product['quantity'];

            $total_price += ($price * $quantity);
            $total_quantity += $quantity;
        }

        $request->session()->put('quantity', $total_quantity);
        $request->session()->put('price', $total_price);
    }
}
