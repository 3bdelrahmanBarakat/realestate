<?php

namespace App\Http\Resources\API\V1\Property\Report;

use App\Http\Resources\API\V1\Property\PropertyResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AdminSalesResource extends JsonResource
{

    public function toArray(Request $request)
    {
        return $this->resource;
            // return[
            //     "total_sales" => $this->total_sales,
            //     "total_rental" => $this->total_rental,
            //     "total_revenue" => $this->total_revenue,
            // ];

    }
}
