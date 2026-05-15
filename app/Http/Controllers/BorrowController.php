<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Borrow;
use App\Models\Book;


class BorrowController extends Controller
{
    //

    public function index(){
        $borrows = Borrow::all();
        $books = Book::all();
        return view('home', compact('borrows', 'books'));
    }


}
