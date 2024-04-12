<?php

use App\Feature;
use Illuminate\Support\Facades\Artisan;
use Termwind\HtmlRenderer;
use function Laravel\Prompts\multiselect;
use function Laravel\Prompts\table;
use function Laravel\Prompts\info;

function decimalToBinary($decimal): string
{
    $termwind = new HtmlRenderer();

    return str(decbin($decimal))
        ->padLeft(8, '0')
        ->split(1)
        ->map(fn($binary) => $binary === '0'
            ? $termwind->parse("<span class='text-gray-500'>{$binary}</span>")->toString()
            : $termwind->parse("<span class='text-yellow-500'>{$binary}</span>")->toString()
        )
        ->join(' ');
}

Artisan::command('features', function () {
    $selectedFeatures = multiselect(
        'Which features would you like?',
        Feature::collect()->map(fn(Feature $feature) => "[{$feature->value}]: {$feature->description()}"),
        scroll: Feature::collect()->count(),
    );

    $selected = collect($selectedFeatures)->map(fn(string $feature) => str($feature)->after('[')->before(']')->toInteger());
    $sum = $selected->sum();
    info("{$selected->join(" + ")} = {$sum}");

    table(
        ['Feature', 'Decimal', 'Binary'],
        Feature::collect()
            ->map(fn(Feature $feature) => [
                str($feature->name),
                str($feature->value),
                decimalToBinary($feature->value),
            ])
            ->push(['', '', ''])
            ->push(['Ticket', $sum, decimalToBinary($sum)]),
    );
});

Artisan::command('stack {one} {two}', function () {
    $sum = intval($this->argument('one')) & intval($this->argument('two'));

    info("{$this->argument('one')} & {$this->argument('two')} = {$sum}");

    table(['Decimal', 'Binary'], [
        [$this->argument('one'), decimalToBinary($this->argument('one'))],
        [$this->argument('two'), decimalToBinary($this->argument('two'))],
        ['', ''],
        [$sum, decimalToBinary($sum)],
    ]);
});
