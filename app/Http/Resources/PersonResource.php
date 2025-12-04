<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PersonResource extends JsonResource
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
            'height' => $this->height,
            'mass' => $this->mass,
            'hair_color' => $this->hair_color,
            'skin_color' => $this->skin_color,
            'eye_color' => $this->eye_color,
            'birth_year' => $this->birth_year,
            'gender' => $this->gender,
            'homeworld' => $this->transformSingleUrl($this->homeworld, 'planets'),
            'films' => $this->transformUrls($this->films, 'films'),
            'species' => $this->transformUrls($this->species, 'species'),
            'vehicles' => $this->transformUrls($this->vehicles, 'vehicles'),
            'starships' => $this->transformUrls($this->starships, 'starships'),
            'created' => $this->created,
            'edited' => $this->edited,
            'url' => $this->transformSingleUrl($this->url, 'people'),
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
