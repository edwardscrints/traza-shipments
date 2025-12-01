# 📦 Traza Shipments - API REST

Servicio de gestión de envíos y despachos con cumplimiento de normas RNDC (Registro Nacional de Despacho de Carga) de Colombia.



## 📖 Descripción del Proyecto

API REST desarrollada con Laravel 9 para la gestión integral de envíos y despachos de carga, se tiene en cuenta los datos RNDC 

-  Autenticación segura con Laravel Sanctum
-  Gestión completa de envíos (CRUD)
-  Trazabilidad de remitentes, destinatarios y conductores
-  Control de mercancías y clasificación RNDC
-  Activación/desactivación de envíos
-  Multiples Validaciones para creación y modificación

##  Tecnologías Utilizadas

- **Backend:** Laravel 9.52.21
- **PHP:** 8.3.25
- **Base de Datos:** MariaDB/MySQL
- **Autenticación:** Laravel Sanctum
- **ORM:** Eloquent
- **Paquetes adicionales:** doctrine/dbal (para modificación de columnas)


##  Requerimientos del Sistema

- PHP >= 8.0
- Composer
- MariaDB/MySQL >= 5.7
- Extensiones PHP: OpenSSL, PDO, Mbstring, Tokenizer, XML, Ctype, JSON

##  Instalación


### 2. Instalar dependencias
```bash
composer install
```

### 3. Configurar variables de entorno
```bash
cp .env.example .env
php artisan key:generate
```

### 4. Crear la base de datos
```sql
CREATE DATABASE traza_shipments CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

### 5. Configurar conexión en `.env`
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=traza_shipments
DB_USERNAME=root
DB_PASSWORD=password
```

### 6. Ejecutar migraciones y seeders
```bash
php artisan migrate
php artisan db:seed
```

### 7. Iniciar el servidor
```bash
php artisan serve
```

El servidor estará disponible en: `http://localhost:8000`

---

## ⚙️ Configuración

### Creación de Migraciones (Historial)

```bash
# Tablas sin dependencias
php artisan make:migration create_thirds_table
php artisan make:migration create_merchandises_table

# Tabla con foreign keys
php artisan make:migration create_shipments_table

# Modificaciones
php artisan make:migration add_mercan_califi_to_merchandises_table
php artisan make:migration remove_unique_constraint_from_plate_in_shipments_table
```

### Creación de Modelos

```bash
php artisan make:model Third
php artisan make:model Merchandise
php artisan make:model Shipment
```

### Factories y Seeders

```bash
php artisan make:factory ThirdFactory --model=Third
php artisan make:factory MerchandiseFactory --model=Merchandise
php artisan make:factory ShipmentFactory --model=Shipment
```

### Controladores

```bash
php artisan make:controller Api/AuthController
php artisan make:controller Api/ShipmentController --api
```

---


## 🗄️ Estructura de la Base de Datos

### Tablas Principales

#### `users` - Usuarios del sistema
- Usuarios con autenticación y control de acceso

#### `thirds` - Terceros (Conductores, Remitentes, Destinatarios)
- `id` (PK)
- `third_name`
- `document_type` (CC, NIT, CE, PPT)
- `third_type` (conductor, cliente remitente, cliente destinatario, transportadora)
- `third_address`
- `is_active`
- Timestamps y soft deletes

#### `merchandises` - Mercancías
- `id` (PK)
- `mercan_name`
- `mercan_type` (Extrapesada, Carga General, Desechos Peligrosos, etc.)
- `mercan_rndc_id`
- `mercan_califi` (A1-A5, B1-B5, C1-C5, D1-D5)
- `is_active`
- Timestamps y soft deletes

#### `shipments` - Envíos/Despachos
- `id` (PK)
- `tracking_number` (único)
- `origin`, `destination`
- `status` (En Alistamiento, Asignado a Vehiculo, En Transito, etc.)
- **Campos RNDC:**
  - `remesa`
  - `manifiesto`
  - `date_manifiesto`
  - `plate` (placa del vehículo)
- `weight`, `declared_price`
- `observation`
- **Foreign Keys:**
  - `third_id_driver` → thirds
  - `third_id_remite` → thirds
  - `third_id_destin` → thirds
  - `merchandise_id` → merchandises
  - `created_by` → users
  - `updated_by` → users
- `is_active`
- Timestamps y soft deletes

---

##  Documentación de la API

