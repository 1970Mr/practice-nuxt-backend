<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Post extends Model
{
    protected $fillable = [
        'title',
        'content',
        'image',
    ];

    public function image(): Attribute
    {
        return new Attribute(
            get: fn(string $value) => filter_var($value, FILTER_VALIDATE_URL) ?
                $value :
                url(Storage::url($value)),
        );
    }
}
