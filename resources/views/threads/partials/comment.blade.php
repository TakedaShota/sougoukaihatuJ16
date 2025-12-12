@php
    // インデント幅（px）
    $indent = ($level ?? 0) * 20;
@endphp

<div style="margin-left: {{ $indent }}px; margin-top: 12px; padding: 10px; border-left: 2px solid #eee;">
    <div style="display:flex; gap:10px; align-items:center;">
        <img src="https://ui-avatars.com/api/?name={{ urlencode($comment->user->name ?? '名無し') }}" alt="avatar" style="width:40px;height:40px;border-radius:50%;">
        <div>
            <div style="font-weight:600;">{{ $comment->user->name ?? '名無し' }}</div>
            <div style="font-size:12px;color:#888;">{{ $comment->created_at->diffForHumans() }}</div>
        </div>
    </div>

    <div style="margin-top:8px;">{{ $comment->body }}</div>

    {{-- 返信フォーム（折り畳みでOK） --}}
    <div style="margin-top:8px;">
        <form action="{{ route('comments.store') }}" method="POST" style="display:flex; flex-direction:column; gap:6px;">
            @csrf
            <input type="hidden" name="thread_id" value="{{ $comment->thread_id }}">
            <input type="hidden" name="parent_id" value="{{ $comment->id }}">
            <textarea name="body" rows="2" placeholder="返信を入力..." required style="resize:none;padding:6px;border:1px solid #ddd;border-radius:6px;"></textarea>
            <div>
                <button type="submit" style="background:#2563eb;color:#fff;padding:6px 12px;border-radius:6px;border:none;">返信</button>
            </div>
        </form>
    </div>

    {{-- 子コメント（再帰） --}}
    @if($comment->replies && $comment->replies->count())
        @foreach($comment->replies as $child)
            @include('threads.partials.comment', ['comment' => $child, 'level' => ($level ?? 0) + 1])
        @endforeach
    @endif
</div>
