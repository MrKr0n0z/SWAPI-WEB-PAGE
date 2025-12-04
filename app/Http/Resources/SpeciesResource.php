<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SpeciesResource extends JsonResource
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
            'classification' => $this->classification,
            'designation' => $this->designation,
            'average_height' => $this->average_height,
            'skin_colors' => $this->skin_colors,
            'hair_colors' => $this->hair_colors,
            'eye_colors' => $this->eye_colors,
            'average_lifespan' => $this->average_lifespan,
            'homeworld' => $this->transformSingleUrl($this->homeworld, 'planets'),
            'language' => $this->language,
            'people' => $this->transformUrls($this->people, 'people'),
            'films' => $this->transformUrls($this->films, 'films'),
            'created' => $this->created,
            'edited' => $this->edited,
            'url' => $this->transformSingleUrl($this->url, 'species'),
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
