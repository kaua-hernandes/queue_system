<x-layouts.auth-layout subtitle="{{ empty($subtitle) ? '' : $subtitle }}">

    <div class="main-card overflow-auto">
        <p class="title-2">Eliminar fila de espera</p>

        <hr class="my-4">

        <p class="text-slate-600 mb-4 text-center">Tem a certeza de que pretende eliminar a fila de espera"?</p>

        <p class="text-lg text-zinc-600 font-bold mb-4 text-center">{{ $queue->name }}</p>

        <p class="text-sm text-slate-400 bold mb-4 text-center">{{ $queue->hash_code }}</p>

        <p class="text-sm text-slate-400 mb-4 text-center">Esta operação é reversível.</p>

        <div class="flex justify-center gap-4">
            <a href="{{ route('home') }}" class="btn !px-8">Não</a>
            <a href="{{ route('queue.delete.confirm', ['id' => Crypt::encrypt($queue->id)]) }}" class="btn-red !px-8">Sim</a>
        </div>
    </div>

</x-layouts.auth-layout>
