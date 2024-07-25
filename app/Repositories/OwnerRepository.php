<?php


namespace App\Repositories;

use App\Http\Controllers\API\Traits\APIResponse;
use App\Http\Controllers\API\Traits\ImageUploader;
use App\Interfaces\OwnerInterface;
use App\Models\Owner;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Pipeline;

class OwnerRepository implements OwnerInterface
{
    use APIResponse, ImageUploader;


    public function index()
    {
        $owners = Pipeline::send(Owner::query())
            ->through([])
            ->thenReturn()
            ->paginate(10)
            ->withQueryString();

        $owners->load(['properties']);
        return $owners;
    }

    public function all()
    {
        $owner = Pipeline::send(Owner::query())
            ->through([])
            ->thenReturn()
            ->select("id", "name", "phone")
            ->get();

        return $owner;
    }

    public function show(int|string $id)
    {
        $owner = $this->find($id);
        $owner->load(['properties']);
        return $owner;
    }


    public function delete(int|string $id): void
    {
        $owner = $this->find($id);
        $owner->delete();
    }

    public function find(int|string $id): Owner
    {

        $owner = Owner::where("id", $id)->first();

        if (!$owner) {
            throw new HttpResponseException($this->error(404, "There is no owner with the given id:{$id}", []));
        }
        return $owner;
    }

}
