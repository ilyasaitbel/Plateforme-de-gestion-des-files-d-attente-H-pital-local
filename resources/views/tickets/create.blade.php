@extends('layouts.app')

@section('title', 'Créer un ticket')

@section('content')
@php
    $selectedQueueId = old('queue_id', $agentQueue->id ?? old('queue_id'));
    $selectedService = $services->firstWhere('queue_id', (int) $selectedQueueId);
    $selectedHospitalId = old('hospital_id', $agentQueue->service->hospital->id ?? ($selectedService['hospital_id'] ?? ''));
    $isAgent = auth()->user()->isAgent();
@endphp

<style>
.ticket-create-shell {
    display: grid;
    gap: 24px;
}

.ticket-create-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 18px;
    padding: 28px;
    border-radius: 28px;
    background: linear-gradient(135deg, rgba(56, 189, 248, 0.16), rgba(255, 255, 255, 0.96));
    border: 1px solid rgba(56, 189, 248, 0.18);
    box-shadow: var(--shadow-soft);
}

.ticket-create-header h1 {
    font-size: 34px;
    font-weight: 900;
    letter-spacing: -0.04em;
    margin-bottom: 8px;
}

.ticket-create-header p {
    color: var(--text-soft);
    font-size: 15px;
    line-height: 1.7;
    max-width: 700px;
}

