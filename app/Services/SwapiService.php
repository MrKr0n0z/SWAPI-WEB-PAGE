<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Collection;

class SwapiService
{
    private const BASE_URL = 'https://swapi.dev/api';

    /**
     * Obtiene un solo recurso de la API de SWAPI
     */
    public function fetchOne(string $resource, int $id): array
    {
        $response = Http::get(self::BASE_URL . "/{$resource}/{$id}/");

        if (!$response->successful()) {
            throw new \Exception("Failed to fetch {$resource} with ID {$id}: " . $response->body());
        }

        return $response->json();
    }

    /**
     * Obtiene TODOS los recursos de la API de SWAPI con manejo de paginación
     */
    public function fetchAll(string $resource): Collection
    {
        $allResults = collect();
        $url = self::BASE_URL . "/{$resource}/";

        do {
            $response = Http::get($url);

            if (!$response->successful()) {
                throw new \Exception("Failed to fetch {$resource}: " . $response->body());
            }

            $data = $response->json();
            
            // Agregar todos los resultados de esta página
            $allResults = $allResults->concat($data['results']);
            
            // Siguiente URL para la paginación
            $url = $data['next'];

        } while ($url !== null);

        return $allResults;
    }

    /**
     * Extrae el ID de una URL de SWAPI
     */
    public static function extractIdFromUrl(string $url): ?int
    {
        if (preg_match('/\/(\d+)\/$/', $url, $matches)) {
            return (int) $matches[1];
        }
        
        return null;
    }
}