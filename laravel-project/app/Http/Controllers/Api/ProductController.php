<?php

namespace App\Http\Controllers\Api;

use App\Models\Size;
use App\Models\Brand;
use App\Models\Color;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;

class ProductController extends Controller
{
    /**
     * Get All the products
     */
    public function index()
    {
        return ProductResource::collection(Product::with(['colors', 'sizes', 'category', 'brand'])->latest()->get())->additional([
            'colors' => Color::has('products')->get(),
            'sizes' => Size::has('products')->get(),
            'brands' => Brand::has('products')->get(),
            'categories' => Category::has('products')->get(),
        ]);
    }

    /**
     * Get products by slug
     */
    public function show(Product $product)
    {
        if (!$product) {
            abort(404);
        }

        return ProductResource::make($product->load(['colors', 'sizes', 'reviews', 'category', 'brand']));
    }

    /**
     * Fillter the products by category
     */
    public function filterProductByCategory(Category $category)
    {
        return ProductResource::collection($category->products()->with(['colors', 'sizes', 'category', 'brand'])->latest()->get())->additional([
            'colors' => Color::has('products')->get(),
            'sizes' => Size::has('products')->get(),
            'brands' => Brand::has('products')->get(),
            'categories' => Category::has('products')->get(),
            'filter' => $category->name
        ]);
    }

    /**
     * Fillter the products by Brand
     */
    public function filterProductByBrand(Brand $brand)
    {
        return ProductResource::collection($brand->products()->with(['colors', 'sizes', 'category', 'brand'])->latest()->get())->additional([
            'colors' => Color::has('products')->get(),
            'sizes' => Size::has('products')->get(),
            'brands' => Brand::has('products')->get(),
            'categories' => Category::has('products')->get(),
            'filter' => $brand->name
        ]);
    }

    /**
     * Fillter the products by Color
     */
    public function filterProductByColor(Color $color)
    {
        return ProductResource::collection($color->products()->with(['colors', 'sizes', 'category', 'brand'])->latest()->get())->additional([
            'colors' => Color::has('products')->get(),
            'sizes' => Size::has('products')->get(),
            'brands' => Brand::has('products')->get(),
            'categories' => Category::has('products')->get(),
            'filter' => $color->name
        ]);
    }

    /**
     * Fillter the products by Size
     */
    public function filterProductBySize(Size $size)
    {
        return ProductResource::collection($size->products()->with(['colors', 'sizes', 'category', 'brand'])->latest()->get())->additional([
            'colors' => Color::has('products')->get(),
            'sizes' => Size::has('products')->get(),
            'brands' => Brand::has('products')->get(),
            'categories' => Category::has('products')->get(),
            'filter' => $size->name
        ]);
    }


    /**
     * Fillter the products by term
     */
    public function filterProductByTerm($searchTerm)
    {
        return ProductResource::collection(Product::where('name', 'like', '%' . $searchTerm . '%')->with(['colors', 'sizes', 'category', 'brand'])->latest()->get())->additional([
            'colors' => Color::has('products')->get(),
            'sizes' => Size::has('products')->get(),
            'brands' => Brand::has('products')->get(),
            'categories' => Category::has('products')->get(),
        ]);
    }
}
