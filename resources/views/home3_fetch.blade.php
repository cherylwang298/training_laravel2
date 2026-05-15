@extends('layouts.app')

@section('content')

<h1 class="text-3xl font-bold text-center mb-6">
    Book Data
</h1>

<table class="mb-6 mt-3 mx-auto border-collapse">

    <thead>
        <tr>
            <th class="border border-black px-4 py-2">Book Title</th>
            <th class="border border-black px-4 py-2">Book Author</th>
            <th class="border border-black px-4 py-2">Action</th>
        </tr>
    </thead>

    <tbody>

        @forelse ($books as $book)

        <tr id="book-row-{{$book->id}}">

            <td class="border border-black px-4 py-2 book-title">
                {{$book->title}}
            </td>

            <td class="border border-black px-4 py-2 book-author">
                {{$book->author->name}}
            </td>

            <td class="border border-black px-4 py-2">

                <div class="flex gap-3 justify-center">

                    <button
    type="button"
    class="bg-blue-500 text-white px-3 py-1 rounded-md"

    data-id="{{ $book->id }}"
    data-title="{{ $book->title }}"
    data-description="{{ $book->description }}"
    data-author="{{ $book->author_id }}"

    onclick="openModal(this)">

    Edit

</button>


                    <button
                        type="button"
                        onclick="deleteBook({{$book->id}})"
                        class="bg-red-500 text-white px-3 py-1 rounded-md">
                        Delete
                    </button>

                </div>

            </td>

        </tr>

        @empty

        <tr>
            <td colspan="3" class="text-center py-4">
                No books found
            </td>
        </tr>

        @endforelse

    </tbody>

</table>

<div class="mt-6 flex flex-col items-center">

    <h1 class="font-bold text-3xl mb-3">
        Add New Book
    </h1>

    <div class="border border-gray-400 shadow-xl rounded-lg px-4 py-4 flex flex-col gap-2 w-[400px]">

        <label>Book Title</label>

        <input
            type="text"
            id="book_title"
            class="border border-black px-2 py-1 rounded-md">

        <label>Book Description</label>

        <input
            type="text"
            id="book_description"
            class="border border-black px-2 py-1 rounded-md">

        <label>Book Author</label>

        <select
            id="book_author"
            class="border border-black px-2 py-1 rounded-md">

            @foreach ($authors as $author)

                <option value="{{$author->id}}">
                    {{$author->name}}
                </option>

            @endforeach

        </select>

        <button
            type="button"
            onclick="addBook()"
            class="bg-blue-500 text-white font-semibold px-4 py-2 rounded-md mt-3 hover:bg-blue-800">
            Submit Book
        </button>

    </div>

</div>

<div
    id="editModal"
    style="display:none;"
    class="fixed inset-0 bg-black/50 z-50 items-center justify-center">

    <div class="bg-white rounded-xl shadow-2xl p-6 w-[400px]">

        <h1 class="text-2xl font-bold mb-4">
            Edit Book
        </h1>

        <input type="hidden" id="edit_book_id">

        <div class="flex flex-col gap-2">

            <label>Book Title</label>

            <input
                type="text"
                id="edit_book_title"
                class="border border-gray-400 rounded-md px-2 py-1">

            <label>Book Description</label>

            <input
                type="text"
                id="edit_book_description"
                class="border border-gray-400 rounded-md px-2 py-1">

            <label>Book Author</label>

            <select
                id="edit_book_author"
                class="border border-gray-400 rounded-md px-2 py-1">

                @foreach ($authors as $author)

                    <option value="{{$author->id}}">
                        {{$author->name}}
                    </option>

                @endforeach

            </select>

            <div class="flex gap-3 mt-4">

                <button
                    type="button"
                    onclick="updateBook()"
                    class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                    Update
                </button>

                <button
                    type="button"
                    onclick="closeModal()"
                    class="bg-gray-400 text-white px-4 py-2 rounded-lg hover:bg-gray-600">
                    Cancel
                </button>

            </div>

        </div>

    </div>

</div>

@endsection

@section('script')

<script>

function openModal(button){

    const id = button.dataset.id;
    const title = button.dataset.title;
    const description = button.dataset.description;
    const authorId = button.dataset.author;

    document.getElementById('edit_book_id').value = id;
    document.getElementById('edit_book_title').value = title;
    document.getElementById('edit_book_description').value = description;
    document.getElementById('edit_book_author').value = authorId;

    const modal = document.getElementById('editModal');
    modal.style.display = 'flex';
}

function closeModal(){
    const modal = document.getElementById('editModal');
    modal.style.display = 'none';
}

function addBook(){
    const title = document.getElementById('book_title').value;
    const description = document.getElementById('book_description').value;
    const author = document.getElementById('book_author').value;
    
    fetch('/add-book', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
            book_title: title,
            book_description: description,
            book_author: author
        })
    })
    .then(() => {
        window.location.reload();
    });
}

function updateBook(){
    const id = document.getElementById('edit_book_id').value;
    const title = document.getElementById('edit_book_title').value;
    const description = document.getElementById('edit_book_description').value;
    const author = document.getElementById('edit_book_author').value;

    fetch(`/edit-book/${id}`, {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
            book_title: title,
            book_description: description,
            book_author: author
        })
    })
    .then(() => {
        closeModal();
        window.location.reload();
    });
}


function deleteBook(id){

    fetch(`/delete-book/${id}`, {
        method: 'DELETE',
        headers: {
             'Content-Type': 'application/json',
             'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    })

    .then(response => {
        console.log(response);

        if(!response.ok){
            alert('Delete failed');
            return;
        }

        window.location.reload();
    });

}

</script>

@endsection