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

## Desenvolupament del 5è Sprint

### Correccions i Millores

- Corregir els errors del 4t sprint.
- Afegir el camp `user_id` a la taula de vídeos perquè es guardi l’usuari que l’ha afegit.
- Modificar el **controller**, **model** i **helpers** per suportar aquest canvi.
- Corregir qualsevol test d’sprints anteriors que falli a causa d’aquest canvi.

### UsersManageController

- Crear el **UsersManageController** amb les funcions:
    - `testedBy`
    - `index`
    - `store`
    - `edit`
    - `update`
    - `delete`
    - `destroy`

### UsersController

- Crear les funcions:
    - `index`
    - `show`

### Vistes del CRUD d’Usuaris

Només poden veure-les els usuaris amb permisos adequats.

- `resources/views/users/manage/index.blade.php`
- `resources/views/users/manage/create.blade.php`
- `resources/views/users/manage/edit.blade.php`
- `resources/views/users/manage/delete.blade.php`

#### Detalls de les vistes:

- **index.blade.php**: afegir la taula del CRUD d’usuaris.
- **create.blade.php**: afegir el formulari per afegir usuaris, utilitzant l’atribut `data-qa` per facilitar els tests.
- **edit.blade.php**: afegir la taula del CRUD d’usuaris.
- **delete.blade.php**: afegir la confirmació d’eliminació de l’usuari.

### Vista General d’Usuaris

- Crear la vista `resources/views/users/index.blade.php` on:
    - Es vegin tots els usuaris.
    - Es pugui cercar un usuari.
    - En clicar-hi, es mostri el detall de l’usuari i els seus vídeos.

### Helpers

- Crear els permisos per a la gestió d’usuaris (CRUD).
- Assignar aquests permisos als **superadmins**.

### Feature Tests

#### UsersTest

Afegir els tests següents:

- `user_without_permissions_can_see_default_users_page`
- `user_with_permissions_can_see_default_users_page`
- `not_logged_users_cannot_see_default_users_page`
- `user_without_permissions_can_see_user_show_page`
- `user_with_permissions_can_see_user_show_page`
- `not_logged_users_cannot_see_user_show_page`

#### UsersManageControllerTest

Afegir els tests següents:

- `loginAsVideoManager`
- `loginAsSuperAdmin`
- `loginAsRegularUser`
- `user_with_permissions_can_see_add_users`
- `user_without_users_manage_create_cannot_see_add_users`
- `user_with_permissions_can_store_users`
- `user_without_permissions_cannot_store_users`
- `user_with_permissions_can_destroy_users`
- `user_without_permissions_cannot_destroy_users`
- `user_with_permissions_can_see_edit_users`
- `user_without_permissions_cannot_see_edit_users`
- `user_with_permissions_can_update_users`
- `user_without_permissions_cannot_update_users`
- `user_with_permissions_can_manage_users`
- `regular_users_cannot_manage_users`
- `guest_users_cannot_manage_users`
- `superadmins_can_manage_users`

### Rutes

- Crear les rutes `users/manage` per al CRUD d’usuaris amb el seu middleware corresponent.
- Crear la ruta de **l’índex** i **show** d’usuaris.
- Assegurar que aquestes rutes només apareixen quan l’usuari està logejat.
- Permetre la navegació entre pàgines.

---

### Registre de l'Sprint

- Afegir a `resources/markdown/terms` el que s’ha fet en aquest sprint.


# Guia del projecte VideosAppSteven

**Benvinguts al projecte VideosAppSteven**, una aplicació desenvolupada per gestionar i visualitzar vídeos utilitzant el framework Laravel. Aquest document explica l'objectiu del projecte i les funcionalitats desenvolupades durant tots els sprints.

---

## **Objectiu del projecte**
VideosAppSteven és una plataforma que permet gestionar vídeos i sèries amb funcionalitats CRUD, control d'accés per rols i relacions entre entitats.

---

## **Desenvolupament del 6è Sprint**

### Correccions i millores
- Corregits els errors del 5è sprint
- Verificat que no fallen tests d'sprints anteriors

### Funcionalitats per a Regular Users
- Regular users ara poden crear vídeos
- Afegides funcions CRUD a `VideoController` per regular users
- Implementats botons CRUD a la vista de vídeos

### Implementació de Sèries
#### Migració
php
Schema::create('series', function (Blueprint $table) {
    $table->id();
    $table->string('title');
    $table->text('description');
    $table->string('image');
    $table->string('user_name');
    $table->string('user_photo_url');
    $table->timestamp('published_at');
    $table->timestamps();
});

# Desenvolupament del 7è Sprint

## Esdeveniments i Notificacions

- S’ha creat l’event ```VideoCreated``` per capturar la creació de vídeos i generar notificacions.
- S’ha implementat el *listener* ```SendVideoCreatedNotification```, que:
    - Envia un correu als administradors amb un *Mailable* personalitzat (```VideoCreatedMail```).
    - Envia una notificació *broadcast* en temps real via Pusher.
    - Desa la notificació a la base de dades (via ```database```).
- S’ha creat el fitxer de notificació ```App\Notifications\VideoCreated```, que suporta els canals ```broadcast```, ```database``` i (opcionalment) ```mail```.

## Notificacions en temps real amb Pusher i Laravel Echo

- Integració amb Pusher per gestionar notificacions en temps real.
- Instal·lats els paquets ```laravel-echo``` i ```pusher-js```.
- Configurat ```resources/js/bootstrap.js``` amb Laravel Echo.
- Creat component ```Notifications.vue``` que:
    - Mostra les notificacions rebudes via Pusher.
    - Carrega les notificacions de base de dades.
    - Mostra un missatge quan no hi ha notificacions.

## Vista i Ruta de Notificacions

- S’ha creat la vista Blade per a la pàgina ```/notifications``` que inclou el component Vue.
- La ruta ```notifications``` només és visible per a usuaris amb permisos de *superadministrador*.
- Afegit enllaç a la *navbar* protegida amb ```@can('manage-users')```.

## Enviament de correus

- Registre i configuració amb Mailtrap.
- Creació del *Mailable* personalitzat amb una vista HTML estilitzada (```emails.video_created.blade.php```).
- S’ha desactivat l’enviament de correus duplicats mantenint només el correu amb el disseny personalitzat.

## Configuració de Broadcast

- Creació manual de ```config/broadcasting.php``` per configurar Pusher com a *driver* per defecte.
- Configuració de ```.env``` amb les credencials de Pusher.

## Tests

- *Feature tests* a ```VideoNotificationsTest.php```:
    - ```test_video_created_event_is_dispatched```: comprova que l’event es dispara correctament.
    - ```test_push_notification_is_sent_when_video_is_created```: comprova que la notificació s’envia via *broadcast*.

## Altres

- Utilització de ```RefreshDatabase``` per evitar afectar la base de dades real.
- Base de dades de test configurada amb SQLite *in-memory*.

## Conclusió

Durant aquest setè sprint s’ha introduït comunicació reactiva amb notificacions en temps real i correus, controlat per esdeveniments, i s’ha garantit la seguretat mostrant la informació només a usuaris autoritzats. S’ha millorat també la cobertura de tests i la integració amb serveis externs com Mailtrap i Pusher.
