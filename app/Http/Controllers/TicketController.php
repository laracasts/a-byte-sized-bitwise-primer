<?php

namespace App\Http\Controllers;

use App\Feature;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TicketController extends Controller
{
    public function __invoke(Request $request)
    {
        $featuresToFilterTo = $request->collect('selectedFeatures');

        $tickets = Ticket::all();

        return Inertia::render('Tickets', [
            'tickets' => $tickets,
            'features' => Feature::cases(),
            'selectedFeatures' => $featuresToFilterTo->mapWithKeys(fn (int $feature) => [$feature => true]),
        ]);
    }
}
