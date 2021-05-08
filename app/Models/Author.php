<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    use HasFactory;

    protected $guarded = [];

    // date columns die moeten worden behandeld als updated_at en created_at
    protected $dates = ['dob'];

    // vertaal string naar date
    public function setDobAttribute($dob_maaktnietuit)
    {
        $this->attributes['dob'] = Carbon::parse($dob_maaktnietuit);
    }
}
