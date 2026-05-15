@extends('layouts.app')

@section('content')

@include('partials.navbar')

<table>

    <thead>
    <th>book id</th>
    <th>member name</th>
    </thead>

    <tbody>
        @foreach ($borrows as $borrow)
            <tr>
                <td>{{ $borrow->book_id }}</td>
                <td>{{ $borrow->member_name }}</td>
            </tr>
        @endforeach
    </tbody>
    
    

</table>

<br>

<button class="bg-yellow-500 font-bold text-lg px-2 py-1" onclick ="addBook()">Add "Book Satu"</button>


<table class="mb-3">

    <thead>
    <th>book id</th>
    <th>book title</th>
    <th>book author</th>
    <th>Action</th>
    </thead>

    <tbody class="">
        @forelse ($books as $book)
            <tr class="">
                <td class="border border-black text-center"> {{ $book->id }}</td>
                <td class="border border-black text-center">{{ $book->title }}</td>
                <td class="border border-black text-center">{{ $book->author }}</td>
                <td class="flex flex-row gap-3 border border-black text-center">
                    <button class="bg-blue-500 text-center px-2 rounded-md" onclick = "editBook({{$book->id }})">Edit</button>
                    <button class="bg-red-500 text-center px-2 rounded-md" onclick = "deleteBook({{$book->id }})">Delete</button>
                </td>
            </tr>

        @empty
            <tr>
                <td colspan="3">No books found</td>
            </tr>

        @endforelse
    </tbody>

</table>

<a class="bg-purple-500 mt-3 text-white font-semibold text-lg px-2 py-1" href="{{route('home.2')}}">Go to home2</a>

@endsection

@section('script')
<script>

    function addBook(){
        fetch('/add-book', {
            method: 'POST',
            headers: {
                'Content-type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
         .then(() => {
        window.location.reload();
    });
    }

function editBook(id){
    fetch(`/edit-book/${id}`, {
        method: 'PUT',
        headers: {
             'Content-type': 'application/json',
             'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
            title: 'Edited Book',
            author: 'Edited Author'
        })
    })
    .then(() => {
        window.location.reload();
    });
}

function deleteBook(id){
    fetch(`/delete-book/${id}`, {
        method: 'DELETE',
        headers: {
             'Content-type': 'application/json',
             'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    })
    .then(() => {
        window.location.reload();
    });
}



</script>
@endsection


