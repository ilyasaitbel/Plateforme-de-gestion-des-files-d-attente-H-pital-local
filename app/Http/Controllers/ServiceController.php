<?php

namespace App\Http\Controllers;

use App\Models\Hospital;
use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index(Request $request)
    {
        $hospitalId = $this->getAdministratorHospitalId($request);

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
        $hospitalId = $this->getAdministratorHospitalId($request);

        if (! $hospitalId) {
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

        return view('services.edit', compact('service', 'hospitals'));
    }

    public function update(Request $request, Service $service)
    {
        $data = $request->validate([
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

    private function getAdministratorHospitalId(Request $request)
    {
        return optional(optional($request->user())->administrator)->hospital_id;
    }
}
