# Чебоксарское музыкальное училище — Chmuzuch

Сайт и CMS БПОУ «Чебоксарское музыкальное училище им. Ф. П. Павлова» на Laravel 9, MySQL, Vite и Three.js. Динамические страницы, интерактивная главная, STL-модели и PWA.

> Разработка: `feature/legacy-site-crawler`. Не переносить в `main` без отдельного согласования. Оригинальный сайт используется только как ориентир структуры, автоматический импорт контента не выполняется.

## Развёртывание на виртуальном хостинге Timeweb

Инструкция для обычного shared hosting, **не VPS**. Используется подход из проекта [vdmsh](https://github.com/asbcorp24/vdmsh), но команды адаптированы под Laravel 9. Точные названия пунктов панели Timeweb могут отличаться.

### 1. Требования и подготовка

- PHP **8.1** (поддерживается Laravel 9) или совместимая версия PHP с расширениями `mbstring`, `openssl`, `pdo_mysql`, `tokenizer`, `xml`, `ctype`, `fileinfo`, `bcmath`.
- MySQL/MariaDB, доступ к управлению базами данных в панели.
- Composer 2 и SSH желательны. Если Node.js недоступен на хостинге, собирайте фронтенд локально.
- HTTPS-сертификат для PWA и Service Worker.
- Отдельная тестовая площадка или поддомен до переноса основного домена.

**Критично:** веб-корень должен указывать на папку `public` проекта. Если Timeweb не позволяет менять document root на `public`, не размещайте целиком Laravel в публичном `public_html`: сначала согласуйте безопасную схему каталогов с поддержкой хостинга.

### 2. Создание сайта и БД

В панели Timeweb создайте сайт, выберите PHP и создайте MySQL-базу с отдельным пользователем. Включите HTTPS. Уточните абсолютный путь сайта в файловом менеджере или через SSH.

### 3. Размещение проекта

Если Git и SSH доступны:

```bash
cd /ПУТЬ/К/КАТАЛОГУ/ПРОЕКТА
git clone -b feature/legacy-site-crawler https://github.com/asbcorp24/Chmuzuch.git .
composer install --no-dev --prefer-dist --optimize-autoloader
cp .env.example .env
php artisan key:generate
```

Если Git/Composer недоступны, подготовьте проект локально с `composer install --no-dev --prefer-dist --optimize-autoloader`, загрузите файлы вместе с `vendor/` через SFTP и создайте `.env` вручную. Не загружайте локальный `.env` с секретами.

### 4. Настройка .env

```dotenv
APP_NAME="ЧМУ"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://ВАШ-ДОМЕН
LOG_CHANNEL=stack
LOG_LEVEL=warning

DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=ИМЯ_БД
DB_USERNAME=ПОЛЬЗОВАТЕЛЬ_БД
DB_PASSWORD=ПАРОЛЬ_БД

SESSION_DRIVER=file
CACHE_DRIVER=file
FILESYSTEM_DISK=public
```

Укажите реальные значения БД из панели Timeweb; `DB_HOST` может отличаться от `localhost`. `APP_KEY` генерируется командой `php artisan key:generate` и не публикуется. `APP_DEBUG=false` обязателен на рабочем домене.

### 5. Сборка интерфейса и миграции

Если Node.js доступен на сервере:

```bash
npm install
npm run build
```

Иначе на локальном компьютере запустите `npm install && npm run build` и загрузите каталог `public/build/` на хостинг. На сервере:

```bash
php artisan migrate --force
php artisan storage:link
php artisan optimize:clear
php artisan config:cache
php artisan view:cache
```

**Не выполняйте `db:seed` автоматически**: миграция старого сайта и импорт материалов отдельно согласуются. Проверьте, предусмотрен ли в проекте способ первичного создания администратора, прежде чем открывать сайт для посетителей.

Если `storage:link` не поддерживается хостингом, уточните у Timeweb возможность создания символической ссылки `public/storage -> storage/app/public`; не переносите приватные файлы в общедоступный каталог.

### 6. Права и безопасность

Каталоги `storage/` и `bootstrap/cache/` должны быть доступны на запись PHP-процессу. Не используйте `chmod 777`. Запретите публичный доступ к `.env`, `vendor/`, `storage/` и исходникам приложения настройкой веб-корня на `public`.

Для STL и медиа предусмотрен диск `public`. Проверьте ограничения размера загружаемых файлов: `upload_max_filesize`, `post_max_size` и ограничения Timeweb. Для PWA требуются HTTPS и корректная отдача `/manifest.webmanifest`, `/sw.js`, `/offline.html`.

### 7. Проверка после установки

```bash
php artisan about
php artisan migrate:status
php artisan route:list
```

Проверьте в браузере главную страницу, меню, динамические страницы, авторизацию администратора, загрузку STL, стандартную 3D-модель при отсутствии STL, медиа, концерты и установку PWA на Android. Проверьте отсутствие ошибок 404/500 и консоль браузера. Не считайте PWA полностью готовым до теста установки на устройстве.

### 8. Обновление

Перед каждым обновлением сделайте резервную копию БД и `storage/app/public`. При SSH:

```bash
git pull --ff-only
composer install --no-dev --prefer-dist --optimize-autoloader
php artisan migrate --force
php artisan optimize:clear
php artisan config:cache
php artisan view:cache
```

Если менялись JS/CSS, заново выполните `npm run build` локально и загрузите `public/build`, либо соберите на хостинге, если Node.js доступен. После обновления проверьте PWA и при необходимости смените версию кэша Service Worker.

### 9. Cron и очереди

Для Laravel Scheduler, **только если он используется**, настройте в панели Timeweb задачу каждую минуту (если тариф поддерживает такую частоту):

```bash
cd /ПУТЬ/К/ПРОЕКТУ && php artisan schedule:run
```

На виртуальном хостинге не рассчитывайте на постоянный процесс `queue:work` без поддержки со стороны провайдера. Для простых задач можно использовать `QUEUE_CONNECTION=sync`; для фоновых заданий нужна отдельная согласованная схема.

## Дополнительно

- Карта структуры старого сайта: [docs/OLD_SITE_CONTENT_MAP.md](docs/OLD_SITE_CONTENT_MAP.md).
- Референс процесса установки: [asbcorp24/vdmsh](https://github.com/asbcorp24/vdmsh).


## Развёртывание на Timeweb

Проект использует Laravel 9 (PHP 8.1/8.2), MySQL и Vite. Как и в asbcorp24/vdmsh, для production рекомендуется сервер с SSH, Composer 2, Node.js 20, nginx/Apache и HTTPS. В Timeweb укажите корневой каталог сайта на `/путь/к/Chmuzuch/public`. На виртуальном хостинге предварительно проверьте возможность настроить document root и символическую ссылку storage.

```bash
git clone --branch feature/legacy-site-crawler https://github.com/asbcorp24/Chmuzuch.git
cd Chmuzuch
composer install --no-dev --optimize-autoloader
cp .env.example .env
php artisan key:generate
```

В `.env` установите `APP_ENV=production`, `APP_DEBUG=false`, `APP_URL=https://ВАШ-ДОМЕН`, параметры MySQL и `FILESYSTEM_DISK=public`. Не публикуйте пароль БД или APP_KEY.

```bash
php artisan migrate --force
php artisan storage:link
npm install
npm run build
php artisan optimize:clear
php artisan config:cache
php artisan view:cache
```

Настройте права на запись в `storage` и `bootstrap/cache` для пользователя PHP, без chmod 777. Для STL и медиа обязательно проверьте URL `/storage/...`.

Первого администратора создайте через `php artisan tinker`, используя модель `App\\Models\\User`, роль `super_admin`, `is_active=true` и пароль, хешированный `Hash::make`. До создания пользователя проверьте схему таблицы users. Вход: `/admin/login`.

PWA: проверьте по HTTPS `/manifest.webmanifest`, `/sw.js`, `/offline.html`, `/pwa-icon.svg`. Установка на Android и работа офлайн требуют проверки в браузере. PNG-иконки 192 и 512 пикселей пока необходимо добавить отдельно.

Обновление: сделайте резервную копию БД, `.env` и `storage/app/public`; затем выполните `git pull --ff-only origin feature/legacy-site-crawler`, `composer install --no-dev --optimize-autoloader`, `php artisan migrate --force`, `npm install && npm run build`, `php artisan optimize:clear && php artisan config:cache && php artisan view:cache`. Не используйте `migrate:fresh` на production.

**Отличия от vdmsh:** здесь Laravel 9, ветка `feature/legacy-site-crawler`, и отсутствует подтверждённый production-сидер администратора. Не запускайте `migrate --seed` без проверки. Перенос в `main` — только после отдельного согласования.
