<?php

namespace App\Http\Controllers\Api;

use App\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
     /**
     * List categories
     *
     * @return void
     */
    public function index()
    {
        $categories = Category::latest()->paginate(10);
        return response()->json([
            "response" => [
                "status" => 200,
                "message" => "List data categories"
            ],
            "data" => $categories
        ], 200);
    }

    /**
     * Detail category
     *
     * @param string $slug
     * @return void
     */
    public function show($slug)
    {
        $category = Category::where('slug', $slug)->first();

        if ($category) {
            return response()->json([
                "response" => [
                    "status" => 200,
                    "message" => "Data Post Berdasarkan Category: " . $category->name
                ],
                "data" => $category->post()->latest()->paginate(6)
            ], 200);
        } else {
            return response()->json([
                "response" => [
                    "status" => 404,
                    "message" => "Data Post Berdasarkan Category Tidak Ditemukan"
                ],
                "data" => null
            ], 404);
        }
    }
}