.ticket-create-badge {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-width: 76px;
    height: 76px;
    border-radius: 24px;
    background: linear-gradient(135deg, #38bdf8, #2563eb);
    box-shadow: 0 20px 40px rgba(37, 99, 235, 0.22);
    overflow: hidden;
}

.ticket-create-badge img {
    width: 36px;
    height: 36px;
    object-fit: contain;
    filter: drop-shadow(0 6px 12px rgba(0, 0, 0, 0.18));
}

.ticket-create-card {
    padding: 28px;
}

.ticket-create-grid {
    display: grid;
    grid-template-columns: repeat(2, minmax(0, 1fr));
    gap: 20px;
}

.ticket-field {
    display: grid;
    gap: 10px;
}

.ticket-field--full {
    grid-column: 1 / -1;
}

.ticket-field label {
    margin-bottom: 0;
    font-size: 15px;
}

.ticket-field small {
    color: var(--text-soft);
    font-size: 13px;
    line-height: 1.6;
}

.ticket-inline-note {
    display: none;
    margin-top: 8px;
    padding: 12px 14px;
    border-radius: 14px;
    font-size: 13px;
    font-weight: 600;
}

.ticket-inline-note.is-visible {
    display: block;
}

.ticket-inline-note.info {
    background: #eff6ff;
    color: #1d4ed8;
    border: 1px solid #bfdbfe;
}

.ticket-inline-note.warning {
    background: #fff7ed;
    color: #c2410c;
    border: 1px solid #fed7aa;
}

.ticket-actions {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 16px;
    margin-top: 8px;
}

.ticket-selected-preview {
    display: none;
    padding: 18px 20px;
    border-radius: 20px;
    background: linear-gradient(135deg, rgba(16, 185, 129, 0.12), rgba(255, 255, 255, 0.94));
    border: 1px solid rgba(16, 185, 129, 0.18);
}

.ticket-selected-preview.is-visible {
    display: block;
}

.ticket-selected-preview strong {
    display: block;
    font-size: 16px;
    color: var(--text-main);
    margin-bottom: 6px;
}

.ticket-selected-preview span {
    color: var(--text-soft);
    font-size: 14px;
    line-height: 1.7;
}

.ticket-agent-panel {
    padding: 22px;
    border-radius: 22px;
    background: linear-gradient(135deg, rgba(37, 99, 235, 0.08), rgba(255, 255, 255, 0.98));
    border: 1px solid rgba(37, 99, 235, 0.14);
}

.ticket-agent-panel__title {
    font-size: 18px;
    font-weight: 900;
    margin-bottom: 8px;
}

.ticket-agent-panel__text {
    color: var(--text-soft);
    line-height: 1.7;
}

@media (max-width: 900px) {
    .ticket-create-grid {
        grid-template-columns: 1fr;
    }

    .ticket-create-header {
        flex-direction: column;
        align-items: flex-start;
    }

    .ticket-actions {
        flex-direction: column;
        align-items: stretch;
    }

    .ticket-actions .btn {
        width: 100%;
    }
}
</style>

<div class="ticket-create-shell">
    <section class="ticket-create-header">
        <div>
            <h1>Créer un ticket</h1>
            @if($isAgent && isset($agentQueue) && $agentQueue)
                <p>Vous pouvez créer un ticket uniquement pour votre file et saisir seulement le nom du citoyen.</p>
            @endif
        </div>
        <div class="ticket-create-badge">
            <img src="https://img.icons8.com/color/96/ticket.png" alt="Icône ticket">
        </div>
    </section>

    @if(isset($existingActiveTicket) && $existingActiveTicket && auth()->user()->isCitoyen())
        <div class="alert">
            Vous avez déjà un ticket actif :
            <strong>#{{ $existingActiveTicket->number }}</strong>
            —
            {{ $existingActiveTicket->queue->service->name ?? 'Service' }}
            / {{ $existingActiveTicket->queue->service->hospital->name ?? 'Hôpital' }}
            ({{ $existingActiveTicket->status }})
        </div>
    @endif

    @if ($errors->any())
        <div class="alert">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card ticket-create-card" id="ticket-create-data" data-services='@json($services->values())' data-old-queue-id="{{ $selectedQueueId }}" data-is-agent="{{ $isAgent ? '1' : '0' }}">
        <form method="POST" action="{{ route('tickets.store') }}" id="ticket-create-form">
            @csrf

            @if($isAgent && isset($agentQueue) && $agentQueue)
                <div class="ticket-create-grid">
                    <div class="ticket-field">
                        <label>Hôpital</label>
                        <input type="text" value="{{ $agentQueue->service->hospital->name }}" readonly>
                        <input type="hidden" name="hospital_id" value="{{ $agentQueue->service->hospital->id }}">
                    </div>

                    <div class="ticket-field">
                        <label>Service / File</label>
                        <input type="text" value="{{ $agentQueue->service->name }} — {{ $agentQueue->name }}" readonly>
                        <input type="hidden" name="queue_id" id="queue_id" value="{{ $agentQueue->id }}">
                    </div>

                    <div class="ticket-field ticket-field--full">
                        <label for="citoyen_name">Nom du citoyen</label>
                        <input
                            type="text"
                            id="citoyen_name"
                            name="citoyen_name"
                            value="{{ old('citoyen_name') }}"
                            placeholder="Entrez seulement le nom du citoyen">
                        <small>L’agent crée le ticket pour sa propre queue uniquement.</small>
                    </div>

                    <div class="ticket-field ticket-field--full">
                        <div id="selected-preview" class="ticket-selected-preview is-visible">
                            <strong>Résumé de votre choix</strong>
                            <span id="selected-preview-text">
                                {{ $agentQueue->service->hospital->name }} • {{ $agentQueue->service->name }} • File: {{ $agentQueue->name }} • Statut: {{ $agentQueue->status === 'OPEN' ? 'ouverte' : 'fermée' }}
                            </span>
                        </div>
                    </div>
                </div>
            @else
                <div class="ticket-create-grid">
                    <div class="ticket-field">
                        <label for="hospital_id">Hôpital</label>
                        <select id="hospital_id" name="hospital_id">
                            <option value="">-- Choisir un hôpital --</option>
                            @foreach($hospitals as $hospital)
                                <option value="{{ $hospital->id }}" {{ (string) $selectedHospitalId === (string) $hospital->id ? 'selected' : '' }}>
                                    {{ $hospital->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="ticket-field">
                        <label for="service_selector">Service</label>
                        <select id="service_selector">
                            <option value="">-- Choisir un service --</option>
                        </select>
                        <div id="service-note" class="ticket-inline-note info"></div>
                    </div>

                    <div class="ticket-field ticket-field--full">
                        <input type="hidden" name="queue_id" id="queue_id" value="{{ $selectedQueueId }}">
                        <div id="selected-preview" class="ticket-selected-preview">
                            <strong>Résumé de votre choix</strong>
                            <span id="selected-preview-text"></span>
                        </div>
                    </div>
                </div>
            @endif

            <div class="ticket-actions">
                <a href="{{ route('tickets.index') }}" class="btn btn-outline">Retour</a>
                <button type="submit" class="btn btn-primary btn-lg" id="ticket-submit-button" {{ isset($existingActiveTicket) && $existingActiveTicket && auth()->user()->isCitoyen() ? 'disabled' : '' }}>Créer le ticket</button>
            </div>
        </form>
    </div>
</div>

<script>
    const ticketCreateData = document.getElementById('ticket-create-data');
    const services = JSON.parse(ticketCreateData.dataset.services || '[]');
    const hospitalSelect = document.getElementById('hospital_id');
    const serviceSelect = document.getElementById('service_selector');
    const queueInput = document.getElementById('queue_id');
    const serviceNote = document.getElementById('service-note');
    const previewBox = document.getElementById('selected-preview');
    const previewText = document.getElementById('selected-preview-text');
    const submitButton = document.getElementById('ticket-submit-button');
    const isAgent = ticketCreateData.dataset.isAgent === '1';
    const isCitoyen = "{{ auth()->user()->isCitoyen() ? '1' : '0' }}" === '1';
    const hasExistingActiveTicket = "{{ isset($existingActiveTicket) && $existingActiveTicket ? '1' : '0' }}" === '1';
    const oldQueueId = ticketCreateData.dataset.oldQueueId || '';

    function setSubmitState(disabled) {
        if (!submitButton || !isCitoyen) {
            return;
        }

        submitButton.disabled = disabled;
        submitButton.style.opacity = disabled ? '0.55' : '1';
        submitButton.style.cursor = disabled ? 'not-allowed' : 'pointer';
    }

    if (hasExistingActiveTicket && submitButton && isCitoyen) {
        submitButton.disabled = true;
        submitButton.style.opacity = '0.55';
        submitButton.style.cursor = 'not-allowed';
    }

    if (isAgent) {
        const selectedAgentService = services[0] || null;

        if (selectedAgentService && previewBox && previewText) {
            previewText.textContent = `${selectedAgentService.hospital_name} • ${selectedAgentService.name} • File: ${selectedAgentService.queue_name} • Statut: ${selectedAgentService.queue_status === 'OPEN' ? 'ouverte' : 'fermée'}`;
            previewBox.classList.add('is-visible');
        }

        if (submitButton && selectedAgentService && selectedAgentService.queue_status !== 'OPEN') {
            submitButton.disabled = true;
            submitButton.style.opacity = '0.55';
            submitButton.style.cursor = 'not-allowed';
        }
    } else {
        function resetServiceOptions(message = '') {
            serviceSelect.innerHTML = '<option value="">-- Choisir un service --</option>';
            queueInput.value = '';

            if (message) {
                serviceNote.textContent = message;
                serviceNote.className = 'ticket-inline-note warning is-visible';
            } else {
                serviceNote.textContent = '';
                serviceNote.className = 'ticket-inline-note info';
            }

            previewBox.classList.remove('is-visible');
            previewText.textContent = '';
            setSubmitState(false);
        }

        function updatePreview(selectedService) {
            if (!selectedService) {
                previewBox.classList.remove('is-visible');
                previewText.textContent = '';
                return;
            }

            const statusLabel = selectedService.queue_status === 'OPEN' ? 'ouverte' : 'fermée';
            previewText.textContent = `${selectedService.hospital_name} • ${selectedService.name} • File: ${selectedService.queue_name} • Statut: ${statusLabel}`;
            previewBox.classList.add('is-visible');

            if (isCitoyen && selectedService.queue_status !== 'OPEN') {
                serviceNote.textContent = 'Cette file est fermée. Vous ne pouvez pas prendre de ticket maintenant.';
                serviceNote.className = 'ticket-inline-note warning is-visible';
                setSubmitState(true);
                return;
            }

            setSubmitState(false);
        }

        function populateServices(selectedHospitalId, selectedQueueId = '') {
            resetServiceOptions(selectedHospitalId ? '' : 'Choisissez d’abord un hôpital.');

            if (!selectedHospitalId) {
                return;
            }

            const filtered = services.filter(service => String(service.hospital_id) === String(selectedHospitalId));

            if (!filtered.length) {
                resetServiceOptions('Aucun service disponible pour cet hôpital.');
                return;
            }

            serviceNote.textContent = `${filtered.length} service(s) disponible(s) dans cet hôpital.`;
            serviceNote.className = 'ticket-inline-note info is-visible';

            filtered.forEach(service => {
                const option = document.createElement('option');
                option.value = service.queue_id;
                option.textContent = service.name;

                if (String(selectedQueueId) === String(service.queue_id)) {
                    option.selected = true;
                    queueInput.value = service.queue_id;
                    updatePreview(service);
                }

                serviceSelect.appendChild(option);
            });
        }

        if (hospitalSelect && serviceSelect) {
            hospitalSelect.addEventListener('change', function () {
                populateServices(this.value);
            });

            serviceSelect.addEventListener('change', function () {
                const selectedQueueId = this.value;
                queueInput.value = selectedQueueId;

                const selectedService = services.find(service => String(service.queue_id) === String(selectedQueueId));
                updatePreview(selectedService || null);
            });

            populateServices(hospitalSelect.value, oldQueueId);
        }
    }
</script>
@endsection
