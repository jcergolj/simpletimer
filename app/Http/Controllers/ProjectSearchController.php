<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;

class ProjectSearchController extends Controller
{
    public function __invoke(Request $request): Response|View
    {
        $query = $request->input('q', '');
        $clientId = $request->input('client_id');

        if (empty($query) || strlen((string) $query) < 2) {
            return response('', 200);
        }

        $projectsQuery = Project::query()
            ->searchByName($query)
            ->with('client');

        if ($clientId) {
            $projectsQuery->where('client_id', $clientId);
        }

        $projects = $projectsQuery->limit(10)->get();

        $selectedClient = $clientId ? Client::find($clientId) : null;

        return view('turbo::projects-search.index', [
            'projects' => $projects,
            'clientId' => $clientId,
            'selectedClient' => $selectedClient,
            'defaultHourlyRate' => $selectedClient->hourlyRate ?? $request->user()->hourlyRate,
        ]);
    }
}
