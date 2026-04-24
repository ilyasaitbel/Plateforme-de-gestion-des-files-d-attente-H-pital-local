<?php

namespace App\Http\Controllers;

use App\Models\Agent;
use App\Models\Citoyen;
use App\Models\Ticket;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->isAdmin()) {
            $admin = $user->administrator;

            if (! $admin->hospital) {
                return redirect()->route('hospitals.create');
            }

            $hospital = $admin->hospital;
            $ticketsQuery = Ticket::whereHas('queue.service', function ($query) use ($hospital) {
                $query->where('hospital_id', $hospital->id);
            });

            $hospitals_count = 1;
            $services_count = $hospital->services()->count();
            $agents_count = Agent::where('hospital_id', $hospital->id)->count();
            $citoyens_count = Citoyen::whereHas('tickets.queue.service', function ($query) use ($hospital) {
                $query->where('hospital_id', $hospital->id);
            })->count();
            $tickets_count = (clone $ticketsQuery)
                ->whereDate('created_at', today())
                ->count();
            $pending_tickets = (clone $ticketsQuery)
                ->where('status', 'EN_ATTENTE')
                ->count();
            $finished_tickets = (clone $ticketsQuery)
                ->where('status', 'TERMINE')
                ->count();

            return view('dashboard.admin', compact(
                'hospital',
                'hospitals_count',
                'services_count',
                'agents_count',
                'citoyens_count',
                'tickets_count',
                'pending_tickets',
                'finished_tickets'
            ));
        }

        if ($user->isAgent()) {
            $agent = $user->agent;
            $agent?->load('hospital', 'queue.service');

            $current_queue = $agent?->queue?->load('service.hospital');
            $hospital = $agent?->hospital ?? optional(optional($current_queue)->service)->hospital;
            $queues = $current_queue ? collect([$current_queue]) : collect();
            $waiting_tickets = collect();
            $waiting_count = 0;
            $current_ticket = null;
            $total_today = 0;

            if ($current_queue) {
                $waiting_tickets = Ticket::with('citoyen.user')
                    ->where('queue_id', $current_queue->id)
                    ->where('status', 'EN_ATTENTE')
                    ->orderBy('id')
                    ->get();

                $waiting_count = $waiting_tickets->count();

                $current_ticket = Ticket::with('citoyen.user')
                    ->where('queue_id', $current_queue->id)
                    ->whereIn('status', ['APPELE', 'EN_COURS'])
                    ->latest('updated_at')
                    ->first();

                $total_today = Ticket::where('queue_id', $current_queue->id)
                    ->whereDate('created_at', today())
                    ->count();
            }

            return view('dashboard.agent', compact(
                'queues',
                'hospital',
                'current_queue',
                'waiting_tickets',
                'waiting_count',
                'current_ticket',
                'total_today'
            ));
        }

        if ($user->isCitoyen()) {
            $citoyen = $user->citoyen;
            $active_ticket = null;
            $ticket_history = collect();
            $queue_position = null;
            $estimated_wait = null;

            if ($citoyen) {
                $tickets = $citoyen->tickets()->with('queue.service.hospital');

                $active_ticket = (clone $tickets)
                    ->whereIn('status', ['EN_ATTENTE', 'APPELE', 'EN_COURS'])
                    ->latest()
                    ->first();

                $ticket_history = (clone $tickets)
                    ->latest()
                    ->get();

                if ($active_ticket && $active_ticket->status === 'EN_ATTENTE') {
                    $queue_position = Ticket::where('queue_id', $active_ticket->queue_id)
                        ->where('status', 'EN_ATTENTE')
                        ->where('number', '<=', $active_ticket->number)
                        ->count();

                    $estimated_wait = max(($queue_position - 1) * 5, 0) . ' min';
                } elseif ($active_ticket) {
                    $queue_position = 0;
                    $estimated_wait = 'Bientôt';
                }
            }

            return view('dashboard.citoyen', compact(
                'active_ticket',
                'ticket_history',
                'queue_position',
                'estimated_wait'
            ));
        }

        return redirect()->route('login');
    }
}
