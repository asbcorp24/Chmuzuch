# Чебоксарское музыкальное училище — сайт и PWA

Laravel 9 / PHP 8.1+ / MySQL / Vite 4 / Three.js. Публичная CMS с интерактивной главной, концертами, медиа и STL-моделями.

> Развёртывание по принципу проекта [vdmsh](https://github.com/asbcorp24/vdmsh), адаптировано под **Timeweb**. Ветка разработки: `feature/legacy-site-crawler`. Не переносить в main без отдельного согласования.

## Требования

- Timeweb VPS/VDS (предпочтительно Ubuntu 22.04/24.04), SSH и возможность задать корень сайта на `public`.
- PHP **8.1–8.3** с расширениями `mbstring`, `openssl`, `pdo_mysql`, `xml`, `ctype`, `fileinfo`, `tokenizer`, `curl`, `zip`, `gd` (для Laravel 9 проверяйте совместимость выбранной версии PHP).
- MySQL 8+ / MariaDB, Composer 2, Node.js 20 LTS, npm, nginx/Apache, HTTPS.
- Для обычного виртуального хостинга Timeweb предварительно проверьте SSH, Composer, PHP CLI, поддержку rewrite и возможность выбрать каталог `public`. При отсутствии этих возможностей используйте VPS.

## 1. Создать сайт и базу данных

В панели Timeweb: создайте домен/сайт, базу MySQL и пользователя БД. Включите SSL-сертификат Let's Encrypt. Настройте DNS A/AAAA на IP сервера и дождитесь обновления DNS.

**Document root должен указывать на `.../chmuzuch/public`, а не на корень репозитория.** Не публикуйте `.env`, `storage`, `vendor` или исходники.

## 2. Развёртывание по SSH

Пример для VPS. Путь замените на каталог сайта, заданный в Timeweb:

```bash
cd /var/www
git clone --branch feature/legacy-site-crawler https://github.com/asbcorp24/Chmuzuch.git chmuzuch
cd chmuzuch
composer install --no-dev --prefer-dist --optimize-autoloader
cp .env.example .env
php artisan key:generate
```

Отредактируйте `.env`:

```dotenv
APP_NAME="Чебоксарское музыкальное училище"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://ВАШ-ДОМЕН
LOG_CHANNEL=stack
LOG_LEVEL=warning
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=ИМЯ_БД
DB_USERNAME=ПОЛЬЗОВАТЕЛЬ_БД
DB_PASSWORD=СЛОЖНЫЙ_ПАРОЛЬ
SESSION_DRIVER=file
CACHE_DRIVER=file
FILESYSTEM_DISK=public
```

Не размещайте пароли в Git. Убедитесь, что PHP CLI использует нужную версию (`php -v`).

```bash
php artisan migrate --force
php artisan storage:link
npm install
npm run build
php artisan optimize
```

**Важно:** здесь намеренно нет `migrate --seed`: старые материалы училища нельзя автоматически импортировать или публиковать без отдельного решения. Создание первого администратора нужно проверить по действующему механизму авторизации проекта до запуска.

Каталоги `storage` и `bootstrap/cache` должны быть доступны на запись пользователю PHP-FPM:

```bash
chmod -R ug+rwX storage bootstrap/cache
```

Не используйте `chmod 777`.

## 3. Настройки веб-сервера

- В Timeweb выберите PHP-FPM и HTTPS, включите перенаправление HTTP → HTTPS.
- Для nginx направляйте запросы на `/index.php` по схеме Laravel (`try_files $uri $uri/ /index.php?$query_string;`).
- Для Apache включите `mod_rewrite` и обработку `public/.htaccess`.
- Для `/manifest.webmanifest` желателен MIME `application/manifest+json`; для `/sw.js` — `text/javascript`.
- Не кэшируйте `/sw.js` на длительный срок. Проверьте, что запросы `/storage/models/stl/...` доступны по HTTPS.
- Проверьте ограничения PHP на загрузку STL: `upload_max_filesize` и `post_max_size` (в CMS максимальный файл 20 МБ).

## 4. Проверка PWA и 3D

Откройте по HTTPS: `/`, `/manifest.webmanifest`, `/sw.js`, `/offline.html`, `/pwa-icon.svg`.

В Chrome DevTools → Application проверьте Manifest, Service Workers и Installability. На Android проверьте «Установить приложение»/«Добавить на главный экран». Для широкой совместимости подготовьте также PNG-иконки 192×192 и 512×512; текущая SVG-иконка не гарантирует установку во всех браузерах.

В CMS проверьте загрузку STL, повороты X/Y/Z, масштаб, отсутствие файла (модель по умолчанию), ошибочный URL модели и поведение на мобильном экране. STL не кэшируется сервис-воркером автоматически. Установленная PWA требует подключения для новых страниц и моделей; офлайн-экран показывается при недоступности сети.

## 5. Проверка сайта

```bash
php artisan about
php artisan migrate:status
php artisan route:list
php artisan optimize:clear
php artisan optimize
```

Проверьте публичную главную, навигацию, новости, концерты, медиатеку, динамические страницы, формы и вход в CMS. Не считайте развёртывание завершённым без браузерной проверки. Если возникла ошибка 500, смотрите `storage/logs/laravel.log` и журналы веб-сервера.

## 6. Обновление

Перед каждым обновлением создавайте резервную копию БД, `.env` и `storage/app/public`. Затем:

```bash
cd /var/www/chmuzuch
git fetch origin
git checkout feature/legacy-site-crawler
git pull --ff-only origin feature/legacy-site-crawler
composer install --no-dev --prefer-dist --optimize-autoloader
php artisan migrate --force
npm install
npm run build
php artisan optimize:clear
php artisan optimize
```

В production желательно выполнять обновления в maintenance-окне, с возможностью отката к предыдущему коммиту. При необходимости запуска очередей используйте Supervisor/systemd, а для планировщика Laravel — cron раз в минуту:

```cron
* * * * * cd /var/www/chmuzuch && php artisan schedule:run >> /dev/null 2>&1
```

## Отличия от vdmsh

Здесь используется Laravel 9, а не Laravel 11. Пути Timeweb зависят от тарифа и панели; путь `/var/www/chmuzuch` — пример для VPS, не универсальный путь виртуального хостинга. Настройка администратора, тесты и production-совместимость требуют отдельной проверки перед запуском.