### Se trabajan los datos con REQUEST y RESOURCES para manejo y muestreo de informacion

### Base URL
```
http://localhost:8000/api
```

### Autenticación
La API utiliza **Bearer Token** (Laravel Sanctum). Todas las rutas excepto `/login` requieren autenticación.

---

### 1.  Autenticación

#### **Login**
```http
POST /api/login
```

**Headers:**
```
Content-Type: application/json
Accept: application/json
```

**Body:**
```json
{
  "email": "edward.gabriel@grupooet.com",
  "password": "password"
}
```

**Respuesta exitosa (200):**
```json
{
  "message": "Login exitoso",
  "access_token": "4|LuOoTEXkVEJF1Fa7WqCwkGVJONhex7E5RH9HWZjS",
  "token_type": "Bearer",
  "user": {
    "id": 1,
    "name": "AdminGabriel",
    "email": "edward.gabriel@grupooet.com"
  }
}
```

#### **Logout**
```http
POST /api/logout
```

**Headers:**
```
Authorization: Bearer {token}
Accept: application/json
```

#### **Información del usuario autenticado**
```http
GET /api/about
```

**Headers:**
```
Authorization: Bearer {token}
Accept: application/json
```

---

### 2.  Gestión de Envíos

#### **Listar todos los envíos (paginado)**
```http
GET /api/shipments
```

**Headers:**
```
Authorization: Bearer {token}
Accept: application/json
```

**Respuesta exitosa (200):**
```json
{
  "current_page": 1,
  "data": [
    {
      "id": 1,
      "tracking_number": "TRK-0706-wvlj",
      "origin": "Medellín",
      "destination": "Bogotá",
      "status": "Devuelto",
      "remesa": "Remesa no especificada",
      "manifiesto": "Manifiesto no especificada",
      "date_manifiesto": "Fecha no especificada",
      "plate": "hft-983",
      "weight": "Peso no especificado",
      "declared_price": "7101747.29",
      "is_active": true,
      "observation": "Observaciones del envío",
      "conductor": { /* relación */ },
      "remitente": { /* relación */ },
      "destinatario": { /* relación */ },
      "mercancia": { /* relación */ },
      "creator": { /* relación */ },
      "updater": null
    }
  ],
  "first_page_url": "http://localhost:8000/api/shipments?page=1",
  "from": 1,
  "last_page": 2,
  "last_page_url": "http://localhost:8000/api/shipments?page=2",
  "next_page_url": "http://localhost:8000/api/shipments?page=2",
  "path": "http://localhost:8000/api/shipments",
  "per_page": 10,
  "prev_page_url": null,
  "to": 10,
  "total": 20
}
```

---

#### **Ver un envío específico**
```http
GET /api/shipments/{id}
```

**Headers:**
```
Authorization: Bearer {token}
Accept: application/json
```

**Ejemplo:**
```http
GET /api/shipments/2
```

**Respuesta exitosa (200):**
```json
{
  "id": 2,
  "tracking_number": "TRK-8414-czjx",
  "origin": "Cartagena",
  "destination": "Cartagena",
  "status": "Cancelado",
  "remesa": "Remesa no especificada",
  "manifiesto": "Manifiesto no especificado",
  "date_manifiesto": "2025-11-15T00:00:00.000000Z",
  "plate": "cpm-529",
  "weight": "4332.45",
  "declared_price": "Precio no especificado",
  "is_active": true,
  "observation": "Observación del envío",
  "third_id_driver": 64,
  "third_id_remite": 65,
  "third_id_destin": 66,
  "merchandise_id": 92,
  "created_by": 8,
  "updated_by": null,
  "conductor": { /* datos del conductor */ },
  "remitente": { /* datos del remitente */ },
  "destinatario": { /* datos del destinatario */ },
  "mercancia": { /* datos de la mercancía */ },
  "creator": { /* usuario que creó */ },
  "updater": null
}
```

---

#### **Crear un nuevo envío**
```http
POST /api/shipments
```

**Headers:**
```
Authorization: Bearer {token}
Content-Type: application/json
Accept: application/json
```

**Body:**
```json
{
  "tracking_number": "TRK-BOG-001",
  "origin": "Bogotá",
  "destination": "Cartagena",
  "status": "En Transito",
  "remesa": "REM.2025-001",
  "manifiesto": "MAN-2025-001",
  "date_manifiesto": "2025-11-23",
  "plate": "KVX371",
  "weight": 150.5,
  "declared_price": 50000,
  "is_active": true,
  "observation": "Envío de prueba desde Postman",
  "third_id_driver": 1,
  "third_id_remite": 2,
  "third_id_destin": 3,
  "merchandise_id": 1
}
```

