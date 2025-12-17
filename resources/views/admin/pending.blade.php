@extends('layouts.app')

@section('content')
<div class="max-w-xl mx-auto bg-white p-6 rounded shadow">

    <h2 class="text-xl font-bold mb-4">承認待ちユーザー一覧</h2>

    @foreach ($users as $user)
        <div class="border p-3 my-2">
            <p>名前：{{ $user->name }}</p>
            <p>電話：{{ $user->phone }}</p>
            <p>部屋番号：{{ $user->room_number }}</p>

            <form action="{{ route('admin.approve', $user->id) }}" method="POST">
                @csrf
                <button class="bg-green-500 text-white px-4 py-1 rounded">承認する</button>
            </form>
        </div>
    @endforeach

</div>
@endsection
