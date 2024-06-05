<?php

namespace Modules\Product\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Product\Http\Requests\CreateCategoryRequest;
use Modules\Product\Services\CategoryService;

class CategoryController extends Controller
{
    protected $category_service;

    public function __construct(CategoryService $category_service)
    {
        $this->category_service = $category_service;
    }

    /**
     * Retrieves a category by its ID.
     * 
     * @param int $category_id The ID of the category to retrieve.
     * @return \Illuminate\Http\JsonResponse A JSON response containing the category data or an error message.
     */
    public function getCategory($category_id) 
    {
        $category = $this->category_service->getCategoryById($category_id);
        
        if (!$category) {
            return response()->json(['message' => 'Category not found'], 404);
        } 

        return response()->json($category);
    }

    /**
     * Retrieves all categories.
     * 
     * @return \Illuminate\Http\JsonResponse A JSON response containing a list of all categories or an error message.
     */
    public function getAllCategories()
    {
        $categories = $this->category_service->getAllCategories();

        if ($categories->isEmpty()) {
            return response()->json(['message' => 'Categories not found'], 404);
        } 

        return response()->json($categories);
    }

    /**
     * Creates a new category.
     * 
     * @param \Modules\Product\Http\Requests\CreateCategoryRequest $request The HTTP request containing category details.
     * @return \Illuminate\Http\JsonResponse A JSON response indicating category creation success and returning the created category.
     */
    public function create(CreateCategoryRequest $request)
    {
        $category = $this->category_service->createCategory($request->validated());

        return response()->json(['message' => 'Category successfully created', 'category' => $category], 201);
    }

    /**
     * Updates an existing category by its ID.
     * 
     * @param int $category_id The ID of the category to update.
     * @param \Illuminate\Http\Request $request The HTTP request containing updated category details.
     * @return \Illuminate\Http\JsonResponse A JSON response indicating category update success or an error message.
     */
    public function update($category_id, Request $request)
    {
        $validated_data = $request->validate([
            'name' => 'required|max:255',
        ]);

        $category = $this->category_service->updateCategory($category_id, $validated_data);

        if (!$category) {
            return response()->json(['message' => 'Category not found'], 404);
        }

        return response()->json(['message' => 'Category successfully updated'], 200);
    }

    /**
     * Deletes a category by its ID.
     * 
     * @param int $category_id The ID of the category to delete.
     * @return \Illuminate\Http\JsonResponse A JSON response indicating category deletion success or an error message.
     */
    public function delete($category_id)
    {
        $result = $this->category_service->deleteCategory($category_id);

        if (!$result) {
            return response()->json(['message' => 'Category not found'], 404);
        }

        return response()->json(['message' => 'Category successfully deleted'], 200);
    }
}
