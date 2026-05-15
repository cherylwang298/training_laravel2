<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Borrow extends Model
{
    //
    
    use HasUuids;

    protected $table = 'borrows';

    protected $fillable =[
        'book_id',
        'member_name'
    ];

}
