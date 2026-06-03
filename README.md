# ⚽ GolTickets

<div align="center">

**Plataforma web de venta de entradas para partidos de fútbol, construida con arquitectura MVC en PHP.**

[Características](#-características) · [Estructura](#-estructura-del-proyecto) · [Instalación](#-instalación) · [Módulos](#-módulos) · [Base de datos](#-base-de-datos)

</div>

---

## 📋 Descripción

**GolTickets** es una aplicación web full-stack pensada para la compra de entradas de eventos de fútbol. Permite a los usuarios explorar partidos por competición, ciudad o equipo, consultar detalles de cada evento y filtrar resultados de forma dinámica. Incluye un sistema completo de autenticación con **JWT**, gestión de perfil de usuario y un sistema de **likes** por partido. La aplicación sigue el patrón **MVC (Modelo-Vista-Controlador)** con PHP en el backend y jQuery + AJAX en el frontend.

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
- 🔐 **Autenticación JWT** — Login y registro con tokens HS256, refresco automático y control de sesión
- ❤️ **Sistema de likes** — Los usuarios autenticados pueden guardar sus partidos favoritos
- 👤 **Perfil de usuario** — Edición inline de username y contraseña con validación, avatar via RoboHash y sección de eventos favoritos

---

## 🗂 Estructura del Proyecto

```
GolTicketsV22_MVC/
│
├── index.php                          # Entry point — enrutador principal
│
├── model/
│   ├── connect.php                    # Clase de conexión PDO reutilizable
│   ├── JWT.php                        # Librería JWT (encode/decode HS256)
│   ├── jwt.ini                        # Configuración: header y secret del token
│   └── middleware_auth.php            # Funciones create_token() y decode_token()
│
├── module/
│   ├── auth/
│   │   ├── controller/
│   │   │   └── controller_auth.php    # Casos: login, register, logout, controluser, actividad, refresh
│   │   ├── model/
│   │   │   └── DAOAuth.php            # Queries: select_user, insert_user, select_mail, select_username
│   │   └── view/
│   │       └── auth.html              # Formulario login/registro con tabs
│   │
│   ├── profile/
│   │   ├── controller/
│   │   │   └── controller_profile.php # Casos: get_user_data, update_account, get_liked_events
│   │   ├── model/
│   │   │   └── DAOProfile.php         # Queries: select_data_user, update_username/password/full, select_liked_events
│   │   └── view/
│   │       └── profile.html           # Sidebar nav + vistas Personal Info y Liked Events
│   │
│   ├── home/
│   │   ├── controller/
│   │   │   └── controller_home.php    # Casos: carousel, categories, mostVisited, cities, teams
│   │   ├── model/
│   │   │   └── DAOHome.php            # Queries: competiciones, ciudades, equipos, carrusel
│   │   └── view/
│   │       └── home.html              # Plantilla HTML de la página de inicio
│   │
│   ├── inicio/
│   │   └── view/
│   │       └── inicio.php             # Vista de bienvenida / splash
│   │
│   ├── search/
│   │   ├── controller/
│   │   │   └── controller_search.php  # Caso: autocomplete
│   │   └── model/
│   │       └── DAOSearch.php          # UNION ALL sobre partidos, equipos, ciudades, competiciones
│   │
│   └── shop/
│       ├── controller/
│       │   └── controller_shop.php    # Casos: listado, filtros, detalle, relacionados, likes
│       ├── model/
│       │   └── DAO_shop.php           # Queries: eventos, likes (like/dislike/load), visitas
│       └── view/
│           └── shop.html              # Plantilla HTML de la tienda
│
└── view/                              # Assets globales compartidos
    ├── css/                           # Hojas de estilo globales
    ├── img/
    │   ├── ciudad/                    # Imágenes de ciudades
    │   ├── competicion/               # Logos de competiciones
    │   ├── equipo/                    # Escudos de equipos
    │   ├── estadio/                   # Fotos de estadios
    │   ├── home/                      # Imágenes de la sección home
    │   └── partido/                   # Imágenes de partidos
    ├── inc/                           # Includes globales (header, footer…)
    ├── js/                            # JavaScript global (ajaxPromise, utils…)
    └── logo/                          # Logotipos de la aplicación
```

---

## 🚀 Instalación

### Requisitos previos

- PHP 8.x
- MySQL 8.x
- Servidor web (Apache/Nginx) o XAMPP/WAMP/Laragon
- Navegador moderno con soporte ES6+


### Configuración de la conexión (`model/connect.php`)

```php
class connect {
    static function con() {
        $host = '127.0.0.1';
        $user = "root";
        $pass = "";
        $db   = "golticket";
        $conexion = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
        $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $conexion;
    }
}
```

### Configuración JWT (`model/jwt.ini`)

```ini
header='{"typ":"JWT", "alg":"HS256"}'
secret=tu_clave_secreta
```

### Acceso

```
http://localhost/GolTicketsV22_MVC/index.php
```

---

## 📦 Módulos

### 🔐 Auth

Sistema completo de autenticación basado en **JWT (HS256)** almacenado en `localStorage`.

| Operación | Endpoint | Descripción |
|---|---|---|
| `register` | `?op=register` | Registro con validación de email y username únicos, hash **Argon2ID** |
| `login` | `?op=login` | Login por username o email, devuelve token JWT |
| `logout` | `?op=logout` | Destruye la sesión PHP |
| `controluser` | `?op=controluser` | Verifica token + sesión activa |
| `actividad` | `?op=actividad` | Comprueba inactividad (30 min) |
| `refresh_token` | `?op=refresh_token` | Renueva el token sin volver a hacer login |
| `refresh_cookie` | `?op=refresh_cookie` | Regenera el ID de sesión PHP |

El token tiene una vigencia de **10 minutos** y se refresca automáticamente. Los avatares se generan automáticamente desde **RoboHash** usando un hash SHA-256 del username.

#### Flujo de login

```
Usuario envía credenciales
        │
        ▼
DAOAuth::select_user() — busca por username OR email
        │
        ├─ No existe ──► json "error_user"
        │
        └─ Existe ──► password_verify(Argon2ID)
                          │
                          ├─ Incorrecto ──► json "error_passwd"
                          │
                          └─ Correcto ──► create_token() ──► localStorage.setItem('token_JWT')
                                              │
                                              └─ Redirige (o al detalle si venía de un like)
```

---

### 👤 Profile

Gestión de cuenta del usuario autenticado con dos pestañas:

**Personal Info** — edición inline campo a campo (username o contraseña por separado o ambos a la vez), con validación en frontend y 3 escenarios en backend:

| Escenario | Condición | Método DAO |
|---|---|---|
| A | Solo cambia username | `update_username_only()` |
| B | Solo cambia contraseña | `update_password_only()` (Argon2ID) |
| C | Cambia ambos | `update_user_full()` |

**Liked Events** — carga los partidos que el usuario ha marcado con ❤️, con Swiper por card, badge de precio y fecha, y botón directo al detalle.

---

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

El módulo de tienda ofrece un sistema de filtrado dinámico completo, con soporte de likes para usuarios autenticados:

- **Filtros** cargados desde la tabla `config_filters` de la BD (configurables sin tocar código)
- **Paginación** con `LIMIT` / `OFFSET`
- **Orden** personalizable (fecha, precio…)
- **Vista de detalle** con galería de imágenes, mapa Leaflet y eventos relacionados
- **Contador de visitas** actualizado en cada visualización de detalle
- **Sistema de likes** — toggle like/dislike por partido, requiere token JWT válido

#### Flujo del Shop

```
Entrada al shop
     │
     ├─ ¿URL tiene ?detalle=id?  ──► Carga detalle del partido
     │                                  ├─ Datos del evento
     │                                  ├─ Imágenes
     │                                  ├─ Extras (servicios del estadio)
     │                                  ├─ Mapa (Leaflet)
     │                                  ├─ Partidos relacionados
     │                                  └─ Estado del like (si hay token)
     │
     └─ No  ──► Carga listado
                  ├─ Lee filtros de localStorage
                  ├─ Carga config de filtros dinámicos
                  ├─ Cuenta total de eventos (para paginación)
                  ├─ Carga partidos paginados
                  └─ Carga likes del usuario (si hay token)
```

#### Operaciones de likes en el Shop

| Operación | Endpoint | Descripción |
|---|---|---|
| `control_likes` | `?op=control_likes` | Toggle: si no existe → like, si existe → dislike |
| `load_likes_user` | `?op=load_likes_user` | Carga todos los `id_partido` con like del usuario |

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

  ┌──────────────────────┐        ┌──────────────────────┐
  │        users         │        │    likes_usuario     │
  │──────────────────────│        │──────────────────────│
  │ id_usuario           │◄───────│ id_usuario           │
  │ username             │        │ id_partido ─────────►│ partido
  │ password (Argon2ID)  │        └──────────────────────┘
  │ mail                 │
  │ role                 │
  │ avatar               │
  └──────────────────────┘

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
| `users` | — | Usuarios registrados: username, email, password Argon2ID, role, avatar |
| `likes_usuario` | — | Relación N:M users ↔ partido (partidos favoritos) |
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
| Autenticación | JWT HS256 · Argon2ID · Sesiones PHP |
| Frontend | HTML5 · CSS3 (Custom Properties) · JavaScript ES6 |
| DOM / AJAX | jQuery 3 · `ajaxPromise` |
| Carruseles | Swiper.js |
| Mapas | Leaflet.js |
| Notificaciones | SweetAlert2 |
| Base de datos | MySQL 8.4 |
| Iconos | Google Material Symbols |
| Avatares | RoboHash (generados por hash SHA-256) |
| Persistencia cliente | `localStorage` |

---

## 📐 Patrones y convenciones

- **MVC estricto** — Cada módulo tiene su propia carpeta `controller/`, `model/` y `view/`
- **JWT stateless** — El token viaja en `localStorage` y se envía por POST en cada petición protegida; el middleware `decode_token()` lo valida en el servidor
- **Middleware centralizado** — `middleware_auth.php` expone `create_token()` y `decode_token()` reutilizables en cualquier controlador
- **AJAX centralizado** — Todas las llamadas usan `ajaxPromise()`, una abstracción propia sobre `$.ajax`
- **Filtros dinámicos** — La tabla `config_filters` permite añadir nuevos filtros al sidebar sin modificar código PHP ni JS
- **Delegación de eventos** — Todos los clicks usan `$(document).on(...)` para compatibilidad con DOM generado dinámicamente
- **Separación de responsabilidades** — El JS de cada módulo solo gestiona su sección; la comunicación entre módulos se hace vía `localStorage`

---

## 📸 Capturas de pantalla

![home](https://github.com/user-attachments/assets/1f1838c7-b8e6-4944-9679-113c4b07dd29)

![shop](https://github.com/user-attachments/assets/e787cec9-bae1-4412-95d7-b5bd87a9172d)

![detail](https://github.com/user-attachments/assets/475902cc-79e4-4aa2-8442-7c7a796073dd)

![auth](https://github.com/user-attachments/assets/e0a973b2-7b7a-4013-beb1-0b6ee15d2776)

![profile](https://github.com/user-attachments/assets/463da9a0-7e09-4a88-bb90-cc92fe55cbde)
