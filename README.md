# Чебоксарское музыкальное училище — CMS и PWA

Laravel 9, PHP 8.0.2+ (рекомендуется PHP 8.2), MySQL, Vite/Three.js. Публичные страницы, CMS, интерактивная главная, STL-модели, концерты, PWA.

## Развёртывание на Timeweb (без Node.js на сервере)

Принцип как в проекте [vdmsh](https://github.com/asbcorp24/vdmsh): PHP-приложение размещается вне публичного каталога, а корень сайта указывает на `public`. **На Timeweb не устанавливаются Node.js и npm**. Скомпилированные файлы должны уже находиться в `public/build` вместе с `manifest.json`. Если их нет, сайт не сможет корректно загрузить Vite-стили и JavaScript.

### Требования

- PHP 8.2 с расширениями openssl, mbstring, pdo_mysql, tokenizer, xml, ctype, fileinfo
- MySQL 8 / MariaDB, Composer 2 (если Composer отсутствует на хостинге, переносить готовый каталог `vendor` из совместимой среды)
- SSH/доступ к запуску Artisan, HTTPS
- Возможность установить document root на `.../public` (для обычного виртуального хостинга Timeweb проверьте доступность этой настройки до переноса)

### 1. Подготовить базу и код

Создайте на Timeweb сайт и пустую MySQL-базу, запишите имя БД, пользователя и пароль. В каталоге проекта:

```bash
git clone --branch feature/legacy-site-crawler https://github.com/asbcorp24/Chmuzuch.git .
composer install --no-dev --optimize-autoloader
cp .env.example .env
php artisan key:generate
```

В `.env`:

```dotenv
APP_NAME="ЧМУ"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://ВАШ-ДОМЕН
DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=ИМЯ_БД
DB_USERNAME=ПОЛЬЗОВАТЕЛЬ
DB_PASSWORD=ПАРОЛЬ
FILESYSTEM_DISK=public
SESSION_DRIVER=file
CACHE_DRIVER=file
```

**Не коммитьте `.env` и реальные пароли.** Настройте корень домена на абсолютный путь к `public`. Не размещайте `.env`, `vendor`, `storage` в общедоступной директории.

### 2. Установка

```bash
php artisan migrate --force
php artisan storage:link
php artisan config:cache
php artisan view:cache
php artisan route:cache
```

Проверьте права на запись для `storage` и `bootstrap/cache` (без `777`).

### 3. Ассеты без Node на Timeweb

На ветке разработки добавлен workflow `.github/workflows/build-public-assets.yml`: он собирает Vite на GitHub Actions и коммитит результат в `public/build`. Проверьте, что GitHub Actions разрешено писать в репозиторий (Workflow permissions → Read and write) и что лимит Actions не исчерпан. **Workflow не означает, что файлы уже собраны:** убедитесь, что в нужном коммите присутствуют `public/build/manifest.json` и файлы из `public/build/assets/`.

Если Actions недоступен, соберите один раз на локальном ПК разработчика (не на Timeweb):

```bash
npm install
npm run build
git add -f public/build
git commit -m "build: commit production assets"
git push
```

На Timeweb после этого достаточно `git pull`; `npm` там не запускается.

### 4. PWA и 3D

PWA-файлы находятся в `public/manifest.webmanifest`, `public/sw.js`, `public/offline.html`, `public/pwa-icon.svg`. Для установки PWA нужен HTTPS. Проверьте иконки, установку Android, офлайн-страницу и обновление кэша. Для максимальной совместимости подготовьте также PNG-иконки 192 и 512 пикселей.

STL загружаются в `storage/app/public/models/stl` и доступны через `public/storage` после `storage:link`. Если STL не указан или не загружается, используется стандартная 3D-фигура. Проверьте повороты и масштаб в CMS.

### 5. Проверка после запуска

```bash
php artisan about
php artisan migrate:status
php artisan route:list
test -f public/build/manifest.json && echo "Vite assets OK"
```

Проверьте главную, мобильное меню, редактор CMS, загрузку медиа/STL, концерты, PWA, а также отсутствие ошибок 404/500 в консоли браузера. Отдельно проверьте URL `/manifest.webmanifest` и `/sw.js`.

### 6. Обновление

Сначала сделайте резервную копию БД, `.env` и `storage/app/public`. Затем:

```bash
git pull
composer install --no-dev --optimize-autoloader
php artisan migrate --force
php artisan optimize:clear
php artisan config:cache
php artisan view:cache
php artisan route:cache
```

Никаких `npm ci` / `npm run build` на Timeweb.

## Ветки и публикация

Рабочая ветка: `feature/legacy-site-crawler`. **В `main` не сливать без явного подтверждения.** До production-публикации проверить сборку, миграции и PWA на тестовом домене. Старый сайт — источник структуры, а не источник автоматической загрузки данных.
