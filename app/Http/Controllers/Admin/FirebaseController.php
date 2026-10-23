<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use App\Models\Principle;
use App\Models\ProcessStep;
use App\Models\Project;
use App\Models\Service;
use App\Models\SiteSetting;
use App\Services\FirebaseService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\JsonResponse;

class FirebaseController extends Controller
{
    /**
     * Test connection to Firebase Realtime Database.
     */
    public function test(FirebaseService $firebase): JsonResponse
    {
        $result = $firebase->testConnection();

        return response()->json([
            'success' => (bool) ($result['success'] ?? false),
            'status' => (int) ($result['status'] ?? 500),
        ]);
    }

    /**
     * Synchronize all site content to Firebase Realtime Database.
     */
    public function sync(FirebaseService $firebase): RedirectResponse
    {
        $payload = [
            'synced_at' => now()->toIso8601String(),
            'brand' => [
                'name' => SiteSetting::get('brand_name', 'Sytro Digital'),
                'email' => SiteSetting::get('contact_email', 'hola@sytrodigital.com'),
                'phone' => SiteSetting::get('contact_phone', '+593 99 000 0000'),
                'address' => SiteSetting::get('contact_address', 'Riobamba, Ecuador'),
            ],
            'settings' => SiteSetting::allAsKeyMap(),
            'services' => Service::where('is_active', true)->orderBy('order')->get()->toArray(),
            'principles' => Principle::where('is_active', true)->orderBy('order')->get()->toArray(),
            'process_steps' => ProcessStep::where('is_active', true)->orderBy('order')->get()->toArray(),
            'projects' => Project::where('is_active', true)->orderBy('order')->get()->toArray(),
        ];

        $success = $firebase->syncContent('site_content', $payload);

        if ($success) {
            return back()->with('status', '¡Contenido del sitio sincronizado con Firebase Realtime Database exitosamente!');
        }

        return back()->with('status', 'Intento de sincronización enviado a Firebase (Verifica las reglas de lectura/escritura en Firebase Console si no ves los datos reflejados).');
    }
}
