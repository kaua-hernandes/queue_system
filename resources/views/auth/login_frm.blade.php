<x-layouts.guest-layout subtitle="{{ empty($subtitle) ? '' : $subtitle }}">

<div class="flex flex-col justify-center h-screen items-center">

    <div class="main-card w-100">

        <div class="flex justify-center items-center mb-8">
            <img src="{{ asset('assets/images/favicon.png') }}" class="w-10 h-10 me-2" alt="Logo">
            <h3 class="text-3xl uppercase">{{ config('app.name') }}</h3>
        </div>

        <form action="{{ route('login.submit') }}" method="post" novalidate>

            @csrf

            <div class="mb-4">
                <label for="username" class="label">Usuário</label>
                <input type="email" class="input w-full" id="username" name="username" placeholder="Usuário" value="{{ old('username') }}">
                {!! showValidationError($errors, 'username') !!}
                {!! showServerError() !!}
            </div>

            <div class="mb-4">
                <label for="password" class="label">Senha</label>
                <input type="password" class="input w-full" id="password" name="password" placeholder="Senha">
                {!! showValidationError($errors, 'password') !!}
            </div>

            <div class="text-center mb-4">
                <button type="submit" class="btn w-full">Entrar</button>
            </div>

        </form>

        <div class="text-center">
            Esqueceu a senha? <a href="#" class="link">Clique aqui</a>
        </div>

    </div>

    <div class="flex justify-center items-center text-xs text-zinc-700 mt-4">
        Versão <a href="#" class="link ms-2">{{ config('constants.APP_VERSION') }}</a>
        <span class="mx-2">|</span>
        <a href="#" class="link">Termos de Utilização</a>
    </div>

</div>


</x-layouts.guest-layout>
