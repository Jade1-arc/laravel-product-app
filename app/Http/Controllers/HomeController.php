<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Show the application homepage.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $query = Product::with('category');
        
        // Category filter
        if ($request->has('category_id') && $request->category_id != '') {
            $query->where('category_id', $request->category_id);
        }
        
        $products = $query->latest()->paginate(12);
        $categories = Category::all();
        
        return view('home', compact('products', 'categories'));
    }

    /**
     * Show user dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function dashboard()
    {
        $user = auth()->user();
        $totalProducts = Product::count();
        $totalCategories = Category::count();
        
        return view('dashboard', compact('user', 'totalProducts', 'totalCategories'));
    }
}
