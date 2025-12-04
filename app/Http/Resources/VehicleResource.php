<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class VehicleResource extends JsonResource
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
            'model' => $this->model,
            'manufacturer' => $this->manufacturer,
            'cost_in_credits' => $this->cost_in_credits,
            'length' => $this->length,
            'max_atmosphering_speed' => $this->max_atmosphering_speed,
            'crew' => $this->crew,
            'passengers' => $this->passengers,
            'cargo_capacity' => $this->cargo_capacity,
            'consumables' => $this->consumables,
            'vehicle_class' => $this->vehicle_class,
            'pilots' => $this->transformUrls($this->pilots, 'people'),
            'films' => $this->transformUrls($this->films, 'films'),
            'created' => $this->created,
            'edited' => $this->edited,
            'url' => $this->transformSingleUrl($this->url, 'vehicles'),
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
