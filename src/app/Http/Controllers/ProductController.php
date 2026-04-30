<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Season;
use Illuminate\Auth\Events\Validated;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $products = Product::paginate(6);

        return view('products.index',compact('products'));
    }

    public function search(Request $request)
    {
        $query = Product::query();

        if ($request->keyword) {
            $query->where('name', 'like', '%' . $request->keyword . '%');
        }

        if ($request->sort === 'price-asc') {
            $query->orderBy('price', 'asc');
        }

        if ($request->sort === 'price-desc') {
            $query->orderBy('price', 'desc');
        }

        $products = $query->paginate(6)->appends($request->query());

        return view('products.index', compact('products', 'request'));
    }

    public function detail($id)
    {
        $product = Product::findOrFail($id);
        return view('products.edit',compact('product'));
    }

    public function create()
    {
        $seasons = Season::all();

        if (!session()->has('errors')) {
            session()->forget(['temp_image_path', 'temp_image_name']);
            }

            return view('products.register', compact('seasons'));
    }

    public function store(StoreProductRequest $request)
    {
        $validated = $request->validated();

        if ($request->hasFile('image')) {
        $path = $request->file('image')->store('products', 'public');

        if (session('temp_image_path')) {
            Storage::disk('public')->delete(session('temp_image_path'));
            session()->forget(['temp_image_path', 'temp_image_name']);
            }

        } else {
            $tempPath = session('temp_image_path');
            $newPath = 'products/' . basename($tempPath);
            Storage::disk('public')->move($tempPath, $newPath);
            $path = $newPath;
            session()->forget(['temp_image_path', 'temp_image_name']);
            }

            $validated['image'] = $path;

            $product = Product::create($validated);

            $product->seasons()->sync($validated['season_ids']);

            return redirect()->route('products.index');
    }

    public function show($id)
    {
        $product = Product::with('seasons')->findOrFail($id);
        $seasons = Season::all();

        return view('products.edit', compact('product', 'seasons'));
    }

    public function update(UpdateProductRequest $request, Product $product)
    {
        if ($request->hasFile('image')) {
            if (session('temp_image_path')) {
                Storage::disk('public')->delete(session('temp_image_path'));
                }
                $tempPath = $request->file('image')->store('tmp', 'public');
                session([
                    'temp_image_path' => $tempPath,
                    'temp_image_name' => $request->file('image')->getClientOriginalName(),
                ]);
            }
            $validated = $request->validated();

            $product->name = $validated['name'];
            $product->price = $validated['price'];
            $product->description = $validated['description'];

            if (session('temp_image_path')) {
                $tempPath = session('temp_image_path');
                $finalPath = 'products/' . basename($tempPath);
                Storage::disk('public')->move($tempPath, $finalPath);
                session()->forget(['temp_image_path', 'temp_image_name']);

            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $product->image = $finalPath;
        }

        $product->save();
        $product->seasons()->sync($validated['season_ids']);

        return redirect()->route('products.index');
    }

    public function destroy()
    {
        $product = Product::findOrFail(request()->route('product'));
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
            }
            $product->delete();
            return redirect()->route('products.index');
    }
}
