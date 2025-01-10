@extends('layouts.app')

@section('title', 'Koran List')

@section('contents')
<div>
    <h1 class="font-bold text-2xl ml-3">Koran List</h1>
    <a href="{{ route('admin.korans.create') }}" class="text-white float-right bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Add Koran Issue</a>
    <hr />
    @if(Session::has('success'))
    <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400" role="alert">
        {{ Session::get('success') }}
    </div>
    @endif

    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-6 py-3">#</th>
                <th scope="col" class="px-6 py-3">Title</th>
                <th scope="col" class="px-6 py-3">Edition</th>
                <th scope="col" class="px-6 py-3">Pages</th>
                <th scope="col" class="px-6 py-3">Published</th>
                <th scope="col" class="px-6 py-3">Description</th>
                <th scope="col" class="px-6 py-3">Status</th>
                <th scope="col" class="px-6 py-3">Reads</th>
                <th scope="col" class="px-6 py-3">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($korans as $koran)
            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                <th scope="row" class="font-medium text-gray-900 whitespace-nowrap dark:text-white">
                    {{ $loop->iteration }}
                </th>
                <td>{{ $koran->title }}</td>
                <td>{{ $koran->edisi }}</td>
                <td>{{ $koran->pages }}</td>
                <td>{{ $koran->published ? 'Yes' : 'No' }}</td>
                <td>{{ $koran->description }}</td>
                <td>{{ $koran->status }}</td>
                <td>{{ $koran->read }}</td>
                <td class="w-36">
                    <div class="h-14 pt-5">
                        <a href="{{ route('admin.korans.show', $koran->id) }}" class="text-blue-800">Detail</a> |
                        <a href="{{ route('admin.korans.edit', $koran->id)}}" class="text-green-800 pl-2">Edit</a> |
                        <form action="{{ route('admin.korans.destroy', $koran->id) }}" method="POST" onsubmit="return confirm('Delete this issue?')" class="float-right text-red-800">
                            @csrf
                            @method('DELETE')
                            <button type="submit">Delete</button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td class="text-center" colspan="11">No koran issues found</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
