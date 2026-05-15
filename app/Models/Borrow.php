<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Borrow extends Model
{
    //

    protected $table = 'borrows';

    protected $fillable =[
        'book_id',
        'member_name'
    ];

}
