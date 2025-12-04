<?php

namespace App\Http\Controllers;

use App\Models\Film;
use App\Models\Person;
use App\Models\Planet;
use App\Models\Species;
use App\Models\Starship;
use App\Models\Vehicle;
use App\Services\SwapiService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SyncController extends Controller
{
    protected SwapiService $swapiService;

    protected array $modelMapping = [
        'films' => Film::class,
        'people' => Person::class,
        'planets' => Planet::class,
        'species' => Species::class,
        'starships' => Starship::class,
        'vehicles' => Vehicle::class,
    ];

    public function __construct(SwapiService $swapiService)
    {
        $this->swapiService = $swapiService;
    }

    /**
     * Sincroniza datos desde la API de SWAPI
     */
    public function sync(Request $request): JsonResponse
    {
        $request->validate([
            'entity' => 'required|string|in:films,people,planets,species,starships,vehicles',
            'id' => 'nullable|integer',
        ]);

        $entity = $request->input('entity');
        $id = $request->input('id');
        
        try {
            if ($id) {
                // Sincronizar un solo registro
                $result = $this->syncSingle($entity, $id);
                
                return response()->json([
                    'success' => true,
                    'message' => "Successfully synced {$entity} with ID {$id}",
                    'data' => $result,
                ]);
            } else {
                // Sincronizar todos los registros
                $results = $this->syncAll($entity);
                
                return response()->json([
                    'success' => true,
                    'message' => "Successfully synced all {$entity}",
                    'data' => [
                        'synced_count' => $results->count(),
                        'records' => $results,
                    ],
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Sincroniza un solo registro
     */
    private function syncSingle(string $entity, int $id): array
    {
        $data = $this->swapiService->fetchOne($entity, $id);
        $model = $this->getModelClass($entity);
        
        $swapiId = SwapiService::extractIdFromUrl($data['url']);
        
        $record = $model::updateOrCreate(
            ['swapi_id' => $swapiId],
            $this->prepareDataForStorage($data)
        );

        return $record->toArray();
    }

    /**
     * Sincroniza todos los registros de una entidad
     */
    private function syncAll(string $entity): \Illuminate\Support\Collection
    {
        $allData = $this->swapiService->fetchAll($entity);
        $model = $this->getModelClass($entity);
        $results = collect();

        foreach ($allData as $data) {
            $swapiId = SwapiService::extractIdFromUrl($data['url']);
            
            $record = $model::updateOrCreate(
                ['swapi_id' => $swapiId],
                $this->prepareDataForStorage($data)
            );

            $results->push($record);
        }

        return $results;
    }

    /**
     * Obtiene la clase del modelo correspondiente
     */
    private function getModelClass(string $entity): string
    {
        return $this->modelMapping[$entity];
    }

    /**
     * Prepara los datos para el almacenamiento
     */
    private function prepareDataForStorage(array $data): array
    {
        // Guardar la URL original antes de procesarla
        $originalUrl = $data['url'] ?? null;
        
        // Mantener las URLs originales en los arrays JSONB
        return array_merge($data, [
            'url' => $originalUrl,
        ]);
    }
}
