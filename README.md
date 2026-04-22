# SWAPI Backend - Documentación API

API REST de Star Wars (SWAPI) construida con Laravel. Esta API proporciona acceso a información sobre películas, personajes, planetas, especies, naves estelares y vehículos del universo de Star Wars.

## Características

- ✅ Autenticación con tokens Bearer (Laravel Sanctum)
- ✅ Rate limiting (60 peticiones/minuto por usuario)
- ✅ CORS habilitado para endpoints de autenticación
- ✅ Sincronización de datos con SWAPI oficial
- ✅ Endpoints RESTful para 6 recursos principales
- ✅ Gestión de perfil de usuario

---

## 🔐 Autenticación

La mayoría de endpoints requieren autenticación con token Bearer. Para obtener un token:

### 1. Registrar / Login
```
POST /api/auth/login
Content-Type: application/json
CORS: Habilitado

Body:
{
  "email": "admin@test.com",
  "password": "password123"
}

Response:
{
  "access_token": "1|xxxxx...",
  "token_type": "Bearer",
  "user": { ... }
}
```

**Uso del token en peticiones posteriores:**
```
Authorization: Bearer 1|xxxxx...
```

---

## 📋 Rutas de Autenticación

### GET /api/auth/login
- **Descripción:** Información sobre el endpoint de login (solo para testing)
- **Autenticación:** No requerida
- **CORS:** Habilitado
- **Respuesta:** Instrucciones de uso

```json
{
  "message": "Este endpoint requiere POST con credenciales",
  "example": { ... }
}
```

---

### POST /api/auth/login
- **Descripción:** Autenticar usuario y obtener token de acceso
- **Autenticación:** No requerida
- **CORS:** Habilitado
- **Rate Limiting:** No aplica
- **Parámetros requeridos:**
  - `email` (string): Correo del usuario
  - `password` (string): Contraseña

**Ejemplo:**
```bash
curl -X POST "http://localhost:8000/api/auth/login" \
  -H "Content-Type: application/json" \
  -d '{"email":"admin@test.com","password":"password123"}'
```

---

### GET /api/auth/me
- **Descripción:** Obtener información del usuario autenticado
- **Autenticación:** ✅ Requerida (Bearer Token)
- **Rate Limiting:** ✅ Aplicado (60/minuto)
- **Respuesta:** Datos del usuario actual

**Ejemplo:**
```bash
curl -X GET "http://localhost:8000/api/auth/me" \
  -H "Authorization: Bearer YOUR_TOKEN"
```

---

### POST /api/auth/change-password
- **Descripción:** Cambiar contraseña del usuario autenticado
- **Autenticación:** ✅ Requerida (Bearer Token)
- **Rate Limiting:** ✅ Aplicado (60/minuto)
- **Parámetros requeridos:**
  - `current_password` (string): Contraseña actual
  - `password` (string): Nueva contraseña
  - `password_confirmation` (string): Confirmación de nueva contraseña

**Ejemplo:**
```bash
curl -X POST "http://localhost:8000/api/auth/change-password" \
  -H "Authorization: Bearer YOUR_TOKEN" \
  -H "Content-Type: application/json" \
  -d '{
    "current_password": "old_password",
    "password": "new_password",
    "password_confirmation": "new_password"
  }'
```

---

### POST /api/auth/logout
- **Descripción:** Cerrar sesión y revocar token
- **Autenticación:** ✅ Requerida (Bearer Token)
- **Rate Limiting:** ✅ Aplicado (60/minuto)
- **Respuesta:** Confirmación de logout

**Ejemplo:**
```bash
curl -X POST "http://localhost:8000/api/auth/logout" \
  -H "Authorization: Bearer YOUR_TOKEN"
```

---

## 🎬 API SWAPI v1 - Películas

### GET /api/v1/films
- **Descripción:** Listar todas las películas
- **Autenticación:** ✅ Requerida (Bearer Token)
- **Rate Limiting:** ✅ Aplicado (60/minuto)
- **Query Parameters:**
  - `page` (integer, opcional): Número de página (por defecto: 1)
  - `per_page` (integer, opcional): Registros por página

**Ejemplo:**
```bash
curl -X GET "http://localhost:8000/api/v1/films?page=1&per_page=10" \
  -H "Authorization: Bearer YOUR_TOKEN"
```

