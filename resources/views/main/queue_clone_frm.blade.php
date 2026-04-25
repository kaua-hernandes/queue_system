<x-layouts.auth-layout subtitle="{{ empty($subtitle) ? '' : $subtitle }}">

    <div class="main-card overflow-auto">

        <div class="flex justify-between items-center">
            <p class="title-2">Duplicar fila de espera</p>
            <a href="{{ route('home') }}" class="btn"><i class="fa-solid fa-arrow-left me-2"></i>Voltar</a>
        </div>

        <hr class="my-4">

        <form action="{{ route('queue.clone.submit') }}" method="post" novalidate>

            @csrf

            <input type="hidden" name="original_queue_id" value="{{ Crypt::encrypt($queue->id) }}">

            <p class="text-slate-600 mb-4">Fila original: <strong>{{ $queue->name }}</strong></p>

            <p class="text-sm text-slate-400 mb-4"><i class="fa-solid fa-circle-info me-2 text-yellow-500"></i>A
                duplicação da fila atual não vai duplicar os tickets da fila.</p>

            <div class="flex flex-col w-1/2 mb-4">
                <label for="name" class="label">Nome da nova fila</label>
                <input type="text" name="name" id="name" class="input"
                    value="{{ old('name', $queue->name) }}" autofocus>
                {!! showValidationError($errors, 'name') !!}
                {!! showServerError() !!}
            </div>

            <button type="submit" class="btn">Duplicar fila</button>

        </form>

    </div>

</x-layouts.auth-layout>
