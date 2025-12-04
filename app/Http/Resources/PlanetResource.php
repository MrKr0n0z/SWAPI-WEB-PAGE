<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PlanetResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'name' => $this->name,
            'rotation_period' => $this->rotation_period,
            'orbital_period' => $this->orbital_period,
            'diameter' => $this->diameter,
            'climate' => $this->climate,
            'gravity' => $this->gravity,
            'terrain' => $this->terrain,
            'surface_water' => $this->surface_water,
            'population' => $this->population,
            'residents' => $this->transformUrls($this->residents, 'people'),
            'films' => $this->transformUrls($this->films, 'films'),
            'created' => $this->created,
            'edited' => $this->edited,
            'url' => $this->transformSingleUrl($this->url, 'planets'),
        ];
    }

    /**
     * Transforma un array de URLs de SWAPI a URLs locales
     */
    private function transformUrls(?array $urls, string $resource): array
    {
        if (!$urls) {
            return [];
        }

        return array_map(function ($url) use ($resource) {
            return str_replace(
                'https://swapi.dev/api',
                request()->getSchemeAndHttpHost() . '/api/v1',
                $url
            );
        }, $urls);
    }

    /**
     * Transforma una sola URL de SWAPI a URL local
     */
    private function transformSingleUrl(?string $url, string $resource): ?string
    {
        if (!$url) {
            return null;
        }

        return str_replace(
            'https://swapi.dev/api',
            request()->getSchemeAndHttpHost() . '/api/v1',
            $url
        );
    }
}
