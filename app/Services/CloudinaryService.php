<?php

namespace App\Services;

use GuzzleHttp\Client;

class CloudinaryService
{
    protected string $cloudName;
    protected string $apiKey;
    protected string $apiSecret;
    protected Client $client;

    public function __construct()
    {
        $this->cloudName = env('CLOUDINARY_CLOUD_NAME');
        $this->apiKey = env('CLOUDINARY_API_KEY');
        $this->apiSecret = env('CLOUDINARY_API_SECRET');
        $this->client = new Client(['verify' => false]);
    }

    public function upload($file, string $folder = 'library'): array
    {
        $timestamp = time();
        $signature = sha1("folder={$folder}&timestamp={$timestamp}{$this->apiSecret}");

        $response = $this->client->post(
            "https://api.cloudinary.com/v1_1/{$this->cloudName}/image/upload",
            [
                'multipart' => [
                    ['name' => 'file', 'contents' => fopen($file->getRealPath(), 'r'), 'filename' => $file->getClientOriginalName()],
                    ['name' => 'folder', 'contents' => $folder],
                    ['name' => 'api_key', 'contents' => $this->apiKey],
                    ['name' => 'timestamp', 'contents' => (string) $timestamp],
                    ['name' => 'signature', 'contents' => $signature],
                ],
            ]
        );

        $result = json_decode($response->getBody()->getContents(), true);

        return [
            'public_id' => $result['public_id'],
            'url' => $result['secure_url'],
        ];
    }

    public function delete(string $publicId): void
    {
        $timestamp = time();
        $signature = sha1("public_id={$publicId}&timestamp={$timestamp}{$this->apiSecret}");

        $this->client->post(
            "https://api.cloudinary.com/v1_1/{$this->cloudName}/image/destroy",
            [
                'form_params' => [
                    'public_id' => $publicId,
                    'api_key' => $this->apiKey,
                    'timestamp' => $timestamp,
                    'signature' => $signature,
                ],
            ]
        );
    }
}
