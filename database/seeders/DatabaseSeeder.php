<?php

namespace Database\Seeders;

use App\Models\Administrator;
use App\Models\Agent;
use App\Models\Citoyen;
use App\Models\Hospital;
use App\Models\Queue;
use App\Models\Service;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $adminUser = User::create([
            'name'     => 'Admin User',
            'email'    => 'admin@hospital.local',
            'password' => bcrypt('password123'),
        ]);

        Administrator::create([
            'user_id' => $adminUser->id,
        ]);

        $agentUser = User::create([
            'name'     => 'Agent User',
            'email'    => 'agent@hospital.local',
            'password' => bcrypt('password123'),
        ]);

        $citoyenUser = User::create([
            'name'     => 'Citoyen User',
            'email'    => 'citoyen@hospital.local',
            'password' => bcrypt('password123'),
        ]);

        $hospital = Hospital::create([
            'name'    => 'Local Hospital',
            'address' => 'Main Avenue, Casablanca',
            'phone'   => '+212600000000',
        ]);

        $citoyen = Citoyen::create([
            'user_id' => $citoyenUser->id,
        ]);

        $service = Service::create([
            'hospital_id' => $hospital->id,
            'name'        => 'General Consultation',
            'description' => 'Walk-in consultation service',
        ]);

        $queue = Queue::create([
            'service_id'     => $service->id,
            'name'           => 'Consultation Queue',
            'current_number' => 0,
            'status'         => 'OPEN',
        ]);

        Agent::create([
            'user_id'  => $agentUser->id,
            'queue_id' => $queue->id,
        ]);

        Ticket::create([
            'queue_id'   => $queue->id,
            'citoyen_id' => $citoyen->id,
            'number'     => 1,
            'status'     => 'EN_ATTENTE',
        ]);
    }
}
