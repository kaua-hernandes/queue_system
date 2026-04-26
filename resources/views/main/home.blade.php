<x-layouts.auth-layout subtitle="{{ empty($subtitle) ? '' : $subtitle }}">

    @if (session()->has('message'))
        ;
        <div class="bg-green-800 text-white p-2 rounded-lg w-full mn-4" id=home_message>
            {{ session('message') }}
        </div>
    @endif

    <div class="main-card overflow-auto">

        <div class="flex justify-between items-center">
            <p class="title-2">Filas de espera</p>
            <p class="title-3">Empresa: <strong>{{ $companyName }}</strong></p>
        </div>


        <hr class="my-4">

        <div class="mb-4">
            <a href="{{ route('queue.create') }}" class="btn"><i class="far fa-plus me-2"></i>Criar nova fila...</a>
        </div>

        @if ($queues->count() === 0)
            <div class="text-center my-12 text-gray-500">
                <p class="text-lg">Não existem filas de espera criadas.</p>
                <p class="text-sm">Clique no botão acima, para criar uma nova fila.</p>
            </div>
        @else
            <div class="flex justify-between gap-4 my-4">
                <div
                    class="bg-gradient-to-b from-slate-200 to-slate-50 border-slate-300 rounded-xl w-full p-4 text-center text-xl">
                    Total Filas<br><strong class="text-3xl">{{ $companyTotal['total_queues'] }}</strong>
                </div>
                <div
                    class="bg-gradient-to-b from-slate-200 to-slate-50 border-slate-300 rounded-xl w-full p-4 text-center text-xl">
                    Total tickets<br><strong class="text-3xl">{{ $companyTotal['total_tickets'] }}</strong>
                </div>
                <div
                    class="bg-gradient-to-b from-slate-200 to-slate-50 border-slate-300 rounded-xl w-full p-4 text-center text-xl">
                    Total dispensados<br><strong class="text-3xl">{{ $companyTotal['total_dismissed'] }}</strong>
                </div>
                <div
                    class="bg-gradient-to-b from-slate-200 to-slate-50 border-slate-300 rounded-xl w-full p-4 text-center text-xl">
                    Total não atendidos<br><strong class="text-3xl">{{ $companyTotal['total_not_attended'] }}</strong>
                </div>
                <div
                    class="bg-gradient-to-b from-slate-200 to-slate-50 border-slate-300 rounded-xl w-full p-4 text-center text-xl">
                    Total chamados<br><strong class="text-3xl">{{ $companyTotal['total_called'] }}</strong>
                </div>
                <div
                    class="bg-gradient-to-b from-slate-200 to-slate-50 border-slate-300 rounded-xl w-full p-4 text-center text-xl">
                    Total em espera<br><strong class="text-3xl">{{ $companyTotal['total_waiting'] }}</strong>
                </div>
            </div>

            <table id="tabela">
                <thead class="bg-black text-white">
                    <tr>
                        <th class="text-xs w-2/14">Nome</th>
                        <th class="text-xs w-2/14">Serviço</th>
                        <th class="text-xs w-2/14">Balcão</th>
                        <th class="text-xs w-1/14 text-center">Estado</th>
                        <th class="text-xs text-center w-1/14">Tickets</th>
                        <th class="text-xs text-center w-1/14">Ignorados</th>
                        <th class="text-xs text-center w-1/14">Não atendidos</th>
                        <th class="text-xs text-center w-1/14">Atendidos</th>
                        <th class="text-xs text-center w-1/14">Em espera</th>
                        <th class="text-xs text-center w-2/14"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($queues as $queue)
                        <tr class="{{ $queue->deleted_at !== null ? 'text-red-500' : '' }}">
                            <td>{{ $queue->name }}</td>
                            <td>{{ $queue->service_name }}</td>
                            <td>{{ $queue->service_desk }}</td>
                            @if ($queue->deleted_at === null)
                                <td>{!! getQueueStateIcon($queue->status) !!}</td>
                            @else
                                <td><i class="fa-regular fa-trash-can"></i></td>
                            @endif

                            <td>{{ $queue->total_tickets }}</td>
                            <td>{{ $queue->total_dismissed }}</td>
                            <td>{{ $queue->total_non_attended }}</td>
                            <td>{{ $queue->total_called }}</td>
                            <td>{{ $queue->total_waiting }}</td>
                            <td class="text-right flex gap-2 justify-end">

                                @if ($queue->deleted_at === null)
                                    <a href="{{ route('queue.details', ['id' => Crypt::encrypt($queue->id)]) }}"
                                        class="btn-white" title="Detalhes"><i class="fa-solid fa-bars"></i></a>
                                    <a href="{{ route('queue.edit', ['id' => Crypt::encrypt($queue->id)]) }}"
                                        class="btn-white" title="Editar"><i class="fa-regular fa-pen-to-square"></i></a>
                                    <a href="{{ route('queue.clone', ['id' => Crypt::encrypt($queue->id)]) }}"
                                        class="btn-white" title="Duplicar"><i class="fa-regular fa-clone"></i></a>
                                    <a href="{{ route('queue.delete', ['id' => Crypt::encrypt($queue->id)]) }}"
                                        class="btn-red" title="Eliminar"><i class="fa-regular fa-trash-can"></i></a>
                                @else
                                    <a href="{{ route('queue.restore', ['id' => Crypt::encrypt($queue->id)]) }}"
                                        class="btn" title="Restaurar"><i class="fa-solid fa-trash-arrow-up"></i></a>
                                @endif

                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
    </div>
    @endif


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const messageElement = document.getElementById('home_message');
            if (messageElement) {
                setTimeout(() => {
                    messageElement.style.display = 'none';
                }, 3000);
            }

            $('#tabela').DataTable({
                language: {
                    url: "{{ asset('assets/datatables/pt-PT.json') }}"
                }
            });
        });
    </script>

</x-layouts.auth-layout>
