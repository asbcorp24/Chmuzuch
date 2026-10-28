# Чебоксарское музыкальное училище — сайт и CMS

Сайт БПОУ «Чебоксарское музыкальное училище им. Ф. П. Павлова». Laravel 9 / PHP 8.1+ / MySQL / Vite / Three.js. В проекте есть конструктор главной, динамические страницы, STL-модели, концерты, медиатека и базовая PWA.

> **Статус:** подготовка к production. Работа на Timeweb ещё не подтверждена тестовым развёртыванием. Ветка разработки: `feature/legacy-site-crawler`. В `main` переносить только после согласования.

## Развёртывание на Timeweb

Рекомендуемый вариант — VPS/VDS Timeweb Cloud с SSH, nginx или Apache, PHP 8.2, MySQL 8 / MariaDB 10.6+, Composer 2 и Node.js 20+. Обычный виртуальный хостинг подходит лишь при наличии CLI, Composer, возможности настроить корень на `public` и собрать фронтенд отдельно. PHP 8.2 предпочтительнее минимально допустимой версии.

По аналогии с проектом [ДШИ Волжска](https://github.com/asbcorp24/vdmsh) приложение размещается **за пределами публичного web-root**, а корень сайта указывает на `public`.

### 1. Подготовить сервер

Создайте сайт, базу данных и пользователя MySQL в Timeweb. Настройте DNS домена на сервер и SSL-сертификат. Установите PHP с расширениями `mbstring`, `openssl`, `pdo_mysql`, `xml`, `ctype`, `fileinfo`, `tokenizer`, `bcmath`; Composer 2, Git и Node.js 20+. Не размещайте `.env`, `storage`, `vendor` в доступном через HTTP каталоге.

### 2. Получить код

```bash
mkdir -p /var/www/chmuzuch
cd /var/www/chmuzuch
git clone https://github.com/asbcorp24/Chmuzuch.git .
git checkout feature/legacy-site-crawler
composer install --no-dev --prefer-dist --optimize-autoloader
cp .env.example .env
php artisan key:generate
```

Задайте в `.env`:

```dotenv
APP_NAME="ЧМУ"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://YOUR-DOMAIN.RU
LOG_CHANNEL=stack
LOG_LEVEL=warning
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=YOUR_DATABASE
DB_USERNAME=YOUR_DB_USER
DB_PASSWORD=YOUR_STRONG_PASSWORD
SESSION_DRIVER=file
CACHE_DRIVER=file
FILESYSTEM_DISK=public
```

**Не коммитьте `.env` с паролями.** Укажите у сайта в панели Timeweb document root `/var/www/chmuzuch/public` (фактический путь может отличаться).

### 3. База, файлы, фронтенд

```bash
php artisan migrate --force
php artisan storage:link
npm install
npm run build
php artisan optimize
php artisan route:list
```

Не запускайте импорт старого сайта и наполнение демонстрационными данными без отдельного решения. Убедитесь, что пользователь PHP имеет права записи в `storage` и `bootstrap/cache`; не ставьте `777`.

### 4. HTTPS, PWA и STL

PWA использует `/manifest.webmanifest`, `/sw.js`, `/offline.html`. Service Worker работает только через HTTPS (кроме localhost). Для STL необходим `storage:link`; разрешите отдачу `.stl` статическим сервером. Проверяйте, что файлы не возвращают 403/404 и что 3D-сцена показывает стандартную фигуру при отсутствии STL.

После включения HTTPS проверьте:
- главную страницу и интерактивное меню разделов;
- вход в CMS, сохранение динамических страниц и загрузку STL;
- публикации, концерты, медиатеку и воспроизведение;
- установку PWA на Android и экран `offline.html`;
- консоль браузера, `storage/logs/laravel.log` и отсутствие ошибок 500.

Иконка PWA пока SVG; для совместимости с некоторыми устройствами нужны PNG 192×192 и 512×512. Офлайн-режим ограничен: не обещается доступ ко всем страницам и медиа без интернета.

### 5. Обновление

Перед обновлением сделайте резервную копию базы и `storage/app/public`.

```bash
cd /var/www/chmuzuch
php artisan down
git fetch origin
git checkout feature/legacy-site-crawler
git pull --ff-only origin feature/legacy-site-crawler
composer install --no-dev --prefer-dist --optimize-autoloader
php artisan migrate --force
npm install
npm run build
php artisan optimize:clear
php artisan optimize
php artisan up
```

Не выполняйте `php artisan key:generate` повторно на действующем сайте: это нарушит работу существующих зашифрованных данных и сессий.

### 6. Фоновые процессы

Если в проекте используются задания Laravel, настройте очередь через systemd/Supervisor; планировщик через cron:

```cron
* * * * * cd /var/www/chmuzuch && /usr/bin/php artisan schedule:run >> /dev/null 2>&1
```

Пути к PHP и проекту уточните на конкретном сервере.

## Архитектура и документация

Источник для анализа структуры старого сайта: https://xn--g1ajvbu.xn--p1ai/. Старый контент не импортируется автоматически. См. `docs/OLD_SITE_CONTENT_MAP.md`.

Сайт и CMS требуют финального тестирования на сервере. Сборка проекта в CI, публикация на Timeweb и проверка реального домена пока не подтверждены.
