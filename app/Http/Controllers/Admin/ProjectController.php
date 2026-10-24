<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\ProjectImage;
use App\Models\SiteSetting;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProjectController extends Controller
{
    /**
     * Display a listing of projects and section header.
     */
    public function index(): View
    {
        $projects = Project::with('images')->orderBy('order')->get();
        $heading = SiteSetting::get('projects_heading', 'Proyectos recientes.');
        $subheading = SiteSetting::get('projects_subheading', 'Una muestra del tipo de sistemas que construimos para instituciones y negocios locales.');

        return view('admin.projects.index', compact('projects', 'heading', 'subheading'));
    }

    /**
     * Update section header texts.
     */
    public function updateHeader(Request $request): RedirectResponse
    {
        $request->validate([
            'projects_heading' => 'required|string|max:255',
            'projects_subheading' => 'nullable|string|max:1000',
        ]);

        SiteSetting::set('projects_heading', $request->input('projects_heading'), 'projects');
        SiteSetting::set('projects_subheading', $request->input('projects_subheading'), 'projects');

        return redirect()->route('admin.projects.index')
            ->with('status', 'Encabezado de proyectos actualizado.');
    }

    /**
     * Store a newly created project with optional image.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'tag' => 'required|string|max:100',
            'title' => 'required|string|max:150',
            'description' => 'required|string|max:1000',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|dimensions:max_width=5000,max_height=5000|max:5120',
            'image_description' => 'nullable|string|max:1000',
            'images' => 'nullable|array|max:10',
            'images.*' => 'image|mimes:jpeg,png,jpg,webp|dimensions:max_width=5000,max_height=5000|max:5120',
            'new_image_descriptions' => 'nullable|array',
            'new_image_descriptions.*' => 'nullable|string|max:1000',
            'result' => 'nullable|string|max:255',
            'url' => ['nullable', 'url:https', 'max:255'],
            'order' => 'required|integer',
            'is_active' => 'sometimes|boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('projects', 'public');
            $validated['image'] = $path;
        }

        $images = $request->file('images', []);
        $imageDescriptions = $request->input('new_image_descriptions', []);
        unset($validated['images'], $validated['new_image_descriptions']);
        $project = Project::create($validated);

        foreach ($images as $index => $image) {
            $project->images()->create([
                'path' => $image->store('projects', 'public'),
                'description' => $imageDescriptions[$index] ?? null,
            ]);
        }

        return redirect()->route('admin.projects.index')
            ->with('status', 'Proyecto agregado exitosamente.');
    }

    /**
     * Update the specified project with image upload/removal.
     */
    public function update(Request $request, Project $project): RedirectResponse
    {
        $validated = $request->validate([
            'tag' => 'required|string|max:100',
            'title' => 'required|string|max:150',
            'description' => 'required|string|max:1000',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|dimensions:max_width=5000,max_height=5000|max:5120',
            'image_description' => 'nullable|string|max:1000',
            'images' => 'nullable|array|max:10',
            'images.*' => 'image|mimes:jpeg,png,jpg,webp|dimensions:max_width=5000,max_height=5000|max:5120',
            'new_image_descriptions' => 'nullable|array',
            'new_image_descriptions.*' => 'nullable|string|max:1000',
            'image_descriptions' => 'nullable|array',
            'image_descriptions.*' => 'nullable|string|max:1000',
            'remove_images' => 'sometimes|array|max:50',
            'remove_images.*' => 'integer|exists:project_images,id',
            'remove_image' => 'sometimes|boolean',
            'result' => 'nullable|string|max:255',
            'url' => ['nullable', 'url:https', 'max:255'],
            'order' => 'required|integer',
            'is_active' => 'sometimes|boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        $images = $request->file('images', []);
        $newImageDescriptions = $request->input('new_image_descriptions', []);
        $imageDescriptions = $request->input('image_descriptions', []);
        $removeImages = $request->input('remove_images', []);
        unset($validated['images'], $validated['new_image_descriptions'], $validated['image_descriptions'], $validated['remove_images']);

        // Check if user requested to remove existing image
        if ($request->boolean('remove_image')) {
            if ($project->image) {
                Storage::disk('public')->delete($project->image);
            }
            $validated['image'] = null;
            $validated['image_description'] = null;
        }

        if (! empty($removeImages)) {
            foreach ($project->images()->whereIn('id', $removeImages)->get() as $projectImage) {
                if ($projectImage->path) {
                    Storage::disk('public')->delete($projectImage->path);
                }
                $projectImage->delete();
            }
        }

        foreach ($project->images()->get() as $projectImage) {
            if (array_key_exists($projectImage->id, $imageDescriptions)) {
                $projectImage->update(['description' => $imageDescriptions[$projectImage->id]]);
            }
        }

        // Upload new image if provided
        if ($request->hasFile('image')) {
            if ($project->image) {
                Storage::disk('public')->delete($project->image);
            }
            $path = $request->file('image')->store('projects', 'public');
            $validated['image'] = $path;
        }

        foreach ($images as $index => $image) {
            $project->images()->create([
                'path' => $image->store('projects', 'public'),
                'description' => $newImageDescriptions[$index] ?? null,
            ]);
        }

        unset($validated['remove_image']);
        $project->update($validated);

        return redirect()->route('admin.projects.index')
            ->with('status', 'Proyecto actualizado exitosamente.');
    }

    /**
     * Delete an individual project gallery image.
     */
    public function destroyImage(Request $request, Project $project, ProjectImage $image): JsonResponse|RedirectResponse
    {
        if ($image->project_id !== $project->id) {
            abort(404);
        }

        if ($image->path) {
            Storage::disk('public')->delete($image->path);
        }

        $image->delete();

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json(['success' => true, 'message' => 'Foto eliminada exitosamente.']);
        }

        return redirect()->route('admin.projects.index')
            ->with('status', 'Foto eliminada exitosamente.');
    }

    /**
     * Delete the legacy main image of a project.
     */
    public function destroyMainImage(Request $request, Project $project): JsonResponse|RedirectResponse
    {
        if ($project->image) {
            Storage::disk('public')->delete($project->image);
        }

        $project->update([
            'image' => null,
            'image_description' => null,
        ]);

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json(['success' => true, 'message' => 'Foto eliminada exitosamente.']);
        }

        return redirect()->route('admin.projects.index')
            ->with('status', 'Foto eliminada exitosamente.');
    }

    /**
     * Remove the specified project and delete its image if exists.
     */
    public function destroy(Project $project): RedirectResponse
    {
        if ($project->image) {
            Storage::disk('public')->delete($project->image);
        }

        foreach ($project->images as $image) {
            Storage::disk('public')->delete($image->path);
        }

        $project->delete();

        return redirect()->route('admin.projects.index')
            ->with('status', 'Proyecto eliminado exitosamente.');
    }
}