**Valores válidos para `status`:**
- `"En Alistamiento"`
- `"Asignado a Vehiculo"`
- `"En Transito"`
- `"Despacho Finalizado"`
- `"Cancelado"`
- `"Devuelto"`

**Notas:**
- `tracking_number` debe ser único
- Los IDs de terceros y mercancía deben existir en la BD
- El campo `created_by` se asigna automáticamente

**Respuesta exitosa (201):**
```json
{
  "id": 21,
  "tracking_number": "TRK-BOG-001",
  "origin": "Bogotá",
  "destination": "Cartagena",
  "status": "En Transito",
  /* ... resto de campos ... */
}
```

---

#### **Actualizar un envío**
```http
PUT /api/shipments/{id}
```

**Headers:**
```
Authorization: Bearer {token}
Content-Type: application/json
Accept: application/json
```

**Ejemplo:**
```http
PUT /api/shipments/1
```

**Body:**
```json
{
  "tracking_number": "TRK-0707-wvlj",
  "origin": "Medellín",
  "destination": "Bogotá",
  "status": "En Alistamiento",
  "remesa": "REM.2025-100",
  "manifiesto": "MAN-2025-100",
  "date_manifiesto": "2025-11-23",
  "plate": "KVX371",
  "weight": 154,
  "declared_price": 50000,
  "is_active": true,
  "observation": "Actualización desde postman",
  "third_id_driver": 1,
  "third_id_remite": 2,
  "third_id_destin": 3,
  "merchandise_id": 1
}
```

**Notas:**
- El campo `updated_by` se actualiza automáticamente con el usuario autenticado

**Respuesta exitosa (200):**
```json
{
  "id": 1,
  "tracking_number": "TRK-0707-wvlj",
  /* ... campos actualizados ... */
  "updated_by": 1
}
```

---

#### **Activar un envío**
```http
PATCH /api/shipments/{id}/activate
```

**Headers:**
```
Authorization: Bearer {token}
Accept: application/json
```

**Ejemplo:**
```http
PATCH /api/shipments/1/activate
```

**Respuesta exitosa (200):**
```json
{
  "message": "Envío activado exitosamente",
  "shipment": {
    "id": 1,
    "is_active": true,
    /* ... resto de campos ... */
  }
}
```

---

#### **Desactivar un envío**
```http
PATCH /api/shipments/{id}/deactivate
```

**Headers:**
```
Authorization: Bearer {token}
Accept: application/json
```

**Ejemplo:**
```http
PATCH /api/shipments/1/deactivate
```

**Respuesta exitosa (200):**
```json
{
  "message": "Envío desactivado exitosamente",
  "shipment": {
    "id": 1,
    "is_active": false,
    /* ... resto de campos ... */
  }
}
```

---

#### **Eliminar un envío (Soft Delete)**
```http
DELETE /api/shipments/{id}
```

**Headers:**
```
Authorization: Bearer {token}
Accept: application/json
```

**Ejemplo:**
```http
DELETE /api/shipments/1
```

**Respuesta exitosa (200):**
```json
{
  "message": "Envío eliminado exitosamente"
}
```

**Nota:** El envío se marca como eliminado (`deleted_at`) pero permanece en la base de datos.

---

##  Credenciales de Prueba

Después de ejecutar `php artisan db:seed`:

**Usuario Administrador:**
- **Email:** `edward.gabriel@grupooet.com`
- **Password:** `password`

**Datos generados:**
- 6 usuarios
- 60 terceros (conductores, remitentes, destinatarios)
- 90 mercancías
- 20 envíos

---


##  Estructura del Proyecto

```
traza-shipments/
├── app/
│   ├── Http/Controllers/Api/
│   │   ├── AuthController.php
│   │   └── ShipmentController.php
│   └── Models/
│       ├── Third.php
│       ├── Merchandise.php
│       ├── Shipment.php
│       └── User.php
├── database/
│   ├── migrations/
│   ├── factories/
│   └── seeders/
├── routes/
│   └── api.php
└── README.md
```


Hecho con Amor <3 Edward Gabriel Acosta


