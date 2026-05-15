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
        'member_id'
    ];

    //belongsTo-> satu peminjaman hanya punya satu buku
    public function book(){
        return $this->belongsTo(Book::class);
    }

    //belongsTo-> satu peminjaman hanya punya satu member
    public function member(){
        return $this->belongsTo(Member::class);
    }

}
