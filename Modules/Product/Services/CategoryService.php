<?php

namespace Modules\Product\Services;

use Modules\Product\Entities\Category;

class CategoryService
{
    /**
     * Retrieves a category by its ID.
     * 
     * @param int $category_id
     * @return Category|null
     */
    public function getCategoryById(int $category_id): ?Category
    {
        return Category::find($category_id);
    }

    /**
     * Retrieves all categories.
     * 
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAllCategories()
    {
        return Category::all();
    }

    /**
     * Creates a new category.
     * 
     * @param array $data
     * @return Category
     */
    public function createCategory(array $data): Category
    {
        return Category::create($data);
    }

    /**
     * Updates an existing category by its ID.
     * 
     * @param int $category_id
     * @param array $data
     * @return Category|null
     */
    public function updateCategory(int $category_id, array $data): ?Category
    {
        $category = Category::find($category_id);

        if (!$category) {
            return null;
        }

        $category->update($data);

        return $category;
    }

    /**
     * Deletes a category by its ID.
     * 
     * @param int $category_id
     * @return bool
     */
    public function deleteCategory(int $category_id): bool
    {
        $category = Category::find($category_id);

        if (!$category) {
            return false;
        }

        $category->delete();

        return true;
    }
}
