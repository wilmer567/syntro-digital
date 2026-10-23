<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AboutController extends Controller
{
    /**
     * Display about & mission/vision settings.
     */
    public function index(): View
    {
        $about = [
            'about_heading' => SiteSetting::get('about_heading', 'Un socio técnico cercano, no un proveedor más.'),
            'about_subheading' => SiteSetting::get('about_subheading', 'Trabajamos directamente con cooperativas, centros de salud, institutos y pequeños negocios que necesitan resultados claros, no jerga técnica.'),
            'mission_kicker' => SiteSetting::get('mission_kicker', 'Misión'),
            'mission_title' => SiteSetting::get('mission_title', 'Impulsar lo que sigue.'),
            'mission_description' => SiteSetting::get('mission_description', 'Ayudar a negocios e instituciones a modernizar su operación con software escalable y decisiones tecnológicas bien fundamentadas, sin complejidad innecesaria.'),
            'vision_kicker' => SiteSetting::get('vision_kicker', 'Visión 2030'),
            'vision_title' => SiteSetting::get('vision_title', 'Ser referentes en evolución tecnológica.'),
            'vision_description' => SiteSetting::get('vision_description', 'Consolidarnos como una firma referente en ingeniería de software y arquitectura en la nube para instituciones de la región.'),
        ];

        return view('admin.about.index', compact('about'));
    }

    /**
     * Update about section settings.
     */
    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'about_heading' => 'required|string|max:255',
            'about_subheading' => 'required|string|max:1000',
            'mission_kicker' => 'required|string|max:50',
            'mission_title' => 'required|string|max:150',
            'mission_description' => 'required|string|max:1000',
            'vision_kicker' => 'required|string|max:50',
            'vision_title' => 'required|string|max:150',
            'vision_description' => 'required|string|max:1000',
        ]);

        foreach ($validated as $key => $value) {
            SiteSetting::set($key, $value, 'about');
        }

        return redirect()->route('admin.about.index')
            ->with('status', '¡Información de "Nosotros, Misión y Visión" guardada exitosamente!');
    }
}
