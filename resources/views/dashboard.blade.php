@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto bg-white p-6 rounded shadow">
    <h2 class="text-lg font-bold">ようこそ、{{ Auth::user()->name }} さん！</h2>

    <p class="mt-4">このページは承認されたユーザーだけ見れます。</p>
</div>
@endsection
