<?php

namespace App\Repositories;

use App\Models\Admin\Category;
use App\Repositories\Interfaces\CategoryRepositoryInterface;

class CategoryRepository implements CategoryRepositoryInterface
{
    public function allCategory()
    {
        return Category::with('children.children.children.children.children.children.children.children.children.children')->latest('id')->get();
    } 

    // public function storeCategory(array $data)
    // {
    //     return Category::create($data);
    // }

    public function findCategory(int $id)
    {
        return Category::findOrFail($id);
    }

    // public function updateCategory(array $data, int $id)
    // {
    //     return Category::findOrFail($id)->update($data);
    // }

    public function destroyCategory(int $id)
    {
        return Category::destroy($id);
    }
    public function paginateCategories(int $perPage)
{
    return Category::with('parent')->orderBy('id', 'desc')->paginate($perPage);
}



public function updateCategory(array $data, int $id)
{
    $category = Category::findOrFail($id);

    // Ensure is_parent is 0 or 1
    $data['is_parent'] = isset($data['is_parent']) ? 1 : 0;

    return $category->update($data);
}

public function storeCategory(array $data)
{
    $data['is_parent'] = isset($data['is_parent']) ? 1 : 0;

    return Category::create($data);
}

}
