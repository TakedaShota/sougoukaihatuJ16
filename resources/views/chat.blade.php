@extends('layouts.app')

@section('content')
<div class="container mx-auto max-w-2xl py-6">
    <div class="bg-white shadow rounded-lg flex flex-col h-[500px]">

        <div class="border-b px-4 py-2 font-bold">
            チャット
        </div>

        <div id="chat-box" class="flex-1 overflow-y-auto px-4 py-2">
            <ul id="messages" class="space-y-3"></ul>
        </div>

        <form id="message-form" class="border-t px-4 py-2 flex gap-2">
            @csrf
            <input
                id="message-input"
                type="text"
                class="flex-1 border rounded px-3 py-2"
                placeholder="メッセージを入力"
                autocomplete="off"
            >
            <button class="bg-blue-500 text-white px-4 py-2 rounded">
                送信
            </button>
        </form>

    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {

    const form     = document.getElementById('message-form');
    const input    = document.getElementById('message-input');
    const messages = document.getElementById('messages');
    const chatBox  = document.getElementById('chat-box');

    const myId   = "{{ session()->getId() }}";
    const myName = "{{ auth()->check() ? auth()->user()->name : 'ゲスト' }}";

    function appendMessage(name, text, isMine) {

    // 外枠（左右寄せ）
    const li = document.createElement('li');
    li.className = `flex ${isMine ? 'justify-end' : 'justify-start'}`;

    // 吹き出し
    const bubble = document.createElement('div');
    bubble.className = `
        relative px-3 py-2 rounded-lg text-sm break-words
        ${isMine ? 'bg-blue-500 text-white mr-2' : 'bg-gray-200 ml-2'}
    `;
    bubble.style.maxWidth = '75%';

    bubble.innerHTML = `
        <div class="text-xs opacity-70 mb-1">${name}</div>
        <div>${text}</div>
    `;

    // しっぽ
    const tail = document.createElement('div');
    tail.className = `
        absolute top-3 w-0 h-0
        ${isMine
            ? 'right-[-6px] border-t-[6px] border-t-transparent border-l-[6px] border-l-blue-500 border-b-[6px] border-b-transparent'
            : 'left-[-6px] border-t-[6px] border-t-transparent border-r-[6px] border-r-gray-200 border-b-[6px] border-b-transparent'
        }
    `;

    bubble.appendChild(tail);
    li.appendChild(bubble);
    messages.appendChild(li);
    chatBox.scrollTop = chatBox.scrollHeight;
}




    // 送信（自分は即表示）
    form.addEventListener('submit', async (e) => {
        e.preventDefault();

        const message = input.value.trim();
        if (!message) return;

        appendMessage(myName, message, true);
        input.value = '';

        await axios.post('/chat/send', { message });
    });

    // 受信（相手のみ）
    Echo.channel('chat')
        .listen('.message.sent', (e) => {

            // ★ 自分のメッセージは無視
            if (e.senderId === myId) return;

            appendMessage(e.senderName, e.message, false);
        });
});
</script>
@endpush
