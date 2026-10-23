<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProcessStep;
use App\Models\SiteSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProcessStepController extends Controller
{
    /**
     * Display a listing of process steps and section header.
     */
    public function index(): View
    {
        $steps = ProcessStep::orderBy('order')->get();
        $heading = SiteSetting::get('process_heading', 'Cómo trabajamos, paso a paso.');
        $subheading = SiteSetting::get('process_subheading', 'Un proceso consultivo pensado para que sepas exactamente en qué etapa está tu proyecto.');

        return view('admin.process.index', compact('steps', 'heading', 'subheading'));
    }

    /**
     * Update section header texts.
     */
    public function updateHeader(Request $request): RedirectResponse
    {
        $request->validate([
            'process_heading' => 'required|string|max:255',
            'process_subheading' => 'nullable|string|max:1000',
        ]);

        SiteSetting::set('process_heading', $request->input('process_heading'), 'process');
        SiteSetting::set('process_subheading', $request->input('process_subheading'), 'process');

        return redirect()->route('admin.process.index')
            ->with('status', 'Encabezado de cómo trabajamos actualizado.');
    }

    /**
     * Store a newly created process step.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'step_number' => 'required|string|max:10',
            'title' => 'required|string|max:150',
            'description' => 'required|string|max:1000',
            'order' => 'required|integer',
            'is_active' => 'sometimes|boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        ProcessStep::create($validated);

        return redirect()->route('admin.process.index')
            ->with('status', 'Paso del proceso agregado exitosamente.');
    }

    /**
     * Update the specified process step.
     */
    public function update(Request $request, ProcessStep $step): RedirectResponse
    {
        $validated = $request->validate([
            'step_number' => 'required|string|max:10',
            'title' => 'required|string|max:150',
            'description' => 'required|string|max:1000',
            'order' => 'required|integer',
            'is_active' => 'sometimes|boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        $step->update($validated);

        return redirect()->route('admin.process.index')
            ->with('status', 'Paso del proceso actualizado correctamente.');
    }

    /**
     * Remove the specified process step.
     */
    public function destroy(ProcessStep $step): RedirectResponse
    {
        $step->delete();

        return redirect()->route('admin.process.index')
            ->with('status', 'Paso del proceso eliminado correctamente.');
    }
}
