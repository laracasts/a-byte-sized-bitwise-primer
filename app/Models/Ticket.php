<?php

namespace App\Models;

use App\Feature;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class Ticket extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function features(): Attribute
    {
        return Attribute::make(
            get: fn (int $sum) => Feature::collect()->filter(fn (Feature $feature) => $feature->value & $sum)->values(),
            set: fn ($values) => Collection::wrap($values)->sum('value'),
        );
    }
}
