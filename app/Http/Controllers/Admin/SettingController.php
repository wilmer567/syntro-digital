<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class SettingController extends Controller
{
    /**
     * Display settings form.
     */
    public function index(): View
    {
        $settings = SiteSetting::allAsKeyMap();
        return view('admin.settings.index', compact('settings'));
    }

    /**
     * Update settings.
     */
    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            // General
            'brand_name' => 'required|string|max:100',
            'site_description' => 'nullable|string|max:500',
            'contact_email' => 'required|email|max:150',
            'contact_phone' => 'nullable|string|max:50',
            'contact_address' => 'nullable|string|max:200',
            'contact_linkedin' => ['nullable', Rule::anyOf([['url:https'], ['regex:/^#[A-Za-z][A-Za-z0-9_-]*$/']]), 'max:255'],
            'footer_about' => 'nullable|string|max:500',
            'footer_copyright' => 'nullable|string|max:200',
            'footer_tagline' => 'nullable|string|max:200',

            // Hero
            'hero_eyebrow' => 'nullable|string|max:200',
            'hero_title_line1' => 'required|string|max:200',
            'hero_title_line2' => 'required|string|max:200',
            'hero_description' => 'required|string|max:1000',
            'hero_primary_text' => 'nullable|string|max:100',
            'hero_primary_url' => ['nullable', Rule::anyOf([['url:https'], ['regex:/^#[A-Za-z][A-Za-z0-9_-]*$/']]), 'max:255'],
            'hero_secondary_text' => 'nullable|string|max:100',
            'hero_secondary_url' => ['nullable', Rule::anyOf([['url:https'], ['regex:/^#[A-Za-z][A-Za-z0-9_-]*$/']]), 'max:255'],
            'stat_1_number' => 'nullable|string|max:50',
            'stat_1_text' => 'nullable|string|max:150',
            'stat_2_number' => 'nullable|string|max:50',
            'stat_2_text' => 'nullable|string|max:150',
            'stat_3_number' => 'nullable|string|max:50',
            'stat_3_text' => 'nullable|string|max:150',

            // CTA
            'cta_heading' => 'nullable|string|max:300',
            'cta_button_text' => 'nullable|string|max:100',
            'cta_button_url' => ['nullable', Rule::anyOf([['url:https'], ['regex:/^#[A-Za-z][A-Za-z0-9_-]*$/']]), 'max:255'],
        ]);

        foreach ($validated as $key => $value) {
            $group = 'general';
            if (str_starts_with($key, 'hero_') || str_starts_with($key, 'stat_')) {
                $group = 'hero';
            } elseif (str_starts_with($key, 'cta_')) {
                $group = 'cta';
            }
            SiteSetting::set($key, $value, $group);
        }

        return redirect()->route('admin.settings.index')
            ->with('status', '¡Configuración y sección de inicio actualizadas correctamente!');
    }
}
