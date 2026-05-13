# ⚽ GolTickets

<div align="center">

**Plataforma web de venta de entradas para partidos de fútbol, construida con arquitectura MVC en PHP.**

[Características](#-características) · [Estructura](#-estructura-del-proyecto) · [Instalación](#-instalación) · [Módulos](#-módulos) · [Base de datos](#-base-de-datos)

</div>

---

## 📋 Descripción

**GolTickets** es una aplicación web full-stack pensada para la compra de entradas de eventos de fútbol. Permite a los usuarios explorar partidos por competición, ciudad o equipo, consultar detalles de cada evento y filtrar resultados de forma dinámica. La aplicación sigue el patrón **MVC (Modelo-Vista-Controlador)** con PHP en el backend y jQuery + AJAX en el frontend.

---

## ✨ Características

- 🎠 **Carrusel de partidos** — Próximos eventos destacados con Swiper.js y autoplay
- 🔥 **Partidos más visitados** — Ranking dinámico basado en visitas
- 🏆 **Filtrado por categoría** — Navega por competición, ciudad o equipo
- 🔍 **Búsqueda con autocompletado** — Búsqueda en tiempo real con debounce sobre partidos, equipos, ciudades y competiciones
- 🛒 **Shop de entradas** — Grid de partidos con paginación, sidebar de filtros dinámicos y orden personalizable
- 📍 **Mapas integrados** — Visualización de la ubicación del estadio con Leaflet
- 📄 **Vista de detalle** — Información completa del partido, imágenes, extras y eventos relacionados
- 💾 **Persistencia de filtros** — Los filtros se guardan en `localStorage` para navegar entre páginas sin perder el contexto
- 📊 **Contador de visitas** — Actualización automática de visitas por partido

---

## 🗂 Estructura del Proyecto

```
GolTicketsV21_MVC/
│
├── index.php                        # Entry point — enrutador principal
│
├── model/
│   └── connect.php                  # Clase de conexión PDO reutilizable
│
├── module/
│   ├── home/
│   │   ├── controller/
│   │   │   └── controller_home.php  # Casos: carousel, categories, mostVisited, cities, teams
│   │   ├── model/
│   │   │   └── DAOHome.php          # Queries: competiciones, ciudades, equipos, carrusel
│   │   └── view/
│   │       └── home.html            # Plantilla HTML de la página de inicio
│   │
│   ├── inicio/
│   │   └── view/
│   │       └── inicio.php           # Vista de bienvenida / splash
│   │
│   ├── search/
│   │   ├── controller/
│   │   │   └── controller_search.php # Caso: autocomplete
│   │   └── model/
│   │       └── DAOSearch.php         # UNION ALL sobre partidos, equipos, ciudades, competiciones
│   │
│   └── shop/
│       ├── controller/
│       │   └── controller_shop.php  # Casos: listado, filtros, detalle, relacionados
│       ├── model/
│       │   └── DAO_shop.php         # Queries complejas con JOINs y filtros dinámicos
│       └── view/
│           └── shop.html            # Plantilla HTML de la tienda
│
└── view/                            # Assets globales compartidos
    ├── css/                         # Hojas de estilo globales
    ├── img/
    │   ├── ciudad/                  # Imágenes de ciudades
    │   ├── competicion/             # Logos de competiciones
    │   ├── equipo/                  # Escudos de equipos
    │   ├── estadio/                 # Fotos de estadios
    │   ├── home/                    # Imágenes de la sección home
    │   └── partido/                 # Imágenes de partidos
    ├── inc/                         # Includes globales (header, footer…)
    ├── js/                          # JavaScript global (ajaxPromise, utils…)
    └── logo/                        # Logotipos de la aplicación
```

---

## 🚀 Instalación

### Requisitos previos

- PHP 8.x
- MySQL 8.x
- Servidor web (Apache/Nginx) o XAMPP/WAMP/Laragon
- Navegador moderno con soporte ES6+

### Pasos

```bash
# 1. Clona el repositorio
git clone https://github.com/tu-usuario/GolTicketsV21_MVC.git

# 2. Coloca el proyecto en tu directorio web
# Ejemplo con XAMPP:
cp -r GolTicketsV21_MVC/ /xampp/htdocs/

# 3. Importa la base de datos
mysql -u root -p < database/goltickets.sql

# 4. Configura la conexión
# Edita model/connect.php con tus credenciales
```

### Configuración de la conexión (`model/connect.php`)

```php
class connect {
    static function con() {
        $dsn = "mysql:host=localhost;dbname=goltickets;charset=utf8";
        return new PDO($dsn, 'tu_usuario', 'tu_contraseña', [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]);
    }
}
```

### Acceso

```
http://localhost/GolTicketsV21_MVC/index.php
```

---

## 📦 Módulos

### 🏠 Home

La página de inicio carga sus secciones de forma **paralela y asíncrona** mediante llamadas AJAX independientes:

| Función JS | Endpoint PHP | Descripción |
|---|---|---|
| `loadCarousel()` | `?op=homePageCarousel` | Carrusel de partidos destacados |
| `loadMostVisited()` | `?op=homePageMostVisited` | Top 4 partidos por visitas |
| `loadCategories()` | `?op=homePageCategory` | Grid de competiciones |
| `loadCities()` | `?op=homePageCities` | Slider de ciudades |
| `loadTeams()` | `?op=homePageTeams` | Slider de equipos |

Cada tarjeta (competición, ciudad, equipo) guarda un filtro en `localStorage` al hacer clic y redirige automáticamente al shop con ese filtro activo.

---

### 🛒 Shop

El módulo de tienda ofrece un sistema de filtrado dinámico completo:

- **Filtros** cargados desde la tabla `config_filters` de la BD (configurables sin tocar código)
- **Paginación** con `LIMIT` / `OFFSET`
- **Orden** personalizable (fecha, precio…)
- **Vista de detalle** con galería de imágenes, mapa Leaflet y eventos relacionados
- **Contador de visitas** actualizado en cada visualización de detalle

#### Flujo del Shop

```
Entrada al shop
     │
     ├─ ¿URL tiene ?detalle=id?  ──► Carga detalle del partido
     │                                  ├─ Datos del evento
     │                                  ├─ Imágenes
     │                                  ├─ Extras (productos adicionales)
     │                                  ├─ Mapa (Leaflet)
     │                                  └─ Partidos relacionados
     │
     └─ No  ──► Carga listado
                  ├─ Lee filtros de localStorage
                  ├─ Carga config de filtros dinámicos
                  ├─ Cuenta total de eventos (para paginación)
                  └─ Carga partidos paginados
```

---

### 🔍 Search

Autocompletado integrado en el header con búsqueda unificada:

- **Debounce de 250ms** para no saturar el servidor
- Resultados agrupados por tipo: Partidos · Equipos · Ciudades · Competiciones
- Al seleccionar un partido → redirige directamente al detalle
- Al seleccionar otro tipo → guarda filtro en `localStorage` y redirige al shop

---

## 🗄 Base de Datos

> Motor: **MySQL 8.4** · Charset: **utf8mb4_unicode_ci** · Nombre de la BD: `golticket`

### Diagrama de relaciones

```
                    ┌─────────────┐
                    │ competicion │
                    │─────────────│
                    │ id_competic.│◄──────────────────┐
                    │ nombre      │                   │
                    │ img         │                   │
                    └─────────────┘                   │
                                                      │
  ┌──────────┐     ┌────────────────────────────────────────┐     ┌──────────────┐
  │  ciudad  │     │               partido                  │     │    equipo    │
  │──────────│     │────────────────────────────────────────│     │──────────────│
  │ id_ciudad│◄────│ id_campo        id_competicion ────────┘     │ id_equipo    │
  │ nombre   │     │ id_equipolocal ────────────────────────────► │ nombre       │
  │ img      │     │ id_equipovisitante ────────────────────────► │ siglas       │
  └────┬─────┘     │ nombre_partido  precio  visitas              │ img          │
       │           │ fecha_partido   lat     lng                  └──────────────┘
       │           └──────┬─────────────────┬──────────────────┘
       ▼                  │                 │
  ┌──────────┐            │                 ▼
  │  campo   │◄───────────┘     ┌─────────────────────┐
  │──────────│                  │    img_partido       │
  │ id_campo │                  │─────────────────────│
  │ nombre   │                  │ id_img_partido       │
  │ img      │                  │ id_partido           │
  │ id_equipo│                  │ img                  │
  │ id_ciudad│                  └─────────────────────┘
  └──────────┘
                   ┌───────────────────┐        ┌────────────┐
                   │   partido_extra   │        │   extra    │
                   │───────────────────│        │────────────│
                   │ id_partido_extra  │───────►│ id_extra   │
                   │ id_partido        │        │ nombre     │
                   │ id_extra          │        │ img        │
                   └───────────────────┘        └────────────┘

  ┌────────────────────────────────────────────────────────┐
  │                    config_filters                      │
  │────────────────────────────────────────────────────────│
  │  id_filter  display_name  db_column  html_type         │
  │  join_table join_label    join_fk2                     │
  └────────────────────────────────────────────────────────┘
  (tabla de configuración independiente — sin claves foráneas)
```

### Descripción de tablas

| Tabla | Registros | Descripción |
|---|---|---|
| `partido` | 24 | Evento central: nombre, fecha, precio, visitas, lat/lng del estadio |
| `campo` | 5 | Estadios: Santiago Bernabéu, Camp Nou, Etihad… |
| `ciudad` | 5 | Madrid, Barcelona, Almería, Manchester, Castellón |
| `competicion` | 4 | LaLiga, Champions League, LaLiga 2, Copa del Rey |
| `equipo` | 5 | Real Madrid, FC Barcelona, CD Castellón, Man. City, UD Almería |
| `img_partido` | 48 | 2 imágenes por partido (24 × 2) |
| `extra` | 7 | Servicios del estadio: WiFi, Parking, Restaurante, Médico… |
| `partido_extra` | 72 | Relación N:M partido ↔ extra (3 extras por partido) |
| `config_filters` | 4 | Configuración dinámica de los filtros del sidebar |

### Filtros dinámicos (`config_filters`)

| Filtro | Columna BD | Tipo HTML | Notas |
|---|---|---|---|
| Ciudad | `nombre_ciudad` | `radio` | Join con tabla `ciudad` |
| Competición | `nombre_competicion` | `radio` | Join con tabla `competicion` |
| Equipo | `nombre_equipo` | `check` | Busca en `id_equipolocal` **y** `id_equipovisitante` |
| Precio | `precio` | `slider` | MIN/MAX calculado dinámicamente desde `partido` |

### Servicios disponibles (`extra`)

WiFi · Baños · Parada de Autobús · Asistencia médica · Parking · Restaurante · Acceso para silla de ruedas

---

## 🛠 Tecnologías

| Capa | Tecnología |
|---|---|
| Backend | PHP 8 · PDO · MVC artesanal |
| Frontend | HTML5 · CSS3 (Custom Properties) · JavaScript ES6 |
| DOM / AJAX | jQuery 3 · `ajaxPromise` / `ajaxForSearch` |
| Carruseles | Swiper.js |
| Mapas | Leaflet.js |
| Base de datos | MySQL 8 |
| Iconos | Google Material Symbols |
| Persistencia cliente | `localStorage` |

---

## 📐 Patrones y convenciones

- **MVC estricto** — Cada módulo tiene su propia carpeta `controller/`, `model/` y `view/`
- **AJAX centralizado** — Todas las llamadas usan `ajaxPromise()` / `ajaxForSearch()`, una abstracción propia sobre `$.ajax`
- **Filtros dinámicos** — La tabla `config_filters` permite añadir nuevos filtros al sidebar sin modificar código PHP ni JS
- **Delegación de eventos** — Todos los clicks usan `$(document).on(...)` para compatibilidad con DOM generado dinámicamente
- **Separación de responsabilidades** — El JS de cada módulo solo gestiona su sección; los clicks inter-módulo se comunican vía `localStorage`

---

## 📸 Capturas de pantalla

### HOME

![home](https://github.com/user-attachments/assets/1f1838c7-b8e6-4944-9679-113c4b07dd29)

### SHOP

![shop](https://github.com/user-attachments/assets/63ebd9d0-36cb-4c4b-b35b-0dadd16bd61a)

### DETAILS

![detail](https://github.com/user-attachments/assets/475902cc-79e4-4aa2-8442-7c7a796073dd)
