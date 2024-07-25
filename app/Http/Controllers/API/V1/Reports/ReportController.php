<?php

namespace App\Http\Controllers\API\V1\Reports;

use App\Http\Controllers\API\Traits\APIResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\API\V1\Property\Report\ActionsResource;
use App\Http\Resources\API\V1\Property\Report\AdminSalesResource;
use App\Http\Resources\API\V1\Property\Report\SalesResource;
use App\Http\Resources\API\V1\Property\Report\TypesResource;
use App\Interfaces\ReportInterface;


class ReportController extends Controller
{
    //h
    use APIResponse;

    public function __construct(public ReportInterface $ReportInterface)
    {
    }

    public function sales()
    {
        $report = $this->ReportInterface->sales();

        return $this->success(200, "report", SalesResource::make((object)$report));
    }

    public function adminSales($year)
    {
        $report = $this->ReportInterface->adminSales($year);

        return $this->success(200, "report", AdminSalesResource::make((object)$report));
    }

    public function actions()
    {
        $report = $this->ReportInterface->actions();

        return $this->success(200, "report", ActionsResource::make((object)$report));
    }

    public function types()
    {
        $report = $this->ReportInterface->types();
        return $this->success(200, "report", new TypesResource($report));
    }



}
