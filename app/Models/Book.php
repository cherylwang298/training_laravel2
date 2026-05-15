<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{

use HasUuids;

    protected $table = 'books';

    protected $fillable = [
        'title',
        'author_id',
        'description'
    ];

    public function author(){
        return $this->belongsTo(Member::class, 'author_id');
    }
}
