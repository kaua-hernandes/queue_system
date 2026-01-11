<x-layouts.auth-layout subtitle="{{ empty($subtitle) ? '' : $subtitle }}">

    <div class="flex justify-center mt-10">

        <div class="main-card w-150">

            <p class="title-2 mb-4">Alterar senha</p>

            <p class="text-sm text-zinc-400 mb-4">
                A senha deve ter entre 6 e 16 caracteres, uma letra maiúscula, uma letra minúscula e um dígito.
            </p>

            <form action="{{ route('change.password.submit') }}" method="POST" novalidate>

                @csrf

                <div class="mb-4">
                    <label for="current_password" class="label">Senha atual</label>
                    <input type="password" class="input w-full" id="current_password" name="current_password"
                        placeholder="Senha atual">
                    {!! showValidationError($errors, 'current_password') !!}
                    {!! showServerError() !!}
                </div>

                <div class="mb-4">
                    <label for="new_password" class="label">Nova senha</label>
                    <input type="password" class="input w-full" id="new_password" name="new_password"
                        placeholder="Nova senha">
                    {!! showValidationError($errors, 'new_password') !!}
                </div>

                <div class="mb-4">
                    <label for="new_password_confirmation" class="label">Repetir senha</label>
                    <input type="password" class="input w-full" id="new_password_confirmation"
                        name="new_password_confirmation" placeholder="Repetir nova senha">
                    {!! showValidationError($errors, 'new_password_confirmation') !!}

                </div>

                <button type="submit" class="btn w-full mb-4">Alterar senha</button>

            </form>

        </div>

    </div>

</x-layouts.auth-layout>
