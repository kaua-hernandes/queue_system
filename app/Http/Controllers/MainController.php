<?php

namespace App\Http\Controllers;

use App\Models\Queue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class MainController extends Controller
{
    public function index()
    {
        // get list of active queues for the authenticated user's company
        $queues = $this->getQueuesList();

        $data = [
            'subtitle' => 'Home',
            'queues' => $queues
        ];

        return view('main.home', $data);
    }

    private function getQueuesList()
    {
        $companyId = Auth::user()->id_company;

        return Queue::where('id_company', $companyId)
            //->where('status', 'active')
            ->whereNull('deleted_at')
            ->withCount([
                'tickets as total_tickets' => function ($query) {
                    $query->whereNotNull('status')
                        ->whereNull('deleted_at');
                },
                'tickets as total_dismissed' => function ($query) {
                    $query->where('status', 'dismissed')
                        ->whereNull('deleted_at');
                },
                'tickets as total_non_attended' => function ($query) {
                    $query->where('status', 'non_attended')
                        ->whereNull('deleted_at');
                },
                'tickets as total_called' => function ($query) {
                    $query->where('status', 'called')
                        ->whereNull('deleted_at');
                },
                'tickets as total_waiting' => function ($query) {
                    $query->where('status', 'waiting')
                        ->whereNull('deleted_at');
                }
            ])
            ->get();
    }

    public function queueDetails($id)
    {
        // try decrypting the id
        try {
            $id = Crypt::decrypt($id);
        } catch (\Exception $e) {
            abort(403, 'Id de fila inválido.');
        }

        // check if the queue exists and belongs to the authenticated user's company
        $queue = Queue::where('id', $id)
            ->where('id_company', Auth::user()->id_company)
            ->firstOrFail();

        if (!$queue) {
            abort(404, 'Fila não encontrada.');
        }

        // get the tickets from the queue
        $tickets = $queue->tickets()->get();

        $data = [
            'subtitle' => 'Detalhes da Fila',
            'queue' => $queue,
            'tickets' => $tickets
        ];

        return view('main.queue_details', $data);
    }
}
