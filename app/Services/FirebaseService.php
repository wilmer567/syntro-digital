<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class FirebaseService
{
    protected string $databaseUrl;
    protected string $apiKey;
    protected bool $isConfigured;

    public function __construct()
    {
        $this->databaseUrl = rtrim((string) config('firebase.database_url', ''), '/');
        $this->apiKey = (string) config('firebase.api_key', '');
        $this->isConfigured = filter_var($this->databaseUrl, FILTER_VALIDATE_URL) !== false
            && parse_url($this->databaseUrl, PHP_URL_SCHEME) === 'https';
    }

    /**
     * Test connection to Firebase Realtime Database.
     */
    public function testConnection(): array
    {
        if (! $this->isConfigured) {
            return [
                'success' => false,
                'status' => 503,
                'error' => 'Firebase is not configured.',
            ];
        }

        try {
            $query = ['shallow' => 'true'];
            if ($this->apiKey) {
                $query['key'] = $this->apiKey;
            }

            $response = Http::timeout(5)->get("{$this->databaseUrl}/.json", $query);

            return [
                'success' => $response->successful(),
                'status' => $response->status(),
                'data' => $response->json(),
                'error' => $response->failed() ? $response->body() : null,
            ];
        } catch (\Throwable $e) {
            Log::warning('Firebase connection test failed.', ['exception_type' => $e::class]);
            return [
                'success' => false,
                'status' => 500,
                'error' => 'Firebase connection failed.',
            ];
        }
    }

    /**
     * Save a new contact message into Firebase Realtime Database (/messages.json).
     */
    public function saveMessage(array $message): bool
    {
        if (! $this->isConfigured) {
            return false;
        }

        try {
            $query = [];
            if ($this->apiKey) {
                $query['key'] = $this->apiKey;
            }

            $response = Http::timeout(5)->withQueryParameters($query)->post("{$this->databaseUrl}/messages.json", array_merge($message, [
                'created_at' => now()->toIso8601String(),
                'source' => 'sytro-digital-web',
            ]));

            return $response->successful();
        } catch (\Throwable $e) {
            Log::warning('Firebase message delivery failed.', ['exception_type' => $e::class]);
            return false;
        }
    }

    /**
     * Sync general website content/settings to Firebase (/site_content.json).
     */
    public function syncContent(string $path, array $data): bool
    {
        if (! $this->isConfigured) {
            return false;
        }

        try {
            $query = [];
            if ($this->apiKey) {
                $query['key'] = $this->apiKey;
            }

            $response = Http::timeout(5)->withQueryParameters($query)->put("{$this->databaseUrl}/{$path}.json", $data);

            return $response->successful();
        } catch (\Throwable $e) {
            Log::warning('Firebase content synchronization failed.', ['exception_type' => $e::class]);
            return false;
        }
    }

    /**
     * Read data from Firebase Realtime Database.
     */
    public function getData(string $path): mixed
    {
        if (! $this->isConfigured) {
            return null;
        }

        try {
            $query = [];
            if ($this->apiKey) {
                $query['key'] = $this->apiKey;
            }

            $response = Http::timeout(5)->get("{$this->databaseUrl}/{$path}.json", $query);

            return $response->successful() ? $response->json() : null;
        } catch (\Throwable $e) {
            Log::warning('Firebase data read failed.', ['exception_type' => $e::class]);
            return null;
        }
    }
}
