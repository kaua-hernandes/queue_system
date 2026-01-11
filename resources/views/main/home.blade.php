<x-layouts.auth-layout subtitle="{{ empty($subtitle) ? '' : $subtitle }}">

    @if (session()->has('message'))
        ;
        <div class="bg-green-800 text-white p-2 rounded-lg w-full mn-4" id=home_message>
            {{ session('message') }}
        </div>
    @endif

    <div class="main-card overflow-auto">

        <p class="title-2">Filas de espera</p>

        <hr class="mt-2 mb-4">

        <div class="mb-4">
            <a href="#" class="btn"><i class="far fa-plus me-2"></i>Criar nova fila...</a>
        </div>

        @if ($queues->count() === 0)
            <div class="text-center my-12 text-gray-500">
                <p class="text-lg">Não existem filas de espera criadas.</p>
                <p class="text-sm">Clique no botão acima, para criar uma nova fila.</p>
            </div>
        @else
        @endif
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
                    <tr>
                        <td>{{ $queue->name }}</td>
                        <td>{{ $queue->service_name }}</td>
                        <td>{{ $queue->service_desk }}</td>
                        <td>{!! getQueueStateIcon($queue->status) !!}</td>
                        <td>{{ $queue->total_tickets }}</td>
                        <td>{{ $queue->total_dismissed }}</td>
                        <td>{{ $queue->total_non_attended }}</td>
                        <td>{{ $queue->total_called }}</td>
                        <td>{{ $queue->total_waiting }}</td>
                        <td class="text-right">
                            <a href="{{ route('queues.details', ['id' => Crypt::encrypt($queue->id)]) }}"
                                class="btn-white" title="Detalhes"><i class="fa-solid fa-bars"></i></a>
                            <a href="#" class="btn-white" title="Editar"><i
                                    class="fa-regular fa-pen-to-square"></i></a>
                            <a href="#" class="btn-white" title="Duplicar"><i class="fa-regular fa-clone"></i></a>
                            <a href="#" class="btn-red" title="Eliminar"><i
                                    class="fa-regular fa-trash-can"></i></a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

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
