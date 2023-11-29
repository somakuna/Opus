<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Partner extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function loans(): HasMany
    {
        return $this->hasMany(Loan::class);
    }

    public function works(): HasMany
    {
        return $this->hasMany(Work::class);
    }

    public function balance(): int
    {
        $inSum = $this->loans->where('method', 'in')->sum('amount');
        $outSum = $this->loans->where('method', 'out')->sum('amount');
        return $inSum - $outSum;
    }

}
