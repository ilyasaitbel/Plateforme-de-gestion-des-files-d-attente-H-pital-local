<?php

namespace Tests\Feature;

use App\Models\Agent;
use App\Models\Citoyen;
use App\Models\Hospital;
use App\Models\Queue;
use App\Models\Service;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class QueueBusinessRulesTest extends TestCase
{
    use RefreshDatabase;

    public function test_citoyen_cannot_have_two_active_tickets_for_same_service(): void
    {
        [$user, $citoyen] = $this->createCitoyenUser();

        $hospital = Hospital::create([
            'name' => 'Hopital Central',
            'address' => 'Rue 1',
            'phone' => '0500000000',
        ]);

        $service = Service::create([
            'hospital_id' => $hospital->id,
            'name' => 'Consultation',
            'description' => 'Service de consultation',
        ]);

        $firstQueue = Queue::create([
            'service_id' => $service->id,
            'name' => 'File A',
        ]);

        $secondQueue = Queue::create([
            'service_id' => $service->id,
            'name' => 'File B',
        ]);

        Ticket::create([
            'queue_id' => $firstQueue->id,
            'citoyen_id' => $citoyen->id,
            'number' => 1,
            'status' => Ticket::STATUS_EN_ATTENTE,
        ]);

        $response = $this->actingAs($user)->postJson("/data/queues/{$secondQueue->id}/generate-ticket", [
            'citoyen_id' => $citoyen->id,
        ]);

        $response
            ->assertStatus(422)
            ->assertJsonValidationErrors(['ticket']);
    }

    public function test_non_agent_cannot_update_ticket_status(): void
    {
        [$citoyenUser, $citoyen] = $this->createCitoyenUser();

        $ticket = $this->createTicketForCitoyen($citoyen);

        $this->actingAs($citoyenUser)
            ->patchJson("/data/tickets/{$ticket->id}/status", ['status' => Ticket::STATUS_APPELE])
            ->assertStatus(403);
    }

    public function test_citoyen_cannot_cancel_ticket_of_another_citoyen(): void
    {
        [$firstUser] = $this->createCitoyenUser();
        [, $secondCitoyen] = $this->createCitoyenUser();

        $ticket = $this->createTicketForCitoyen($secondCitoyen);

        $this->actingAs($firstUser)
            ->postJson("/data/tickets/{$ticket->id}/cancel")
            ->assertStatus(403);
    }

    public function test_agent_can_call_next_ticket_on_its_hospital_queue(): void
    {
        $hospital = Hospital::create([
            'name' => 'Hopital Local',
            'address' => 'Rue 2',
            'phone' => '0600000000',
        ]);

        $service = Service::create([
            'hospital_id' => $hospital->id,
            'name' => 'Urgences',
            'description' => 'Service urgence',
        ]);

        $queue = Queue::create([
            'service_id' => $service->id,
            'name' => 'Urgence A',
        ]);

        [, $citoyen] = $this->createCitoyenUser();
        $ticket = Ticket::create([
            'queue_id' => $queue->id,
            'citoyen_id' => $citoyen->id,
            'number' => 7,
            'status' => Ticket::STATUS_EN_ATTENTE,
        ]);

        $agentUser = User::factory()->create([
            'name' => 'Agent Test',
        ]);
        $agent = Agent::create([
            'user_id' => $agentUser->id,
            'hospital_id' => $hospital->id,
        ]);

        $this->actingAs($agentUser)
            ->postJson("/data/agents/{$agent->id}/call-next-ticket", ['queue_id' => $queue->id])
            ->assertStatus(200)
            ->assertJsonPath('status', Ticket::STATUS_APPELE)
            ->assertJsonPath('id', $ticket->id);

        $this->assertDatabaseHas('queues', [
            'id' => $queue->id,
            'current_number' => $ticket->number,
        ]);
    }

    private function createCitoyenUser(): array
    {
        $user = User::factory()->create([
            'name' => 'Citoyen Test',
        ]);

        $citoyen = Citoyen::create([
            'user_id' => $user->id,
        ]);

        return [$user, $citoyen];
    }

    private function createTicketForCitoyen(Citoyen $citoyen): Ticket
    {
        $hospital = Hospital::create([
            'name' => 'Hopital Ticket',
            'address' => 'Rue 3',
            'phone' => '0700000000',
        ]);

        $service = Service::create([
            'hospital_id' => $hospital->id,
            'name' => 'Laboratoire',
            'description' => 'Analyses',
        ]);

        $queue = Queue::create([
            'service_id' => $service->id,
            'name' => 'Lab A',
        ]);

        return Ticket::create([
            'queue_id' => $queue->id,
            'citoyen_id' => $citoyen->id,
            'number' => 1,
            'status' => Ticket::STATUS_EN_ATTENTE,
        ]);
    }
}
