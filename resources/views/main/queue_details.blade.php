<x-layouts.auth-layout subtitle="{{ empty($subtitle) ? '' : $subtitle }}">

    <div class="main-card overflow-auto">

        <div class="flex justify-between items-center">
            <p class="title-2">Fila de espera</p>
            <a href="{{ route('home') }}" class="btn"><i class="fa-solid fa-arrow-left me-2"></i>Voltar</a>
        </div>

        <hr class="mt-2 mb-4">

        <p class="bg-zinc-100 border-1 border-slate-300 rounded-md w-full p-2 mb-4">Nome: <span
                class="text-black font-bold">{{ $queue->name }}</span></p>
        <p class="bg-zinc-100 border-1 border-slate-300 rounded-md w-full p-2 mb-4">Descrição: <span
                class="text-black font-bold">{{ $queue->description }}</span></p>

        <div class="flex gap-4 mb-4">
            <p class="bg-zinc-100 border-1 border-slate-300 rounded-md w-1/2 p-2">Serviço: <span
                    class="text-black font-bold">{{ $queue->service_name }}</span></p>
            <p class="bg-zinc-100 border-1 border-slate-300 rounded-md w-1/2 p-2">Balcão: <span
                    class="text-black font-bold">{{ $queue->service_desk }}</span></p>
            <p class="bg-zinc-100 border-1 border-slate-300 rounded-md w-full p-2">Formato: <span
                    class="text-black font-bold">{{ getFormattedTicketNumber(0, $queue->queue_prefix, $queue->queue_total_digits) }}</span>
            </p>
        </div>

        <div class="flex gap-4 mb-4">
            <p class="bg-zinc-100 border-1 border-slate-300 rounded-md w-1/2 p-2">Estado: <span
                    class="text-black font-bold">{{ getQueueStateText($queue->status)  }}</span></p>
            <p class="bg-zinc-100 border-1 border-slate-300 rounded-md w-1/2 p-2">Criada em: <span
                    class="text-black font-bold">{{ $queue->created_at }}</span></p>
            <p class="bg-zinc-100 border-1 border-slate-300 rounded-md w-full p-2">Código: <span
                    class="text-black font-bold">{{ $queue->hash_code }}</span></p>
        </div>

        <hr class="mt-2 mb-4">

        <p class="title-2">Tickets da fila de espera</p>

        @if ($tickets->count() === 0)
            <p class="text-xl text-center text-gray-400 my-12">Não existem <i>tickets</i> nesta fila.</p>
        @else
            <table id="table-tickets">
                <thead class="bg-black text-white">
                    <tr>
                        <th class="w-1/10">Número</th>
                        <th class="w-2/10">Criada em</th>
                        <th class="w-2/10">Estado</th>
                        <th class="w-2/10">Chamada em</th>
                        <th class="w-3/10">Atendida por</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($tickets as $ticket)
                        <tr class="border-1 border-slate-300">
                            <td class="border-1 border-slate-300">
                                {{ getFormattedTicketNumber($ticket->queue_ticket_number,$queue->queue_total_digits, $queue->queue_prefix) }}
                            </td>
                            <td class="border-1 border-slate-300">{{ $ticket->queue_ticket_created_at }}</td>
                            <td class="border-1 border-slate-300">{{ getTicketStateText($ticket->status) }}</td>
                            <td class="border-1 border-slate-300">{{ $ticket->queue_ticket_called_at ?? '-' }}</td>
                            <td class="border-1 border-slate-300">{{ $ticket->queue_ticket_called_by ?? '-' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif

    </div>

    <script>
        $(document).ready(function() {
            $('#table-tickets').DataTable({
                language: {
                    url: "{{ asset('assets/datatables/pt-PT.json') }}"
                },
            });
        });
    </script>


</x-layouts.auth-layout>
