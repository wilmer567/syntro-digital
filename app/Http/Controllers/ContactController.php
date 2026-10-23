<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use App\Services\FirebaseService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    /**
     * Store a newly created contact message and sync with Firebase.
     */
    public function store(Request $request, FirebaseService $firebase): RedirectResponse
    {
        // Honeypot anti-spam protection for automated bots
        if ($request->filled('hp_contact_check')) {
            return redirect()->to(route('home', absolute: false).'#contacto')
                ->with('contact_success', '¡Gracias por escribirnos! Hemos recibido tu mensaje y nos pondremos en contacto contigo a la brevedad.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:150',
            'email' => 'required|email|max:150',
            'phone' => 'nullable|string|max:50',
            'service_interest' => 'nullable|string|max:150',
            'message' => 'required|string|max:3000',
        ]);

        $contactMessage = ContactMessage::create($validated);

        // Also push to Firebase Realtime Database
        $firebase->saveMessage([
            'id' => $contactMessage->id,
            'name' => $contactMessage->name,
            'email' => $contactMessage->email,
            'phone' => $contactMessage->phone,
            'service_interest' => $contactMessage->service_interest,
            'message' => $contactMessage->message,
        ]);

        return redirect()->to(route('home', absolute: false).'#contacto')
            ->with('contact_success', '¡Gracias por escribirnos! Hemos recibido tu mensaje y nos pondremos en contacto contigo a la brevedad.');
    }
}
