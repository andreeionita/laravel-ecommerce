<?php

namespace App\Http\Controllers;

use App\Category;
use App\Http\Requests\StoreProduct;
use App\Product;
use App\Cart;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::all();
        return view('admin.products.index' , compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        return view('admin.products.create' , compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProduct $request)
    {
        
    //     $path = 'images/no-thumbnail.jpeg';
    //   if($request->has('thumbnail')){
    //    $extension = ".".$request->thumbnail->getClientOriginalExtension();
    //    $name = basename($request->thumbnail->getClientOriginalName(), $extension).time();
    //    $name = $name.$extension;
    //    $path = $request->thumbnail->storeAs('images', $name, 'public');
    //  }

     if($request->hasFile('thumbnail')){ 
        $image = $request->file('thumbnail');
        $new_name = rand() . '.' . $image->getClientOriginalExtension();
        $image->move('admin/upload/', $new_name);
        $thumbnail = 'admin/upload/'.$new_name;

        }else{
            $thumbnail = null;
        }
            
        $product = Product::create([
            'title'=>$request->title,
            'slug'=>$request->slug,
            'status'=>$request->status,
            'options' => isset($request->extras) ? json_encode($request->extras) : null,
            'description'=>$request->description,
            'thumbnail'=>$thumbnail,
            'featured' => ($request->featured) ? $request->featured : 0,
            'price'=>$request->price,
            'discount'=>($request->discount) ? $request->discount : 0,
            'discount_price' => ($request->discount_price) ? $request->discount_price : 0
        ]);
        if($product){
            $product->categories()->attach($request->category_id);
            return back()->with('message', 'Product Successfully Added');
       }else{
            return back()->with('message', 'Error Inserting Product');
       }
    }

    /**
     * Display the cart.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function cart()
    {
        if(!Session::has('cart')){
            return view('products.cart');
        }
        $cart = Session::get('cart');
        // dd($cart);
        return view('products.cart', compact('cart'));  
    }
    /**
     * Display the cart.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function removeProduct($product)
    {
        // dd($product);
        $oldCart = Session::has('cart') ? Session::get('cart') : null;
      $cart = new Cart($oldCart);
      $cart->removeProduct($product);
      Session::put('cart', $cart);
      return back()->with('message', "Product $product has been successfully removed From the Cart");
    }
    /**
     * Display the cart.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    // public function updateProduct($product , Request $request)
    // {
    //     // dd($product);
    //     $oldCart = Session::has('cart') ? Session::get('cart') : null;
    //   $cart = new Cart($oldCart);
    //   $cart->updateProduct($request , $request->qty);
    //   Session::put('cart', $cart);
    //   return back()->with('message', "Product $product has been successfully updated in the Cart");
    // }
    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        // dd(Session::get('cart'));
        $categories = Category::all();
        $products = Product::paginate(2);
        return view('products.all' , compact('categories' , 'products'));    
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function single(Product $product)
    {
        return view('products.single' , compact('product'));    
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('admin.products.create' , compact('product' , 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        if($request->hasFile('thumbnail')){ 
            $image = $request->file('thumbnail');
            $new_name = rand() . '.' . $image->getClientOriginalExtension();
            $image->move('admin/upload/', $new_name);
            $thumbnail = 'admin/upload/'.$new_name;
    
        }else{
            $thumbnail = null;
        }

        $product->title = $request->title;
        $product->slug =$request->slug;
        $product->status =$request->status;
        $product->description =$request->description;
        $product->thumbnail = $thumbnail;
        $product->featured = ($request->featured) ? $request->featured : 0;
        $product->price =$request->price;
        $product->discount =($request->discount) ? $request->discount : 0;
        $product->discount_price = ($request->discount_price) ? $request->discount_price : 0;


        $product->categories()->detach();
        
        if($product->save()){
            $product->categories()->attach($request->category_id);
            return back()->with('message' , 'Product Updated Successfully');
        } else {
            return back()->with('message' , 'Error Updating Product');
        }
    }

     /**
     * Recover the specified resource from storage.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function recover($id)
    {
        $product = Product::withTrashed()->findOrFail($id);
        if($product->restore()){   
            return back()->with('message' , 'Product Sussessfully Recovered');
        } else {
        return back()->with('message' , 'Error Recovering Record');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        if($product->categories()->detach() && $product->forceDelete()){   
            Storage::delete($product->thumbnail);
            return back()->with('message' , 'Record Sussessfully Deleted');
        } else {
        return back()->with('message' , 'Error Deleting Record');
        }
    }

      /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function remove(Product $product)
    {
        if($product->delete()){
            return back()->with('message' , 'Record Sussessfully Trashed');
        } else {
        return back()->with('message' , 'Error Deleting Record');
        }
    }

    /**
     * Display Trashed listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function trash()
    {
        $products = Product::onlyTrashed()->paginate(3);
        return view('admin.products.index', compact('products'));
    }

    /**
     * Display Trashed listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function addToCart(Product $product , Request $request)
    {
        $oldCart = Session::has('cart') ? Session::get('cart') : null;
        $qty = $request->qty ? $request->qty : 1;
        $cart = new Cart($oldCart);
        $cart->addProduct($product , $qty);
        Session::put('cart' , $cart);
        return back()->with('message' , "Product $product->title has been succesfully added to cart");
    }


}
