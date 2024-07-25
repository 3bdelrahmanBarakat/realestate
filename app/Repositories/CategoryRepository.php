<?php


namespace App\Repositories;

use App\Http\Controllers\API\Traits\APIResponse;
use App\Http\Controllers\API\Traits\ImageUploader;
use App\Interfaces\CategoryInterface;
use App\Models\Category;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Pipeline;

class CategoryRepository implements CategoryInterface
{
    use APIResponse, ImageUploader;


    public function all()
    {
        $category = Pipeline::send(Category::query())
            ->through([])
            ->thenReturn()
            ->select("id", "name", "image")
            ->get();

        return $category;
    }

    public function show(int|string $id)
    {
        $category = $this->find($id);
        return $category;
    }

    public function update(array $data, int|string $id): Category
    {
        $category = $this->find($id);

        $image = $this->checkForImageExistence($data, $category);

        $category->update([
            "name" => $data["name"],
            'image' => $image,
        ]);

        return $category;
    }

    public function store(array $data): Category
    {

        $image = $this->uploadImage($data, "image", "public/uploads/categories");

        $category = Category::create([
            "name" => $data["name"],
            'image' => $image,
        ]);

        return $category;
    }

    public function delete(int|string $id): void
    {
        $category = $this->find($id);
        $this->removeImage("public/uploads/categories", $category->image);
        $category->delete();
    }

    public function find(int|string $id): Category
    {

        $category = Category::where("id", $id)->first();

        if (!$category) {
            throw new HttpResponseException($this->error(404, "There is no category with the given id:{$id}", []));
        }
        return $category;
    }

    public function checkForImageExistence(array $data, Category $category): string
    {
        if (empty($data['image'])) {
            return $category->image;
        }

        $image = $this->uploadImage($data, "image", "public/uploads/categories");

        $this->removeImage("public/uploads/categories", $category->image);

        return $image;
    }
}
