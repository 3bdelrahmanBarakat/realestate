<?php

namespace App\Http\Resources\API\V1\Property\Report;

use App\Http\Resources\API\V1\Property\PropertyResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SalesResource extends JsonResource
{

    public function toArray(Request $request)
    {
        if(auth()->user()->role == 'admin'){

            return[
                "total_sales" => $this->total_sales,
                "total_revenue" => $this->total_revenue,
                "for_sale_units" => $this->for_sale_units,
                "total_rental" => $this->total_rental,
                "for_rent_units" => $this->for_rent_units,
                "admin_properties_count" => $this->when(auth()->user()->role == 'admin', $this->admin_properties_count),
                "admin_listings_count" => $this->when(auth()->user()->role == 'admin', $this->admin_listings_count),
                "listed_properties_count" => $this->when(auth()->user()->role == 'admin', $this->listed_properties_count),
                "listed_properties_count" => $this->when(auth()->user()->role == 'admin', $this->listed_properties_count),
                "admin_sales_count" => $this->when(auth()->user()->role == 'admin', $this->admin_sales_count),
                "admin_rental_count" => $this->when(auth()->user()->role == 'admin', $this->admin_rental_count),
                "listed_properties_count" => $this->when(auth()->user()->role == 'admin', $this->listed_properties_count),
            ];
        }else{
            return[
                "total_sales" => $this->total_sales,
                "total_rental" => $this->total_rental,
                "total_revenue" => $this->total_revenue,
                "for_sale_units" => $this->for_sale_units,
                "for_rent_units" => $this->for_rent_units,
            ];
        }
    }
}
