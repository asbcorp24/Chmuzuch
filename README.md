# Чебоксарское музыкальное училище — Chmuzuch

Сайт и CMS БПОУ «Чебоксарское музыкальное училище им. Ф. П. Павлова». Стек: Laravel 9, PHP 8.1+, MySQL/MariaDB, Vite, Three.js. Публичные страницы, концерты, медиатека, динамические 3D-модели STL и PWA.

**Рабочая ветка:** `feature/legacy-site-crawler`. В `main` изменения переносятся только после подтверждения. Старый сайт используется как источник структуры; автоматический импорт старого контента не запускайте без отдельного решения.

## Развёртывание на Timeweb

Инструкция ориентирована на **Timeweb VPS/VDS с SSH и доступом к настройкам веб-сервера**. На обычном виртуальном хостинге без SSH/Node.js/смены document root некоторые шаги могут быть недоступны. Аналогичный процесс используется в [vdmsh](https://github.com/asbcorp24/vdmsh), но там Laravel 11, а здесь Laravel 9.

### Требования

- PHP 8.1–8.3 с расширениями `mbstring`, `openssl`, `pdo_mysql`, `xml`, `ctype`, `fileinfo`, `tokenizer`, `bcmath`.
- MySQL 8 / совместимая MariaDB, Composer 2, Node.js 20 и npm.
- nginx + PHP-FPM либо Apache; HTTPS (Let's Encrypt).
- Доступ на запись в `storage` и `bootstrap/cache`.
- Document root домена **строго `<путь-к-проекту>/public`**, не корень репозитория.

### 1. Получить код

Создайте сайт и БД в панели Timeweb. В SSH перейдите в каталог проекта (путь зависит от выбранного тарифа и конфигурации):

```bash
cd /var/www
git clone --branch feature/legacy-site-crawler https://github.com/asbcorp24/Chmuzuch.git chmuzuch
cd chmuzuch
composer install --no-dev --optimize-autoloader
cp .env.example .env
php artisan key:generate
```

### 2. Настроить окружение

В `.env` задайте свои реальные значения (пароли не коммитить):

```dotenv
APP_NAME="Чебоксарское музыкальное училище"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://ВАШ-ДОМЕН
LOG_LEVEL=warning

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=ИМЯ_БД
DB_USERNAME=ПОЛЬЗОВАТЕЛЬ_БД
DB_PASSWORD=СЕКРЕТНЫЙ_ПАРОЛЬ

FILESYSTEM_DISK=public
SESSION_DRIVER=file
CACHE_DRIVER=file
```

Настройте A/AAAA DNS-записи на IP сервера и выдайте сертификат HTTPS в панели Timeweb. Для PHP-FPM установите права на запись **только** для `storage` и `bootstrap/cache`; права `777` не используйте.

### 3. Миграции и сборка

```bash
php artisan migrate --force
php artisan storage:link
npm install
npm run build
php artisan optimize:clear
php artisan config:cache
php artisan view:cache
```

Не запускайте `db:seed` без проверки сидеров: импорт старых материалов не является частью развёртывания. Создание первого администратора необходимо проверить отдельно по существующим маршрутам и механизму авторизации.

### 4. Настроить веб-сервер

В Timeweb задайте корневой каталог сайта `/var/www/chmuzuch/public` (или фактический путь). Запросы должны попадать в `public/index.php`; закрывайте доступ к `.env`, `.git`, `storage` за пределами публичного симлинка и служебным файлам. Включите HTTPS и перенаправление HTTP → HTTPS.

Для nginx используйте стандартную конфигурацию Laravel с `try_files $uri $uri/ /index.php?$query_string;` и правильным PHP-FPM socket. Не копируйте чужой socket или пользователя PHP-FPM без проверки.

### 5. Проверить после установки

```bash
php artisan about
php artisan migrate:status
php artisan route:list
test -f public/build/manifest.json && echo "Vite OK"
test -L public/storage && echo "Storage link OK"
curl -I https://ВАШ-ДОМЕН/
curl -I https://ВАШ-ДОМЕН/manifest.webmanifest
curl -I https://ВАШ-ДОМЕН/sw.js
```

В браузере проверьте главную, меню, динамические страницы, загрузку STL в CMS, концерты, медиаплеер, вход администратора, адаптивность, установку PWA и отсутствие ошибок в консоли. В PWA сейчас SVG-иконка; для максимальной совместимости стоит дополнительно подготовить PNG 192×192 и 512×512. HTTPS обязателен для Service Worker.

### 6. Обновление

Перед обновлением сохраните дамп БД и каталог `storage/app/public`. Затем:

```bash
git checkout feature/legacy-site-crawler
git pull --ff-only
composer install --no-dev --optimize-autoloader
php artisan migrate --force
npm install
npm run build
php artisan optimize:clear
php artisan config:cache
php artisan view:cache
```

Если на VPS установлен Supervisor и используются очереди, после релиза выполните `php artisan queue:restart`. Если приложение использует планировщик, добавьте cron на `php artisan schedule:run` раз в минуту.

### Важно для production

Не включайте `APP_DEBUG=true`. Не публикуйте `.env`, дампы БД и ключи. Убедитесь, что после релиза Vite-сборка доступна, `public/storage` ссылается на хранилище, и файлы STL отдаются с корректным доступом. При проблемах с PWA проверьте обновление Service Worker и кеш браузера.

## Архитектура и миграция

Источник для будущей сверки структуры и контента: https://xn--g1ajvbu.xn--p1ai/. См. `docs/OLD_SITE_CONTENT_MAP.md`.
