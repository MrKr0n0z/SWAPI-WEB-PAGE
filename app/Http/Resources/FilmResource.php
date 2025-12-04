<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FilmResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'title' => $this->title,
            'episode_id' => $this->episode_id,
            'opening_crawl' => $this->opening_crawl,
            'director' => $this->director,
            'producer' => $this->producer,
            'release_date' => $this->release_date,
            'characters' => $this->transformUrls($this->characters, 'people'),
            'planets' => $this->transformUrls($this->planets, 'planets'),
            'starships' => $this->transformUrls($this->starships, 'starships'),
            'vehicles' => $this->transformUrls($this->vehicles, 'vehicles'),
            'species' => $this->transformUrls($this->species, 'species'),
            'created' => $this->created,
            'edited' => $this->edited,
            'url' => $this->transformSingleUrl($this->url, 'films'),
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
