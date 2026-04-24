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
        // Boucle pour créer plusieurs hôpitaux
        for ($i = 1; $i <= 20; $i++) {

            // Création d’un hôpital
            $hospital = Hospital::create([
                'name'    => 'Hospital ' . $i,
                'address' => 'Address ' . $i . ', Casablanca',
                'phone'   => '+21260000' . $i,
            ]);

            // Création du manager (un seul par hôpital)
            $managerUser = User::create([
                'name'     => 'Manager ' . $i,
                'email'    => 'manager' . $i . '@hospital.local',
                'password' => bcrypt('123123'),
            ]);

            // Association manager → hôpital
            Administrator::create([
                'user_id'     => $managerUser->id,
                'hospital_id' => $hospital->id,
            ]);

            // Tableau pour stocker les files d’attente (queues)
            $queues = [];

            // Création des services et des queues
            for ($s = 1; $s <= 3; $s++) {

                // Création d’un service
                $service = Service::create([
                    'hospital_id' => $hospital->id,
                    'name'        => 'Service ' . $s . ' - H' . $i,
                    'description' => 'Description service ' . $s,
                ]);

                // Création d’une queue liée au service
                $queue = Queue::create([
                    'service_id'     => $service->id,
                    'name'           => 'Queue ' . $s . ' - H' . $i,
                    'current_number' => 0,
                    'status'         => 'OPEN',
                ]);

                // Ajout dans le tableau
                $queues[] = $queue;
            }

            // Création des agents
            for ($a = 1; $a <= 3; $a++) {

                $agentUser = User::create([
                    'name'     => 'Agent ' . $i . '_' . $a,
                    'email'    => 'agent' . $i . '_' . $a . '@hospital.local',
                    'password' => bcrypt('123123'),
                ]);

                // Affectation à une queue aléatoire
                $queue = $queues[array_rand($queues)];

                Agent::create([
                    'user_id'     => $agentUser->id,
                    'queue_id'    => $queue->id,
                    'hospital_id' => $hospital->id,
                ]);
            }

            // Initialisation d’un compteur pour chaque queue
            $queueCounters = [];
            foreach ($queues as $q) {
                $queueCounters[$q->id] = 1;
            }

            // Création des citoyens avec un seul ticket chacun
            for ($c = 1; $c <= 10; $c++) {

                $citoyenUser = User::create([
                    'name'     => 'Citoyen ' . $i . '_' . $c,
                    'email'    => 'citoyen' . $i . '_' . $c . '@hospital.local',
                    'password' => bcrypt('123123'),
                ]);

                $citoyen = Citoyen::create([
                    'user_id' => $citoyenUser->id,
                ]);

                // Choisir une queue aléatoirement
                $queue = $queues[array_rand($queues)];

                // Création d’un seul ticket par citoyen
                Ticket::create([
                    'queue_id'   => $queue->id,
                    'citoyen_id' => $citoyen->id,
                    'number'     => $queueCounters[$queue->id]++, // numéro unique par queue
                    'status'     => 'EN_ATTENTE',
                ]);
            }
        }
    }
}
