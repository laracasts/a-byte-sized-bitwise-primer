<?php

use App\Feature;
use App\Http\Controllers\TicketController;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\Rules\Enum;
use Inertia\Inertia;

Route::redirect('/', '/tickets');
Route::get('/tickets', TicketController::class)->name('tickets');

Route::get('/tickets/edit', function () {
    return Inertia::render('EditTickets', [
        'tickets' => Ticket::all(),
        'features' => collect(Feature::cases())->map(fn (Feature $access) => [
            'value' => $access->value,
            'description' => $access->description(),
        ]),
    ]);
})->name('tickets.edit');

Route::put('/tickets/{ticket}', function (Request $request, Ticket $ticket) {
    $data = $request->validate([
        'name' => ['required', 'string', 'max:30'],
        'description' => ['required', 'string', 'max:200'],
        'branding_hex' => ['required', 'string', 'max:7', 'starts_with:#'],
        'features' => ['array', 'exclude'],
        'features.*' => ['int', new Enum(Feature::class)],
    ]);

    $features = $request->collect('features')->map(fn (int $feature) => Feature::from($feature));

    $ticket->fill([...$data, 'features' => $features])->save();

    return to_route('tickets.edit');
})->name('tickets.update');
