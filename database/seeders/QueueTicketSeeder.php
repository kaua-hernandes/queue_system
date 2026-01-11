<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class QueueTicketSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // truncate queue_tickets table
        DB::table('queue_tickets')->truncate();

        $queueIDs = DB::table('queues')->pluck('id')->toArray();

        foreach ($queueIDs as $queueID)
        {
            $totalTickets = rand(50, 200);

            $createdAt = now();
            $calledAt = now()->addMinutes(2);

            for ($i = 0; $i < $totalTickets; $i++)
            {
                // determine status
                // 'waiting', 'called', 'not_attended', 'dimissed'
                $status = '';
                $statusTmp = rand(1,4);

                if ($statusTmp == 1) {
                    $status = 'waiting';
                } elseif ($statusTmp == 2) {
                    $status = 'called';
                } elseif ($statusTmp == 3) {
                    $status = 'non_attended';
                } elseif ($statusTmp == 4) {
                    $status = 'dismissed';
                }

                // create ticket
                DB::table('queue_tickets')->insert([
                    'id_queue' => $queueID,
                    'queue_ticket_number' => $i + 1,
                    'queue_ticket_created_at' => $createdAt,
                    'queue_ticket_called_at' => $status === 'called' ? $calledAt : null,
                    'queue_ticket_called_by' => $status === 'called' ? 'user_' . rand(1,10) : null,
                    'status' => $status,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);

                $createdAt = $createdAt->addMinutes(2);
                $calledAt = $calledAt->addMinutes(2);
            }
        }
    }
}
