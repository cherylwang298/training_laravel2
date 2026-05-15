<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;


class Member extends Model
{
    //

    use HasUuids;

    //  protected $table = 'members';

    protected $fillable = [
        'name', 
        'email'
    ];

    //relation: hasMany-> setiap member(sebagai author), bisa menulis banyak buku
    public function books(){
        return $this->hasMany(Book::class);
    }

    //relation: hasMany-> setiap member(sebagai peminjam), bisa meminjam banyak buku
    public function borrows(){
        return $this->hasMany(Borrow::class);
    }
    

    
}
