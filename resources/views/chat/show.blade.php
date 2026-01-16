@extends('layouts.app')

@section('content')
<div class="flex flex-col h-[calc(100vh-64px)] bg-gray-100">

    {{-- ■ チャットヘッダー --}}
    <div class="bg-white/95 backdrop-blur-sm shadow-sm px-4 py-3 flex items-center justify-between sticky top-0 z-20 border-b border-gray-200">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-full bg-gray-300 flex items-center justify-center text-white font-bold text-lg border border-gray-200 overflow-hidden">
                {{ substr($chatPartner->name, 0, 1) }}
            </div>
            <div>
                <h1 class="font-bold text-gray-900 text-lg leading-tight">
                    {{ $chatPartner->name }}
                </h1>
                <span class="text-xs text-gray-500">部屋: {{ $chatPartner->room_number ?? '-' }}</span>
            </div>
        </div>

        <a href="{{ route('matches.index') }}" 
           class="text-sm font-bold text-gray-500 hover:text-orange-600 px-3 py-1">
            ✕ 閉じる
        </a>
    </div>

    {{-- ■ メッセージエリア --}}
    {{-- ★重要修正: scroll-smooth クラスを削除しました（これが初期表示の邪魔をしていました） --}}
    <div id="chat-box" class="flex-1 overflow-y-auto px-3 py-4 space-y-4" style="scroll-behavior: auto;">
        @foreach($messages as $msg)
            @php
                $isMine = $msg->user_id === auth()->id();
            @endphp
            
            <div class="message-item flex w-full {{ $isMine ? 'justify-end' : 'justify-start' }}" data-message-id="{{ $msg->id }}">
                <div class="flex max-w-[90%] sm:max-w-[80%] {{ $isMine ? 'flex-row-reverse' : 'flex-row' }} gap-2 items-end">
                    
                    @if(!$isMine)
                        <div class="w-8 h-8 rounded-full bg-gray-300 flex-shrink-0 flex items-center justify-center text-white text-xs font-bold mb-1 shadow-sm">
                             {{ substr($chatPartner->name, 0, 1) }}
                        </div>
                    @endif

                    <div class="flex flex-col {{ $isMine ? 'items-end' : 'items-start' }}">
                        <div class="px-4 py-3 text-lg shadow-sm relative break-words leading-relaxed
                            @if($isMine)
                                bg-orange-500 text-white rounded-2xl rounded-tr-none
                            @else
                                bg-white text-gray-900 rounded-2xl rounded-tl-none border border-gray-200
                            @endif
                            "
                            style="min-width: 40px;">
                            {!! nl2br(e($msg->body)) !!}
                        </div>
                    </div>

                    <span class="text-[10px] text-gray-500 flex-shrink-0 mb-1 font-medium">
                        {{ $msg->created_at->format('H:i') }}
                    </span>
                </div>
            </div>
        @endforeach

        <div id="no-message-notice" class="{{ $messages->isEmpty() ? '' : 'hidden' }} text-center py-10 opacity-60">
            <p class="text-sm text-gray-500">ここから会話が始まります</p>
        </div>
        
        <div class="h-2"></div>
    </div>

    {{-- ■ 送信フォームエリア --}}
    <div class="bg-white border-t border-gray-200 p-3 sticky bottom-0 z-20 pb-safe">
        <form action="{{ route('chat.store', $interest_request) }}" method="POST" class="flex items-end gap-2 w-full max-w-4xl mx-auto">
            @csrf
            <div class="relative flex-1 min-w-0">
                <textarea
                    name="body"
                    rows="1"
                    required
                    class="block w-full bg-gray-100 border border-gray-300 focus:ring-2 focus:ring-blue-300 focus:border-blue-500 text-gray-900 text-lg rounded-3xl px-5 py-3 resize-none leading-normal placeholder-gray-500"
                    placeholder="メッセージを入力"
                    style="min-height: 54px; max-height: 150px;"
                ></textarea>
            </div>
            <button type="submit" 
                class="flex-none rounded-full flex items-center justify-center shadow-md transition-all active:scale-95 text-white mb-1 hover:brightness-110"
                style="width: 56px; height: 56px; background-color: #2563eb; min-width: 56px;">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-7 h-7 ml-0.5">
                    <path d="M3.478 2.405a.75.75 0 00-.926.94l2.432 7.905H13.5a.75.75 0 010 1.5H4.984l-2.432 7.905a.75.75 0 00.926.94 60.519 60.519 0 0018.445-8.986.75.75 0 000-1.218A60.517 60.517 0 003.478 2.405z" />
                </svg>
            </button>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const chatBox = document.getElementById('chat-box');
        
        // ■ 1. スクロール問題の解決（画面を開いた瞬間に一番下へ）
        // CSSの scroll-smooth があると邪魔をするので、強制的に瞬間移動させます
        if (chatBox) {
            chatBox.style.scrollBehavior = 'auto'; // なめらか設定を無効化
            chatBox.scrollTop = chatBox.scrollHeight; // 一番下へドン！
            
            // 念のため、画像読み込み後(0.1秒後)にもう一度実行
            setTimeout(() => {
                chatBox.scrollTop = chatBox.scrollHeight;
                // ここで初めて「なめらかスクロール」を有効に戻す（新着メッセージ用）
                chatBox.style.scrollBehavior = 'smooth'; 
            }, 100);
        }

        // ■ 2. 自動更新システム
        const requestId = "{{ $interest_request->id }}"; 
        const fetchUrl = "/chat/" + requestId + "/new-messages";

        setInterval(() => {
            const messages = document.querySelectorAll('.message-item');
            const lastId = messages.length > 0 
                ? messages[messages.length - 1].getAttribute('data-message-id') 
                : 0;

            // データ取得開始
            fetch(fetchUrl + "?last_id=" + lastId, {
                headers: {
                    'Accept': 'application/json', // 「HTMLじゃなくてデータをくれ！」と指定
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.text()) // ★重要：まずは文字として受け取る
            .then(text => {
                try {
                    // ここでJSON（データ）に変換してみる
                    const data = JSON.parse(text);

                    // 成功したら処理を続行
                    if (data.length > 0) {
                        const noMessageNotice = document.getElementById('no-message-notice');
                        if(noMessageNotice) noMessageNotice.classList.add('hidden');

                        data.forEach(msg => {
                            if (!document.querySelector(`.message-item[data-message-id="${msg.id}"]`)) {
                                const html = createMessageHtml(msg);
                                chatBox.insertAdjacentHTML('beforeend', html);
                            }
                        });
                        // 新着が来たらスクロール
                        chatBox.scrollTo({ top: chatBox.scrollHeight, behavior: 'smooth' });
                    }
                } catch (e) {
                    // ★★★ ここが重要 ★★★
                    // JSONへの変換に失敗＝HTML（エラー画面）が返ってきている！
                    console.error("【エラー検出】サーバーからデータではなくHTMLが返ってきました。");
                    console.error("▼ 返ってきた内容の先頭:");
                    console.log(text.substring(0, 200)); // エラー画面の正体を表示
                }
            })
            .catch(error => console.error('通信エラー:', error));
        }, 3000); // 3秒ごとに更新

        // メッセージ作成関数
        function createMessageHtml(msg) {
            const isMine = msg.is_mine;
            const partnerIconHtml = !isMine ? `
                <div class="w-8 h-8 rounded-full bg-gray-300 flex-shrink-0 flex items-center justify-center text-white text-xs font-bold mb-1 shadow-sm">
                    ${msg.partner_initial}
                </div>
            ` : '';
            const bubbleClass = isMine 
                ? 'bg-orange-500 text-white rounded-2xl rounded-tr-none' 
                : 'bg-white text-gray-900 rounded-2xl rounded-tl-none border border-gray-200';

            return `
                <div class="message-item flex w-full ${isMine ? 'justify-end' : 'justify-start'} animate-fade-in-up" data-message-id="${msg.id}">
                    <div class="flex max-w-[90%] sm:max-w-[80%] ${isMine ? 'flex-row-reverse' : 'flex-row'} gap-2 items-end">
                        ${partnerIconHtml}
                        <div class="flex flex-col ${isMine ? 'items-end' : 'items-start'}">
                            <div class="px-4 py-3 text-lg shadow-sm relative break-words leading-relaxed ${bubbleClass}" style="min-width: 40px;">
                                ${msg.body}
                            </div>
                        </div>
                        <span class="text-[10px] text-gray-500 flex-shrink-0 mb-1 font-medium">
                            ${msg.created_at}
                        </span>
                    </div>
                </div>
            `;
        }
    });
</script>

<style>
    /* 新着メッセージ用のアニメーション */
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-fade-in-up {
        animation: fadeInUp 0.3s ease-out forwards;
    }
</style>
@endpush