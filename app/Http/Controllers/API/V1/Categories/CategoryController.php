<?php

namespace App\Http\Controllers\API\V1\Categories;

use App\Http\Controllers\API\Traits\APIResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\Category\StoreRequest;
use App\Http\Requests\API\V1\Category\UpdateRequest;
use App\Http\Resources\API\V1\Category\CategoryResource;
use App\Interfaces\CategoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    use APIResponse;

    public function __construct(public CategoryInterface $CategoryInterface)
    {
    }

    public function all()
    {
        $categories = $this->CategoryInterface->all();
        return $this->success(200, "categories", CategoryResource::collection($categories));
    }

    public function show(int|string $id)
    {
        $category = $this->CategoryInterface->show($id);
        return $this->success(200, "category", CategoryResource::make($category));
    }

    public function update(UpdateRequest $request, int|string $id): JsonResponse
    {
        $category = $this->CategoryInterface->update($request->validated(), $id);
        return $this->success(202, "Category updated successfully", CategoryResource::make($category));
    }

    public function store(StoreRequest $request): JsonResponse
    {
        $category = $this->CategoryInterface->store($request->validated());
        return $this->success(201, "Category created successfully", CategoryResource::make($category));
    }

    public function delete(int|string $id): JsonResponse
    {
        $this->CategoryInterface->delete($id);
        return $this->success(202, "Category deleted successfully", []);
    }
}
