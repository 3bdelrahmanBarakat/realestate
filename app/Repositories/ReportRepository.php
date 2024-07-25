<?php

namespace App\Repositories;

use App\Filters\Actions\FilterByDateRange;
use App\Filters\Actions\FilterByPropertyID;
use App\Filters\Properties\FilterByUserID;
use App\Filters\Properties\Listings\FilterByAdminID;
use App\Http\Controllers\API\Traits\APIResponse;
use App\Http\Controllers\API\Traits\ImageUploader;
use App\Interfaces\ReportInterface;
use App\Models\Property;
use App\Models\PropertyAction;
use App\Models\PropertyListing;
use Illuminate\Support\Facades\Pipeline;

class ReportRepository implements ReportInterface
{
    use APIResponse, ImageUploader;

    public function sales()
    {
        $properties = Pipeline::send(Property::query())
            ->through([])
            ->thenReturn()
            ->get();

        $property_listings = Pipeline::send(PropertyListing::query())
            ->through([])
            ->thenReturn()
            ->get();

            $totalSales = $properties->where('status', 'sold')->count();
            $totalRental = $properties->where('status', 'rented')->count();
            $totalRevenue = $property_listings->sum('revenue');
            $forSaleUnits = $properties->where('type', 'for sale')->count();
            $forRentUnits = $properties->where('type', 'for rent')->count();

            if(auth()->user()->role === "admin"){
            $adminPropertiesCount = $properties->where('user_id', auth()->user()->id)->count();
            $adminListingsCount = $property_listings->where('admin_id', auth()->user()->id)->count();
            $adminSalesCount = $property_listings->where('admin_id', auth()->user()->id)->where('status', 'sold')->count();
            $adminRentalCount = $property_listings->where('admin_id', auth()->user()->id)->where('status', 'rented')->count();
            $listedPropertiesCount = $adminListingsCount - $adminPropertiesCount;

            return [
                'total_sales' => $totalSales,
                'total_rental' => $totalRental,
                'total_revenue' => $totalRevenue,
                'for_sale_units' => $forSaleUnits,
                'for_rent_units' => $forRentUnits,
                'admin_properties_count' => $adminPropertiesCount,
                'admin_listings_count' => $adminListingsCount,
                'admin_sales_count' => $adminSalesCount,
                'admin_rental_count' => $adminRentalCount,
                'listed_properties_count' => $listedPropertiesCount,
            ];
            }


        return [
            'total_sales' => $totalSales,
            'total_rental' => $totalRental,
            'total_revenue' => $totalRevenue,
            'for_sale_units' => $forSaleUnits,
            'for_rent_units' => $forRentUnits,
        ];
    }

    public function adminSales($year)
{
    $months = [
        1 => 'January', 2 => 'February', 3 => 'March', 4 => 'April',
        5 => 'May', 6 => 'June', 7 => 'July', 8 => 'August',
        9 => 'September', 10 => 'October', 11 => 'November', 12 => 'December'
    ];

    $adminId = request('admin_id');

    // Filter for total sales
    $salesData = Pipeline::send(PropertyListing::query())
        ->through([
            FilterByAdminID::class,
        ])
        ->thenReturn()
        ->selectRaw('MONTH(created_at) as month, COUNT(*) as total_sales')
        ->whereYear('created_at', $year)
        ->where('status', 'sold')
        ->groupBy('month')
        ->get()
        ->pluck('total_sales', 'month')
        ->mapWithKeys(function ($count, $month) use ($months) {
            return [$months[$month] => $count];
        });

    // Filter for total rentals
    $rentalData = Pipeline::send(PropertyListing::query())
        ->through([
            FilterByAdminID::class,
        ])
        ->thenReturn()
        ->selectRaw('MONTH(created_at) as month, COUNT(*) as total_rental')
        ->whereYear('created_at', $year)
        ->where('status', 'rented')
        ->groupBy('month')
        ->get()
        ->pluck('total_rental', 'month')
        ->mapWithKeys(function ($count, $month) use ($months) {
            return [$months[$month] => $count];
        });

    // Filter for total revenue
    $revenueData = Pipeline::send(PropertyListing::query())
        ->through([
            FilterByAdminID::class,
        ])
        ->thenReturn()
        ->selectRaw('MONTH(created_at) as month, SUM(revenue) as total_revenue')
        ->whereYear('created_at', $year)
        ->groupBy('month')
        ->get()
        ->pluck('total_revenue', 'month')
        ->mapWithKeys(function ($sum, $month) use ($months) {
            return [$months[$month] => $sum];
        });

    // Calculate yearly totals
    $totalSales = $salesData->sum();
    $totalRentals = $rentalData->sum();
    $totalRevenue = $revenueData->sum();

    // Format the results
    $results = [
        'yearly_totals' => [
            'total_sales' => $totalSales,
            'total_rental' => $totalRentals,
            'total_revenue' => $totalRevenue,
        ],
        'monthly_data' => []
    ];

    foreach ($months as $monthNumber => $monthName) {
        $results['monthly_data'][$monthName] = [
            'total_sales' => $salesData[$monthName] ?? 0,
            'total_rental' => $rentalData[$monthName] ?? 0,
            'total_revenue' => $revenueData[$monthName] ?? 0,
        ];
    }

    return $results;
}



    public function actions()
    {
        $actionsQuery = Pipeline::send(PropertyAction::query())
            ->through([
                FilterByDateRange::class,
                FilterByPropertyID::class,
            ])
            ->thenReturn();

        $property_listings = Pipeline::send(PropertyListing::query())
        ->through([
            FilterByDateRange::class,
            FilterByPropertyID::class,
        ])
        ->thenReturn()
        ->get();

        $baseQuery = clone $actionsQuery;
        $uniqueClientsCount = $baseQuery->distinct('user_id')->count('user_id');

        $baseQuery = clone $actionsQuery;
        $callClientsCount = $baseQuery->where('action', 'called')->distinct('user_id')->count('user_id');

        $baseQuery = clone $actionsQuery;
        $whatsappClientsCount = $baseQuery->where('action', 'whatsapp')->distinct('user_id')->count('user_id');

        $baseQuery = clone $actionsQuery;
        $chatClientsCount = $baseQuery->where('action', 'sent message')->distinct('user_id')->count('user_id');

        $propertyListingsCount = $property_listings->count();

        return [
            'unique_clients_count' => $uniqueClientsCount,
            'call_clients_count' => $callClientsCount,
            'whatsapp_clients_count' => $whatsappClientsCount,
            'chat_clients_count' => $chatClientsCount,
            'property_listings_count' => $propertyListingsCount,
        ];
    }

    public function types()
    {
        $types = ['villa', 'apartment'];
        $purposes = ['commercial', 'residential'];
        $results = [];

        // Count by unit type
        foreach ($types as $type) {
            $key = "{$type}";
            $results[$key] = Property::where('unit_type', $type)->count();
        }

        // Count by purpose
        foreach ($purposes as $purpose) {
            $key = "{$purpose}";
            $results[$key] = Property::where('purpose', $purpose)->count();
        }

        return $results;
    }


}
