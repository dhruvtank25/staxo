<?php

namespace App\Http\Controllers;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File; 
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $products = Product::all();
            return view('product.index', ['products' => $products]);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('product.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Product $product)
    {
        try{
            $request->validate([
                'name' => 'required',
                'price' => 'required',
                'image' => 'required'
            ]);
            $data = $request->all();
            if($request->file('image'))
            {
                $name = time().'.'.$request->file('image')->getClientOriginalExtension();
                $file = $request->file('image');
                ($file->move(public_path('uploads/product'), $name));
                $data['image'] = $name;
            }
            $result = Product::saveProduct($data);
    
            return redirect()->route('products.index')->with('success','Product updated successfully');
        } catch (\Exception $e) {
            return $e->getMessage();
        }

       
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            if($id){
                $product = Product::findOrFail($id);
                $hearder = "Product Details";
                return view('product.show',compact('product','hearder'));
            }  
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

     /**
     * Product listing page.
     */
    public function product_list()
    {
        try {
            $products = Product::all();
            return view('dashboard', ['products' => $products]);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        try {
            if($id)
            {
                $product = Product::findOrFail($id);
                $hearder = "Edit Product";
                return view('product.edit',compact('product','hearder'));
            }
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try{
            $request->validate([
                'name' => 'required',
                'price' => 'required',
            ]);
            $data = $request->all();
            
            $product = Product::findOrFail($id);
            if($request->file('image'))
            {
                // deleting old file
                if($product->image){
                    if(File::exists(public_path('uploads/product/'.$product->image))){
                        $result = File::delete(public_path('uploads/product/'.$product->image));
                    }
                }
                $name = time().'.'.$request->file('image')->getClientOriginalExtension();
                $file = $request->file('image');
                ($file->move(public_path('uploads/product'), $name));
                $data['image'] = $name;
            }
            $result = Product::updateProduct($data,$id);
            return redirect()->route('products.index')->with('success','Product updated successfully');
        }catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        try{
            //deleting image from directory
            if($product->image){
                if(File::exists(public_path('uploads/product/'.$product->image))){
                    $result = File::delete(public_path('uploads/product/'.$product->image));
                }
            }
            $product->delete();
            return redirect()->route('products.index')->with('success','Product deleted successfully');
        }catch (\Exception $e) {
            return $e->getMessage();
        }
    }


    /**
     * checkout function
     */
    public function checkout(Request $request)
    {
        try{
            $data = $request->all();
            $stripe = new \Stripe\StripeClient('sk_test_26PHem9AhJZvU623DfE1x4sd');
            
            $intpart = intval(($data['product_price']*100).'');
     
            $checkout_session = $stripe->checkout->sessions->create([
            'line_items' => [[
                    'price_data' => [
                    'currency' => 'GBP',
                    'product_data' => [
                        'name' =>$data['product_name'],
                    ],
                    'unit_amount' => $intpart,
                    ],
                    'quantity' => 1,
                ]],
                'mode' => 'payment',
                'success_url' => url('/paymentSuccess'),
                'cancel_url' => url('/paymentCancel'),
            ]);
            return Redirect::to($checkout_session->url);
        }catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function payment_success(Request $request){
        print_r("Thank you");
    }
}
