<form method="POST" action="{{ route('login') }}">
    @csrf

    <!-- Email -->
    <div>
        <label for="email">Email</label>
        <input id="email" type="email" name="email" required autofocus>
    </div>

    <!-- Password -->
    <div class="mt-4">
        <label for="password">Password</label>
        <input id="password" type="password" name="password" required>
    </div>

    <button type="submit">ログイン</button>
</form>
