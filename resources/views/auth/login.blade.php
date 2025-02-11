<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-gray-100">
        <div class="w-full max-w-md p-6 bg-white rounded-lg shadow-md">
            <div class="text-center mb-6">
                <a href="/">
                </a>
                <h2 class="mt-4 text-2xl font-bold text-gray-800">Bem-vindo de volta!</h2>
                <p class="text-sm text-gray-600">Faça login para continuar.</p>
            </div>

            <x-jet-validation-errors class="mb-4" />

            @if (session('status'))
                <div class="mb-4 p-3 bg-green-100 text-green-800 rounded-lg text-center">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="space-y-4">
                @csrf

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input id="email" name="email" type="email" required autofocus class="w-full mt-1 px-4 py-2 border rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500" placeholder="Seu email">
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">Senha</label>
                    <input id="password" name="password" type="password" required class="w-full mt-1 px-4 py-2 border rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500" placeholder="Sua senha">
                </div>

                <div class="flex items-center justify-between">
                    <label for="remember_me" class="flex items-center text-sm text-gray-600">
                        <input id="remember_me" name="remember" type="checkbox" class="form-checkbox">
                        <span class="ml-2">Lembrar de mim</span>
                    </label>
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="text-sm text-blue-600 hover:underline">Esqueceu sua senha?</a>
                    @endif
                </div>

                <div>
                    <button type="submit" class="w-full bg-blue-600 text-white font-semibold py-2 px-4 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        Entrar
                    </button>
                </div>
            </form>

            <p class="mt-4 text-center text-sm text-gray-600">
                Não tem uma conta? 
                <a href="{{ route('register') }}" class="text-blue-600 hover:underline">Cadastre-se</a>
            </p>
        </div>
    </div>
</x-guest-layout>
