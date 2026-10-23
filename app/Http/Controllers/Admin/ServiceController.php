<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\SiteSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ServiceController extends Controller
{
    /**
     * Display a listing of services and section header.
     */
    public function index(): View
    {
        $services = Service::orderBy('order')->get();
        $heading = SiteSetting::get('services_heading', 'Una tecnología, aplicada a lo que tu institución necesita hoy.');
        $subheading = SiteSetting::get('services_subheading', 'Modernizamos, integramos y automatizamos procesos para resolver problemas reales con una arquitectura preparada para crecer.');

        return view('admin.services.index', compact('services', 'heading', 'subheading'));
    }

    /**
     * Update section header texts.
     */
    public function updateHeader(Request $request): RedirectResponse
    {
        $request->validate([
            'services_heading' => 'required|string|max:255',
            'services_subheading' => 'nullable|string|max:1000',
        ]);

        SiteSetting::set('services_heading', $request->input('services_heading'), 'services');
        SiteSetting::set('services_subheading', $request->input('services_subheading'), 'services');

        return redirect()->route('admin.services.index')
            ->with('status', 'Encabezado de servicios actualizado.');
    }

    /**
     * Store a newly created service.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:150',
            'description' => 'required|string|max:1000',
            'topline_color' => 'required|in:default,alt,gold',
            'order' => 'required|integer',
            'is_active' => 'sometimes|boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        Service::create($validated);

        return redirect()->route('admin.services.index')
            ->with('status', 'Servicio agregado exitosamente.');
    }

    /**
     * Update the specified service.
     */
    public function update(Request $request, Service $service): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:150',
            'description' => 'required|string|max:1000',
            'topline_color' => 'required|in:default,alt,gold',
            'order' => 'required|integer',
            'is_active' => 'sometimes|boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        $service->update($validated);

        return redirect()->route('admin.services.index')
            ->with('status', 'Servicio actualizado correctamente.');
    }

    /**
     * Remove the specified service.
     */
    public function destroy(Service $service): RedirectResponse
    {
        $service->delete();

        return redirect()->route('admin.services.index')
            ->with('status', 'Servicio eliminado correctamente.');
    }
}
