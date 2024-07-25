<?php

namespace App\Interfaces;


interface ReportInterface
{
    public function sales();
    public function actions();
    public function types();
    public function adminSales($year);
}
