@extends('layouts.app')

@section('content')

<h1 class="text-3xl font-bold text-center mb-6">
    Book Data
</h1>

<table class="mb-6 mt-3 mx-auto border-collapse">

    <thead>
        <th class="border border-black px-4 py-2">Book Title</th>
        <th class="border border-black px-4 py-2">Book Author</th>
        <th class="border border-black px-4 py-2">Action</th>
    </thead>

    <tbody id="bookTableBody">

        @forelse ($books as $book)

        <tr id="book-row-{{$book->id}}">

            <td class="border border-black px-4 py-2 book-title">
                {{$book->title}}
            </td>

            <td class="border border-black px-4 py-2 book-author">
                {{$book->author->name}}
            </td>

            <td class="border border-black px-4 py-2">

                <div class="flex gap-2">

                    <button
                        onclick="openModal(
                            {{$book->id}},
                            '{{ $book->title }}',
                            '{{ $book->description }}',
                            {{$book->author_id}}
                        )"
                        class="bg-blue-500 text-white px-3 py-1 rounded-md">
                        Edit
                    </button>

                    <button
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

{{-- ADD BOOK FORM --}}
<div class="mt-6 flex flex-col items-center">

    <h1 class="font-bold text-2xl mb-4">
        Add New Book
    </h1>

    <div class="border border-gray-400 rounded-lg p-5 flex flex-col gap-3 w-[400px]">

        <input
            type="text"
            id="book_title"
            placeholder="Book Title"
            class="border border-black px-2 py-1">

        <input
            type="text"
            id="book_description"
            placeholder="Book Description"
            class="border border-black px-2 py-1">

        <select
            id="book_author"
            class="border border-black px-2 py-1">

            @foreach ($authors as $author)
                <option value="{{$author->id}}">
                    {{$author->name}}
                </option>
            @endforeach

        </select>

        <button
            onclick="addBook()"
            class="bg-green-500 text-white px-4 py-2 rounded-md">
            Add Book
        </button>

    </div>

</div>

{{-- EDIT MODAL --}}
<div
    id="editModal"
    class="hidden fixed inset-0 bg-black/50 flex items-center justify-center">

    <div class="bg-white rounded-xl p-6 w-[400px]">

        <h1 class="text-2xl font-bold mb-4">
            Edit Book
        </h1>

        <input type="hidden" id="edit_book_id">

        <div class="flex flex-col gap-3">

            <input
                type="text"
                id="edit_book_title"
                class="border border-black px-2 py-1">

            <input
                type="text"
                id="edit_book_description"
                class="border border-black px-2 py-1">

            <select
                id="edit_book_author"
                class="border border-black px-2 py-1">

                @foreach ($authors as $author)
                    <option value="{{$author->id}}">
                        {{$author->name}}
                    </option>
                @endforeach

            </select>

            <div class="flex gap-3 mt-4">

                <button
                    onclick="updateBook()"
                    class="bg-blue-500 text-white px-4 py-2 rounded-md">
                    Update
                </button>

                <button
                    onclick="closeModal()"
                    class="bg-gray-500 text-white px-4 py-2 rounded-md">
                    Cancel
                </button>

            </div>

        </div>

    </div>

</div>

@endsection

@section('script')

<script>

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

    .then(response => response.json())

    .then(data => {

        const tbody = document.getElementById('bookTableBody');

        tbody.innerHTML += `
        
        <tr id="book-row-${data.book.id}">

            <td class="border border-black px-4 py-2">
                ${data.book.title}
            </td>

            <td class="border border-black px-4 py-2">
                ${data.author_name}
            </td>

            <td class="border border-black px-4 py-2">

                <div class="flex gap-2">

                    <button
                        onclick="openModal(
                            ${data.book.id},
                            '${data.book.title}',
                            '${data.book.description}',
                            ${data.book.author_id}
                        )"
                        class="bg-blue-500 text-white px-3 py-1 rounded-md">
                        Edit
                    </button>

                    <button
                        onclick="deleteBook(${data.book.id})"
                        class="bg-red-500 text-white px-3 py-1 rounded-md">
                        Delete
                    </button>

                </div>

            </td>

        </tr>
        `;

        document.getElementById('book_title').value = '';
        document.getElementById('book_description').value = '';

    });

}

function deleteBook(id){

    fetch(`/delete-book/${id}`, {

        method: 'DELETE',

        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }

    })

    .then(() => {

        document.getElementById(`book-row-${id}`).remove();

    });

}

function openModal(id, title, description, authorId){

    document.getElementById('edit_book_id').value = id;
    document.getElementById('edit_book_title').value = title;
    document.getElementById('edit_book_description').value = description;
    document.getElementById('edit_book_author').value = authorId;

    document.getElementById('editModal').classList.remove('hidden');

}

function closeModal(){

    document.getElementById('editModal').classList.add('hidden');

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

    .then(response => response.json())

    .then(data => {

        const row = document.getElementById(`book-row-${id}`);

        row.querySelector('.book-title').innerText = data.book.title;
        row.querySelector('.book-author').innerText = data.author_name;

        closeModal();

    });

}

</script>

@endsection