# Guia del projecte VideosAppSteven

**Benvinguts al projecte VideosAppSteven**, una aplicació desenvolupada per gestionar i visualitzar vídeos utilitzant el framework Laravel. Aquest document explica breument l'objectiu del projecte i les funcionalitats desenvolupades durant el **1r sprint**, **2n sprint** i **3r sprint**.

---

## **Objectiu del projecte**
VideosAppSteven és una plataforma que permet gestionar vídeos amb funcionalitats bàsiques com visualitzar la informació d'un vídeo, treballar amb dates en formats llegibles per a l'usuari, i assegurar-se que la creació d'usuaris, vídeos i la seva associació a equips funcioni correctament. El projecte utilitza **Laravel Jetstream** amb **Livewire**, equips (teams), i una base de dades SQLite.

---

## **Desenvolupament del 1r Sprint**

### **1. Creació del projecte**
El projecte es va iniciar amb el nom **VideosAppSteven**, utilitzant les opcions següents:
- Jetstream amb **Livewire**.
- Suport per a **teams**.
- Base de dades en **SQLite**.
- Tests amb **PHPUnit**.

### **2. Creació dels Helpers**
S'han creat helpers a la carpeta `app` per facilitar la gestió d'usuaris per defecte. També s'han definit credencials d'usuari a la configuració del projecte (`config`) i es permet carregar valors des del fitxer `.env`.

### **3. Tests de Helpers**
S'ha implementat el test `HelpersTest` per validar el següent:
- Creació de l'usuari per defecte amb els camps:
    - `name`, `email` i `password` (encriptada).
- Creació d'un usuari professor per defecte.
- Associació dels usuaris a un equip (team).

---

## **Desenvolupament del 2n Sprint**

### **1. Correcció dels errors del 1r Sprint**
S'han corregit els errors detectats en els tests del primer sprint, assegurant que tot funcioni correctament.

### **2. Configuració de PHPUnit**
S'han activat les línies comentades del fitxer `phpunit.xml` per configurar una base de dades temporal per a les proves. Això evita qualsevol afectació a la base de dades real.

### **3. Creació de la migració dels vídeos**
S'ha creat una migració amb els camps següents:
- `id`, `title`, `description`, `url`, `published_at`, `previous`, `next`, `series_id`.

### **4. Model de vídeos**
S'ha creat el model `Video` amb:
- El camp `published_at` definit com una data.
- Funcions personalitzades per formatar les dates:
    - `getFormattedPublishedAtAttribute`: retorna la data en format llegible, ex: "13 de gener de 2025".
    - `getFormattedForHumansPublishedAtAttribute`: retorna la data relativa, ex: "fa 2 hores".
    - `getPublishedAtTimestampAttribute`: retorna el timestamp Unix.

### **5. Controlador i vista**
- S'ha creat el controlador `VideosController` amb les funcions:
    - `show`: mostra la informació d'un vídeo específic.
    - `testedBy`: inclou la lògica per a validar amb tests.
- S'ha creat la vista `resources/views/videos/show.blade.php` per mostrar la informació d'un vídeo amb el seu títol, descripció, URL i formats de data.

### **6. Helpers i DatabaseSeeder**
- S'ha creat un helper per a crear vídeos per defecte.
- Els usuaris i vídeos per defecte s'han afegit al fitxer `DatabaseSeeder`.

### **7. Layout de VideosApp**
- S'ha creat un component `VideosAppLayout` ubicat a:
    - `app/View/Components/VideosAppLayout.php`.
    - `resources/views/layouts/videos-app-layout.blade.php`.

### **8. Tests de vídeos**
S'han implementat diversos tests per assegurar la funcionalitat dels vídeos:
- A `tests/Unit/VideosTest`:
    - `can_get_formatted_published_at_date`: comprova que es retorna la data en format llegible.
    - `can_get_formatted_published_at_date_when_not_published`: comprova que retorna `null` si la data no està definida.
- A `tests/Feature/VideosTest`:
    - `users_can_view_videos`: comprova que els usuaris poden veure vídeos existents.
    - `users_cannot_view_not_existing_videos`: comprova que no es pot accedir a vídeos inexistents.

---

## **Desenvolupament del 3r Sprint**

### Correcció d'Errors
- Correcció dels errors detectats en el segon sprint.

### Instal·lació de Paquets
- Instal·lació del paquet `spatie/laravel-permission`. [Documentació](https://spatie.be/docs/laravel-permission/v6/installation-laravel).
### Migracions
- Creació d'una migració per afegir el camp `super_admin` a la taula d'usuaris.

## Desenvolupament
### Model d'Usuaris
- Afegida la funció `testedBy()`.
- Afegida la funció `isSuperAdmin()`.

### Helpers
- Modificada la funció `create_default_professor()` per incloure `superadmin` al professor.
- Creada la funció `add_personal_team()` per separar la creació dels equips dels usuaris.

### Creació d'Usuaris per Defecte
- **Regular User:** `create_regular_user()` (`regular@videosapp.com`, `123456789`).
- **Video Manager:** `create_video_manager_user()` (`videosmanager@videosapp.com`, `123456789`).
- **Super Admin:** `create_superadmin_user()` (`superadmin@videosapp.com`, `123456789`).

### Definició de Gates i Permisos
- Creació de les funcions `define_gates()` i `create_permissions()`.
### Registre de Polítiques d'Autorització
- A `AppServiceProvider`, registre de les polítiques d'autorització i definició de les portes d'accés (`gates`).
### DatabaseSeeder
- Assignació per defecte dels permisos i usuaris (`superadmin`, `regular user`, `video manager`).

### Publicació de Stubs
- Publicació dels `stubs`. [Referència](https://laravel-news.com/customizing-stubs-in-laravel).

## **Desenvolupament del 4t Sprint**
### Feature Tests
- **VideosManageControllerTest (tests/Feature/Videos):**
    - `user_with_permissions_can_manage_videos()`
    - `regular_users_cannot_manage_videos()`
    - `guest_users_cannot_manage_videos()`
    - `superadmins_can_manage_videos()`
    - `loginAsVideoManager()`
    - `loginAsSuperAdmin()`
    - `loginAsRegularUser()`
    - `user_with_permissions_can_see_add_videos()`
    - `user_without_videos_manage_create_cannot_see_add_videos()`
    - `user_with_permissions_can_store_videos()`
    - `user_without_permissions_cannot_store_videos()`
    - `user_with_permissions_can_destroy_videos()`
    - `user_without_permissions_cannot_destroy_videos()`
    - `user_with_permissions_can_see_edit_videos()`
    - `user_without_permissions_cannot_see_edit_videos()`
    - `user_with_permissions_can_update_videos()`
    - `user_without_permissions_cannot_update_videos()`

### Creació del CRUD
- S'ha creat el CRUD complet per a la gestió de vídeos amb les vistes, permisos i middleware corresponent.
- Afegit navbar i footer a la plantilla principal.
- Implementació de la vista de l'índex amb la visualització de vídeos.

## **Conclusió**
Aquest projecte ha estat un exercici complet que ha cobert la configuració inicial, gestió d'usuaris i vídeos, treball amb dates formatades, i l'ús de components, helpers, layouts i tests per garantir el bon funcionament de l'aplicació.