**Respuesta:**
```json
{
  "data": [
    {
      "id": 1,
      "swapi_id": "1",
      "title": "A New Hope",
      "episode_id": 4,
      "opening_crawl": "It is a period of civil war...",
      "director": "George Lucas",
      "producer": "Gary Kurtz",
      "release_date": "1977-05-25",
      "created_at": "2024-12-04T17:50:47Z",
      "updated_at": "2024-12-04T17:50:47Z"
    }
  ],
  "links": { ... },
  "meta": { ... }
}
```

---

### GET /api/v1/films/{id}
- **Descripción:** Obtener película específica por ID
- **Autenticación:** ✅ Requerida (Bearer Token)
- **Rate Limiting:** ✅ Aplicado (60/minuto)
- **Parámetros:**
  - `id` (integer, requerido): ID de la película

**Ejemplo:**
```bash
curl -X GET "http://localhost:8000/api/v1/films/1" \
  -H "Authorization: Bearer YOUR_TOKEN"
```

---

## 👤 API SWAPI v1 - Personajes

### GET /api/v1/people
- **Descripción:** Listar todos los personajes
- **Autenticación:** ✅ Requerida (Bearer Token)
- **Rate Limiting:** ✅ Aplicado (60/minuto)
- **Query Parameters:**
  - `page` (integer, opcional): Número de página
  - `per_page` (integer, opcional): Registros por página

**Ejemplo:**
```bash
curl -X GET "http://localhost:8000/api/v1/people?page=1" \
  -H "Authorization: Bearer YOUR_TOKEN"
```

**Respuesta:**
```json
{
  "data": [
    {
      "id": 1,
      "swapi_id": "1",
      "name": "Luke Skywalker",
      "height": "172",
      "mass": "77",
      "hair_color": "blond",
      "skin_color": "fair",
      "eye_color": "blue",
      "birth_year": "19BBY",
      "gender": "male",
      "created_at": "2024-12-04T17:50:47Z",
      "updated_at": "2024-12-04T17:50:47Z"
    }
  ],
  "links": { ... },
  "meta": { ... }
}
```

---

### GET /api/v1/people/{id}
- **Descripción:** Obtener personaje específico por ID
- **Autenticación:** ✅ Requerida (Bearer Token)
- **Rate Limiting:** ✅ Aplicado (60/minuto)
- **Parámetros:**
  - `id` (integer, requerido): ID del personaje

**Ejemplo:**
```bash
curl -X GET "http://localhost:8000/api/v1/people/1" \
  -H "Authorization: Bearer YOUR_TOKEN"
```

---

## 🪐 API SWAPI v1 - Planetas

### GET /api/v1/planets
- **Descripción:** Listar todos los planetas
- **Autenticación:** ✅ Requerida (Bearer Token)
- **Rate Limiting:** ✅ Aplicado (60/minuto)
- **Query Parameters:**
  - `page` (integer, opcional): Número de página
  - `per_page` (integer, opcional): Registros por página

**Ejemplo:**
```bash
curl -X GET "http://localhost:8000/api/v1/planets" \
  -H "Authorization: Bearer YOUR_TOKEN"
```

**Respuesta:**
```json
{
  "data": [
    {
      "id": 1,
      "swapi_id": "1",
      "name": "Tatooine",
      "rotation_period": "23",
      "orbital_period": "304",
      "diameter": "10465",
      "climate": "arid",
      "gravity": "1 standard",
      "terrain": "desert",
      "surface_water": "1",
      "population": "200000",
      "created_at": "2024-12-04T17:50:47Z",
      "updated_at": "2024-12-04T17:50:47Z"
    }
  ],
  "links": { ... },
  "meta": { ... }
}
```

---

### GET /api/v1/planets/{id}
- **Descripción:** Obtener planeta específico por ID
- **Autenticación:** ✅ Requerida (Bearer Token)
- **Rate Limiting:** ✅ Aplicado (60/minuto)
- **Parámetros:**
  - `id` (integer, requerido): ID del planeta

**Ejemplo:**
```bash
curl -X GET "http://localhost:8000/api/v1/planets/1" \
  -H "Authorization: Bearer YOUR_TOKEN"
```

---

## 🧬 API SWAPI v1 - Especies

