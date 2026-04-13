<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\Hospital;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index(Request $request)
    {
        $hospitalId = optional(optional($request->user())->administrator)->hospital_id;

        $services = Service::with('hospital')
            ->when($hospitalId, function ($query) use ($hospitalId) {
                $query->where('hospital_id', $hospitalId);
            })
            ->get();

        return view('services.index', compact('services'));
    }

    public function create()
    {
        return view('services.create');
    }

    public function store(Request $request)
    {
        $hospitalId = optional(optional($request->user())->administrator)->hospital_id;

        if (!$hospitalId) {
            return back()
                ->withInput()
                ->with('error', 'Aucun hôpital n’est associé à votre compte administrateur.');
        }

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $data['hospital_id'] = $hospitalId;

        Service::create($data);

        return redirect()->route('services.index');
    }

    public function show(Service $service)
    {
        return view('services.show', compact('service'));
    }

    public function edit(Service $service)
    {
        $hospitals = Hospital::all();
        return view('services.edit', compact('service','hospitals'));
    }

    public function update(Request $request, Service $service)
    {
        $data = $request->validate([
            'hospital_id' => 'required|exists:hospitals,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $service->update($data);

        return redirect()->route('services.index');
    }

    public function destroy(Service $service)
    {
        $service->delete();

        return redirect()->route('services.index');
    }
}
