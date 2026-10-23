<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Principle;
use App\Models\SiteSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PrincipleController extends Controller
{
    /**
     * Display a listing of principles and section header.
     */
    public function index(): View
    {
        $principles = Principle::orderBy('order')->get();
        $heading = SiteSetting::get('principles_heading', 'La forma también importa.');
        $subheading = SiteSetting::get('principles_subheading', 'Cinco principios que se notan en cada entrega, no solo en la propuesta.');

        return view('admin.principles.index', compact('principles', 'heading', 'subheading'));
    }

    /**
     * Update section header texts.
     */
    public function updateHeader(Request $request): RedirectResponse
    {
        $request->validate([
            'principles_heading' => 'required|string|max:255',
            'principles_subheading' => 'nullable|string|max:1000',
        ]);

        SiteSetting::set('principles_heading', $request->input('principles_heading'), 'principles');
        SiteSetting::set('principles_subheading', $request->input('principles_subheading'), 'principles');

        return redirect()->route('admin.principles.index')
            ->with('status', 'Encabezado de principios actualizado.');
    }

    /**
     * Store a newly created principle.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:150',
            'description' => 'required|string|max:1000',
            'order' => 'required|integer',
            'is_active' => 'sometimes|boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        Principle::create($validated);

        return redirect()->route('admin.principles.index')
            ->with('status', 'Principio creado exitosamente.');
    }

    /**
     * Update the specified principle.
     */
    public function update(Request $request, Principle $principle): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:150',
            'description' => 'required|string|max:1000',
            'order' => 'required|integer',
            'is_active' => 'sometimes|boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        $principle->update($validated);

        return redirect()->route('admin.principles.index')
            ->with('status', 'Principio actualizado exitosamente.');
    }

    /**
     * Remove the specified principle.
     */
    public function destroy(Principle $principle): RedirectResponse
    {
        $principle->delete();

        return redirect()->route('admin.principles.index')
            ->with('status', 'Principio eliminado correctamente.');
    }
}
