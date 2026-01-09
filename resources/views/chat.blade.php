@extends('layouts.app')

@section('content')
<div class="container mx-auto max-w-2xl py-6">
    <div class="bg-white shadow rounded-lg flex flex-col h-[500px]">

        <!-- ヘッダー -->
        <div class="border-b px-4 py-2 font-bold">
            チャット
        </div>

        <!-- メッセージ表示 -->
        <div id="chat-box" class="flex-1 overflow-y-auto px-4 py-2">
            <ul id="messages" class="space-y-3"></ul>
        </div>

        <!-- 入力フォーム -->
        <form id="message-form" class="border-t px-3 py-2 flex flex-col gap-2">
            @csrf

            <!-- 画像プレビュー -->
            <div id="image-preview" class="flex gap-2 flex-wrap hidden"></div>

            <div class="flex items-center gap-2">
                <!-- 画像選択 -->
                <label for="image-input" class="cursor-pointer text-xl">
                    📷
                </label>
                <input
                    type="file"
                    id="image-input"
                    name="images[]"
                    accept="image/*"
                    multiple
                    class="hidden"
                >

                <!-- テキスト入力 -->
                <input
                    id="message-input"
                    type="text"
                    class="flex-1 border rounded px-3 py-2 text-sm"
                    placeholder="メッセージを入力"
                    autocomplete="off"
                >

                <!-- 送信 -->
                <button
                    type="submit"
                    class="bg-blue-500 text-white px-4 py-2 rounded text-sm"
                >
                    送信
                </button>
            </div>
        </form>

    </div>
</div>
@endsection



@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {

    const form        = document.getElementById('message-form');
    const input       = document.getElementById('message-input');
    const imageInp    = document.getElementById('image-input');
    const previewBox  = document.getElementById('image-preview');
    const messages    = document.getElementById('messages');
    const chatBox     = document.getElementById('chat-box');

    const myId   = "{{ session()->getId() }}";
    const myName = "{{ auth()->check() ? auth()->user()->name : 'ゲスト' }}";

    let selectedImages = [];

    /* ==========================
        画像選択 → プレビュー
    ========================== */
    imageInp.addEventListener('change', () => {
        previewBox.innerHTML = '';
        selectedImages = Array.from(imageInp.files);

        if (selectedImages.length === 0) {
            previewBox.classList.add('hidden');
            return;
        }

        previewBox.classList.remove('hidden');

        selectedImages.forEach((file, index) => {
            const wrapper = document.createElement('div');
            wrapper.className = 'relative';

            const img = document.createElement('img');
            img.src = URL.createObjectURL(file);
            img.className = 'w-20 h-20 object-cover rounded';

            const remove = document.createElement('button');
            remove.textContent = '×';
            remove.className = 'absolute -top-2 -right-2 bg-black text-white rounded-full w-5 h-5 text-xs';
            remove.onclick = () => {
                selectedImages.splice(index, 1);
                updateFileInput();
            };

            wrapper.appendChild(img);
            wrapper.appendChild(remove);
            previewBox.appendChild(wrapper);
        });
    });

    function updateFileInput() {
        const dt = new DataTransfer();
        selectedImages.forEach(f => dt.items.add(f));
        imageInp.files = dt.files;
        imageInp.dispatchEvent(new Event('change'));
    }

    /* ==========================
        メッセージ描画
    ========================== */
    function appendMessage(name, text, imageUrls, isMine) {

        const li = document.createElement('li');
        li.className = `flex ${isMine ? 'justify-end' : 'justify-start'}`;

        const bubble = document.createElement('div');
        bubble.className = `
            relative max-w-[70%] px-3 py-2 rounded-lg text-sm
            ${isMine ? 'bg-blue-500 text-white' : 'bg-gray-200 text-gray-900'}
        `;

        const nameDiv = document.createElement('div');
        nameDiv.className = 'text-xs opacity-70 mb-1';
        nameDiv.textContent = name;
        bubble.appendChild(nameDiv);

        if (text) {
            const textDiv = document.createElement('div');
            textDiv.className = 'whitespace-pre-wrap break-words';
            textDiv.textContent = text;
            bubble.appendChild(textDiv);
        }

        if (imageUrls?.length) {
            imageUrls.forEach(url => {
                const img = document.createElement('img');
                img.src = url;
                img.className = 'mt-2 rounded-lg max-w-full cursor-pointer';
                img.onclick = () => window.open(url, '_blank');
                bubble.appendChild(img);
            });
        }

        li.appendChild(bubble);
        messages.appendChild(li);
        chatBox.scrollTop = chatBox.scrollHeight;
    }

    /* ==========================
        送信
    ========================== */
    form.addEventListener('submit', async (e) => {
    e.preventDefault();

    const text = input.value.trim();
    const images = Array.from(imageInp.files);

    if (!text && images.length === 0) return;

    // 自分は即表示
    appendMessage(
        myName,
        text || null,
        images.map(img => URL.createObjectURL(img)),
        true
    );

    const formData = new FormData();
    formData.append('sender_id', myId);
    if (text) formData.append('message', text);
    images.forEach(img => formData.append('images[]', img));

    input.value = '';

    try {
        await axios.post('/chat/send', formData);

        // ✅ ここが超重要
        resetImageSelection();


    } catch (err) {
        console.error(err);
    }
});

    /* ==========================
        受信（自分は無視）
    ========================== */
    window.Echo.channel('chat')
    .listen('.message.sent', (e) => {

        if (e.senderId === myId) return;

        appendMessage(
        e.senderName,
        e.message,
        e.imageUrls ?? [],   // ← 必ず配列
        false
        );
    });

        function resetImageSelection() {
            selectedImages = [];
            imageInp.value = '';
            previewBox.innerHTML = '';
            previewBox.classList.add('hidden');
        }

});
</script>
@endpush