### GET /api/v1/species
- **Descripción:** Listar todas las especies
- **Autenticación:** ✅ Requerida (Bearer Token)
- **Rate Limiting:** ✅ Aplicado (60/minuto)
- **Query Parameters:**
  - `page` (integer, opcional): Número de página
  - `per_page` (integer, opcional): Registros por página

**Ejemplo:**
```bash
curl -X GET "http://localhost:8000/api/v1/species" \
  -H "Authorization: Bearer YOUR_TOKEN"
```

**Respuesta:**
```json
{
  "data": [
    {
      "id": 1,
      "swapi_id": "1",
      "name": "Human",
      "classification": "mammal",
      "designation": "sentient",
      "average_height": "180",
      "skin_colors": "caucasian, black, asian, hispanic",
      "hair_colors": "blonde, brown, black, red",
      "eye_colors": "brown, blue, green, yellow, black, orange",
      "average_lifespan": "120",
      "language": "Galactic Basic",
      "created_at": "2024-12-04T17:50:47Z",
      "updated_at": "2024-12-04T17:50:47Z"
    }
  ],
  "links": { ... },
  "meta": { ... }
}
```

---

### GET /api/v1/species/{id}
- **Descripción:** Obtener especie específica por ID
- **Autenticación:** ✅ Requerida (Bearer Token)
- **Rate Limiting:** ✅ Aplicado (60/minuto)
- **Parámetros:**
  - `id` (integer, requerido): ID de la especie

**Ejemplo:**
```bash
curl -X GET "http://localhost:8000/api/v1/species/1" \
  -H "Authorization: Bearer YOUR_TOKEN"
```

---

## 🚀 API SWAPI v1 - Naves Estelares

### GET /api/v1/starships
- **Descripción:** Listar todas las naves estelares
- **Autenticación:** ✅ Requerida (Bearer Token)
- **Rate Limiting:** ✅ Aplicado (60/minuto)
- **Query Parameters:**
  - `page` (integer, opcional): Número de página
  - `per_page` (integer, opcional): Registros por página

**Ejemplo:**
```bash
curl -X GET "http://localhost:8000/api/v1/starships" \
  -H "Authorization: Bearer YOUR_TOKEN"
```

**Respuesta:**
```json
{
  "data": [
    {
      "id": 1,
      "swapi_id": "2",
      "name": "CR90 corvette",
      "model": "CR90 corvette",
      "manufacturer": "Corellian Engineering Corporation",
      "cost_in_credits": "3500000",
      "length": "150",
      "max_atmosphering_speed": "950",
      "crew": "30-165",
      "passengers": "600",
      "cargo_capacity": "3000000",
      "consumables": "1 month",
      "hyperdrive_rating": "0.5",
      "mglt": "60",
      "starship_class": "corvette",
      "created_at": "2024-12-04T17:50:47Z",
      "updated_at": "2024-12-04T17:50:47Z"
    }
  ],
  "links": { ... },
  "meta": { ... }
}
```

---

### GET /api/v1/starships/{id}
- **Descripción:** Obtener nave estelar específica por ID
- **Autenticación:** ✅ Requerida (Bearer Token)
- **Rate Limiting:** ✅ Aplicado (60/minuto)
- **Parámetros:**
  - `id` (integer, requerido): ID de la nave

**Ejemplo:**
```bash
curl -X GET "http://localhost:8000/api/v1/starships/1" \
  -H "Authorization: Bearer YOUR_TOKEN"
```

---

## 🚗 API SWAPI v1 - Vehículos

### GET /api/v1/vehicles
- **Descripción:** Listar todos los vehículos
- **Autenticación:** ✅ Requerida (Bearer Token)
- **Rate Limiting:** ✅ Aplicado (60/minuto)
- **Query Parameters:**
  - `page` (integer, opcional): Número de página
  - `per_page` (integer, opcional): Registros por página

**Ejemplo:**
```bash
curl -X GET "http://localhost:8000/api/v1/vehicles" \
  -H "Authorization: Bearer YOUR_TOKEN"
```

**Respuesta:**
```json
{
  "data": [
    {
      "id": 1,
      "swapi_id": "4",
      "name": "Sand Crawler",
      "model": "Digger Crawler",
      "manufacturer": "Corellia Mining Corporation",
      "cost_in_credits": "150000",
      "length": "36.8",
      "max_atmosphering_speed": "30",
      "crew": "46",
      "passengers": "30",
      "cargo_capacity": "50000",
      "consumables": "2 months",
      "vehicle_class": "wheeled",
      "created_at": "2024-12-04T17:50:47Z",
      "updated_at": "2024-12-04T17:50:47Z"
    }
  ],
  "links": { ... },
  "meta": { ... }
}
```

