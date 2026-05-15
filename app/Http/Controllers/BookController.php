<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Member;

class BookController extends Controller
{
    //

    public function store(){
        Book::create([
            'title' => "Book Satu",
            'author' => 'Author Tiga'
        ]);
    }

    public function edit($id, Request $request){
        $request->validate([
            'title' => 'required',
            'author' => 'required'
        ]);

        $book = Book::findOrFail($id);

        $book->update([
            'title' => $request->title,
            'author' => $request->author
        ]);
    }

    public function delete($id){
        $book = Book::findOrFail($id);
        $book->delete();
    }

    public function index2(){
        $books = Book::all();
        $authors = Member::all();
        return view('home2', compact('books', 'authors'));
    }


    public function addBook(Request $request){
        $request->validate([
            'book_title' => 'required|string|max:255',
            'book_author' => 'required|string|max:255',
            'book_description' => 'required|string',
        ]);


        try{
        Book::create([
            'title' => $request->book_title,
            'description' => $request->book_description,
            'author_id' => $request->book_author
        ]);
        }catch(\Exception $e){
            return back()->with('error', $e->getMessage());
        }


        return back()->with('success', 'Book added successfully');
    }

    public function deleteBook($id){
    $book = Book::findOrFail($id);
    $book->delete();
    return back()->with('success', 'Book deleted successfully');
    }

    public function updateBook(Request $request, $id){

        $request->validate([
            'book_title' => 'required|string|max:255',
            'description' => 'required|string',
            'author_id' => 'required'
        ]);

     $book = Book::findOrFail($id);

     try{
        $book->update([
            'title' => $request->book_title,
            'description' => $request->description,
            'author_id' => $request->book_author_id
        ]);
     }catch(\Exception $e){
        return back()->with('error', $e->getMessage());
     }

     return back()->with('success', 'Book updated successfully');
    }


}
