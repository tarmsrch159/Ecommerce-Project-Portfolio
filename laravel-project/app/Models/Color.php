<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Color extends Model
{
    use HasFactory;
    protected $fillable = [
        "name",

    ];
    /*************  ✨ Windsurf Command ⭐  *************/
    /**
     * Get the products that belong to this color.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    /*******  c4bb55d1-c7b0-4e2d-9b7a-8483b80639fa  *******/
    public function products()
    {
        return $this->belongsToMany(Product::class);
    }
}