---

### GET /api/v1/vehicles/{id}
- **Descripción:** Obtener vehículo específico por ID
- **Autenticación:** ✅ Requerida (Bearer Token)
- **Rate Limiting:** ✅ Aplicado (60/minuto)
- **Parámetros:**
  - `id` (integer, requerido): ID del vehículo

**Ejemplo:**
```bash
curl -X GET "http://localhost:8000/api/v1/vehicles/1" \
  -H "Authorization: Bearer YOUR_TOKEN"
```

---

## 🔄 Sincronización de Datos

### POST /api/sync
- **Descripción:** Sincronizar datos desde SWAPI oficial (protegido en producción)
- **Autenticación:** ✅ Requerida (Bearer Token)
- **Rate Limiting:** ✅ Aplicado (60/minuto)
- **Parámetros:** Ninguno requerido

**Ejemplo:**
```bash
curl -X POST "http://localhost:8000/api/sync" \
  -H "Authorization: Bearer YOUR_TOKEN" \
  -H "Content-Type: application/json"
```

**Respuesta:**
```json
{
  "success": true,
  "message": "Sincronización completada",
  "synced": {
    "films": 6,
    "people": 82,
    "planets": 60,
    "species": 37,
    "starships": 36,
    "vehicles": 62
  }
}
```

---

## 👤 Usuarios

### GET /api/user
- **Descripción:** Obtener datos del usuario autenticado (endpoint heredado)
- **Autenticación:** ✅ Requerida (Bearer Token)
- **Rate Limiting:** ✅ Aplicado (60/minuto)
- **Respuesta:** Información del usuario actual

**Ejemplo:**
```bash
curl -X GET "http://localhost:8000/api/user" \
  -H "Authorization: Bearer YOUR_TOKEN"
```

**Respuesta:**
```json
{
  "success": true,
  "data": {
    "id": 1,
    "name": "Admin User",
    "email": "admin@test.com",
    "created_at": "2024-12-03T19:09:03Z",
    "updated_at": "2024-12-03T19:09:03Z"
  }
}
```

---

## 📊 Códigos de Respuesta HTTP

| Código | Significado |
|--------|-------------|
| `200` | OK - Solicitud exitosa |
| `201` | Created - Recurso creado exitosamente |
| `400` | Bad Request - Parámetros inválidos |
| `401` | Unauthorized - Token no válido o no proporcionado |
| `403` | Forbidden - No tienes permiso para acceder |
| `404` | Not Found - Recurso no encontrado |
| `422` | Unprocessable Entity - Validación fallida |
| `429` | Too Many Requests - Rate limit excedido |
| `500` | Internal Server Error - Error del servidor |

---

## ⚙️ Configuración

### Rate Limiting
- **Límite:** 60 peticiones por minuto por usuario autenticado
- **Método:** Por token de acceso
- **Headers de respuesta:**
  - `X-RateLimit-Limit`: Número máximo de peticiones
  - `X-RateLimit-Remaining`: Peticiones restantes
  - `X-RateLimit-Reset`: Timestamp cuando se reinicia el contador

### CORS
- CORS habilitado solo para endpoints de autenticación (`/api/auth/login`)
- Los demás endpoints requieren ser consumidos desde el mismo dominio o necesitan configuración CORS adicional

### Autenticación
- Basada en Laravel Sanctum
- Tokens Bearer de larga duración
- Los tokens no expiran automáticamente (configuración personalizada)

---

## 📝 Notas Importantes

- ⚠️ El endpoint `GET /api/auth/login` es **temporal solo para testing** y no debe usarse en producción
- 🔒 Todos los endpoints de `/api/v1/**` requieren autenticación
- 📈 El endpoint `/api/sync` es útil para mantener los datos actualizados desde SWAPI
- 🚀 Los endpoints de lista soportan paginación automática mediante Laravel

---

## 📦 Tecnologías Utilizadas

- **Framework:** Laravel 11
- **Autenticación:** Laravel Sanctum
- **Base de Datos:** MySQL/PostgreSQL
- **API Externa:** Star Wars API (SWAPI)

---

## 📄 Licencia

MIT License - Star Wars API Backend
