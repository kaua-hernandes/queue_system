<?php

namespace App\Http\Controllers;

use App\Models\Queue;
use App\Models\QueueTicket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;

class MainController extends Controller
{
    public function index()
    {
        // get list of active queues for the authenticated user's company
        $data = [
            'subtitle' => 'Home',
            'queues' => $this->getQueuesList(),
            'companyName' => Auth::user()->company->company_name,
            'companyTotal' => $this->getCompanyTotals()
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

    private function getCompanyTotals()
    {
        $companyId = Auth::user()->id_company;
        $totalQueues = Queue::where('id_company', $companyId)->count();

        // get all tickets of the company
        $tickets = QueueTicket::whereHas('queue', function($query) use ($companyId){
            $query->where('id_company', $companyId);
        })->get();

        return [
            'total_queues' => $totalQueues,
            'total_tickets' => $tickets->count(),
            'total_dismissed' => $tickets->where('status', 'dismissed')->count(),
            'total_not_attended' => $tickets->where('status', 'non_attended')->count(),
            'total_called' => $tickets->where('status', 'called')->count(),
            'total_waiting' => $tickets->where('status', 'waiting')->count()
        ];
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
            ->withCount([
                'tickets as total_tickets' => function ($query) {
                    $query->whereNotNull('status')
                        ->whereNull('deleted_at');
                },
                'tickets as total_dismissed' => function ($query) {
                    $query->where('status', 'dismissed')
                        ->whereNull('deleted_at');
                },
                 'tickets as total_not_attended' => function ($query) {
                    $query->where('status', 'non_attended')
                        ->whereNull('deleted_at');
                },
                 'tickets as total_called' => function ($query) {
                    $query->where('status', 'called')
                        ->whereNull('deleted_at');
                }, 'tickets as total_waiting' => function ($query) {
                    $query->where('status', 'waiting')
                        ->whereNull('deleted_at');
                },
            ])
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

    public function createQueue()
    {
        $data = [
            'subtitle' => 'Criar fila'
        ];

        return view('main.queue_create_frm', $data);
    }

    public function createQueueSubmit(Request $request)
    {
        // validate the request
        $request->validate(
            [
                'name' => 'required|min:5|max:100',
                'description' => 'required|min:5|max:255',
                'service' => 'required|min:3|max:50',
                'desk' => 'required|min:1|max:20',
                'prefix' => 'required|regex:/^[A-Z\-]{1}$/',
                'total_digits' => 'required|integer|min:2|max:4',
                'color_1' => 'required|regex:/^\#[a-f0-9]{6}$/',
                'color_2' => 'required|regex:/^\#[a-f0-9]{6}$/',
                'color_3' => 'required|regex:/^\#[a-f0-9]{6}$/',
                'color_4' => 'required|regex:/^\#[a-f0-9]{6}$/',
                'hidden_hash_code' => 'required|size:64',
                'status' => 'required|in:active,inactive'
            ],
            [
                'name.required' => 'O nome da fila é obrigatório.',
                'name.min' => 'O nome da fila deve conter no mínimo 5 caracteres.',
                'name.max' => 'O nome da fila deve conter no máximo 100 caracteres.',
                'description.required' => 'A descrição da fila é obrigatória.',
                'description.min' => 'A descrição da fila deve conter no mínimo 5 caracteres.',
                'description.max' => 'A descrição da fila deve conter no máximo 255 caracteres.',
                'service.required' => 'O serviço da fila é obrigatório.',
                'service.min' => 'O serviço da fila deve conter no mínimo 3 caracteres.',
                'service.max' => 'O serviço da fila deve conter no máximo 50 caracteres.',
                'desk.required' => 'O guichê da fila é obrigatório.',
                'desk.min' => 'O guichê da fila deve conter no mínimo 1 caracteres.',
                'desk.max' => 'O guichê da fila deve conter no máximo 20 caracteres.',
                'prefix.required' => 'O prefixo da fila é obrigatório.',
                'prefix.regex' => 'O prefixo da fila deve conter uma letra maiúscula seguida de um hífen (ex: A-).',
                'total_digits.required' => 'O total de dígitos é obrigatório.',
                'total_digits.integer' => 'O total de dígitos deve ser um número inteiro.',
                'total_digits.min' => 'O total de dígitos deve ser no mínimo 2.',
                'total_digits.max' => 'O total de dígitos deve ser no máximo 4.',
                'color_1.required' => 'A cor 1 é obrigatória.',
                'color_1.regex' => 'A cor 1 deve ser um código hexadecimal válido (ex: #ff0000).',
                'color_2.required' => 'A cor 2 é obrigatória.',
                'color_2.regex' => 'A cor 2 deve ser um código hexadecimal válido (ex: #ff0000).',
                'color_3.required' => 'A cor 3 é obrigatória.',
                'color_3.regex' => 'A cor 3 deve ser um código hexadecimal válido (ex: #ff0000).',
                'color_4.required' => 'A cor 4 é obrigatória.',
                'color_4.regex' => 'A cor 4 deve ser um código hexadecimal válido (ex: #ff0000).',
                'hidden_hash_code.required' => 'O código de hash é obrigatório.',
                'hidden_hash_code.size' => 'O código de hash deve conter exatamente 64 caracteres.',
                'status.required' => 'O status da fila é obrigatório.',
                'status.in' => 'O status da fila deve ser "active" ou "inactive".'
            ]
        );

        // check if the name of the queue is unique in the context of the company
        $companyId = Auth::user()->id_company;
        $queueExists = Queue::where('id_company', $companyId)
            ->where('name', $request->name)
            ->exists();
        if ($queueExists) {
            return redirect()->back()->withInput()->with(['server_error' => 'Já existe uma fila com esse nome. Por favor, escolha outro.']);
        }

        // check again if the hash code is unique
        $hashCode = $request->hidden_hash_code;
        $hashExists = Queue::where('hash_code', $hashCode)->exists();
        if ($hashExists) {
            return redirect()->back()->withInput()->with(['server_error' => 'O código de hash gerado já existe. Por favor, tente novamente.']);
        }
    }

    public function generateQueueHash()
    {
        // genarate a unique 64 chars hash code
        $hash = hash('sha256', Str::random(40));

        // make certain that the hash is unique
        while(Queue::where('hash_code', $hash)->exists()) {
            $hash = hash('sha256', Str::random(40));
        }

        // return the unique hash code as json
        return response()->json(['hash' => $hash]);
    }
}
