<?php
use illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

Route::middleware('auth')->group(function(){
    Route::get('products', function() {
        $products = Product::orderBy('created_at','desc')->get();
        return view('products.index',compact('products'));
    })->name('products.index');
    
    Route::get('products/create', function() {
        return view('products.create');
    })->name('products.create');
    
    Route::post('products', function(Request $request) {
        $newProduct = new Product();
        $newProduct->description = $request->input('description');
        $newProduct->price = $request->input('price');
        $newProduct->save();
    
        return redirect()->route('products.index')->with('info','Producto creado exitosamente');
    })->name('products.store');
    
    Route::delete('products/{id}', function($id) {
        $product = Product::findOrFail($id);
        $product->delete();
        return redirect()->route('products.index')->with('info','Producto eliminado exitosamente');
    })->name('products.delete');
    
    Route::get('products/{id}/edit', function($id) {
        $product = Product::findOrFail($id);
        return view('products.edit',compact('product'));
    })->name('products.edit');
    
    Route::put('/products/{id}',function(Request $request,$id){
        $product = Product::findOrFail($id);
        $product->description = $request->input('description');
        $product->price = $request->input('price');
        return redirect()->route('products.index')->with('info','Producto Actualizado correctamente');
    }) ->name('products.update');
    
});


Auth::routes();
