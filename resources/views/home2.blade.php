@extends('layouts.app')

@section('content')

<h1 class="text-3xl font-bold text-center">Book Data</h1>

<table class="mb-3 mt-3 mx-auto">

    <thead>
    <th class="border border-black text-center">book id</th>
    <th class="border border-black text-center">book title</th>
    <th class="border border-black text-center">book author</th>
    <th class="border border-black text-center">Action</th>
    </thead>

    <tbody class="">
        @forelse ($books as $book)
            <tr class="">
                <td class="border border-black text-center"> {{ $book->id }}</td>
                <td class="border border-black text-center">{{ $book->title }}</td>
                <td class="border border-black text-center">{{ $book->author }}</td>
                <td class="flex flex-row gap-3 border border-black text-center">
                <button type="button" class="bg-blue-500 text-center px-2 rounded-md" onclick = "openModal()">Edit</button>


                    <form action="{{ route('delete.book', $book->id) }}" method="POST">
                        @csrf
                        @method('DELETE')

                        <button type="submit" class="bg-red-500 text-center px-2 rounded-md">
                            Delete
                        </button>
                    </form>
                </td>
            </tr>

            <div id="editModal"
    class="hidden fixed inset-0 bg-black/50 z-50 flex items-center justify-center">

    <div class="bg-white rounded-xl shadow-2xl p-6 w-[400px]">

        <h1 class="text-2xl font-bold mb-4">
            Edit Book
        </h1>

        <form method="POST" action="{{route('update.book', $book->id)}}">
            @csrf
            @method('PUT')

            <div class="flex flex-col gap-2">

                <label>Book Title</label>
                <input
                    type="text"
                    name="book_title"
                    class="border border-gray-400 rounded-md px-2 py-1"
                    value = "{{ $book->title }}">

                <label>Book Author</label>
                <input
                    type="text"
                    name="book_author"
                    class="border border-gray-400 rounded-md px-2 py-1"
                    value = "{{ $book->author }}">

                <div class="flex gap-3 mt-4">

                    <button
                        type="submit"
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
        </form>
    </div>
</div>


        @empty
            <tr>
                <td colspan="3">No books found</td>
            </tr>

        @endforelse
    </tbody>

</table>


<br>


<div class="mt-3 flex flex-col items-center">

    <h1 class="font-bold text-3xl mb-2">Add New Book</h1>

    <form action="{{route('create.book')}}" method="POST" class="border border-gray-500 shadow-xl rounded-lg px-3 py-2 flex flex-col">
        @csrf

        <label>Book Title</label>
        <input type="text" name="book_title" class="border border-black">

        <label>Book Author</label>
        <input type="text" name="book_author" class="border border-black">

        <button type="submit" class="bg-blue-500 text-center mx-auto px-2 py-2 w-32 rounded-md mt-3 text-white font-semibold hover:bg-blue-800">Submit Book</button>


    </form>

</div>


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

function openModal(){
    const form = document.getElementById('editModal');
    form.classList.remove('hidden');
}
function closeModal(){
    const form = document.getElementById('editModal');
    form.classList.add('hidden');

}



</script>
@endsection


