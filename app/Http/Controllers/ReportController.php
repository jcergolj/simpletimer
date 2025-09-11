<?php

namespace App\Http\Controllers;

use App\Actions\Reports\GenerateReportDataAction;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ReportController extends Controller
{
    public function index(Request $request, GenerateReportDataAction $generateReportData): View
    {
        $reportData = $generateReportData->execute($request);

        return view('reports.index', [
            'reportData' => $reportData,
            'clients' => Client::all(),
        ]);
    }
}
