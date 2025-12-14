<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;
    protected $fillable = [
        "name",
        "discount",
        "valid_until",
    ];

    /**
     * Convert Coupon name to uppercase
     */
    public function setNameAttribute($value)
    {
        $this->attributes["name"] = Str::upper($value);
    }


    /**
     * Check if the coupon is not expired
     */
    public function checkifValid()
    {
        if ($this->valid_until > Carbon::now()) {
            return true;
        } else {
            return false;
        }
    }
}
