# Чебоксарское музыкальное училище — Chmuzuch

Laravel 9 / PHP 8.2 / MySQL / Vite / Three.js / PWA. Репозиторий: https://github.com/asbcorp24/Chmuzuch

## Развёртывание на Timeweb

Подход аналогичен проекту [ДШИ Волжска](https://github.com/asbcorp24/vdmsh), но этот проект использует **Laravel 9**. Для PHP 8.2 подходит; переход на Laravel 11 не выполнен.

### 1. Требования

- Timeweb VPS или хостинг с SSH, PHP CLI 8.2, Composer 2, MySQL/MariaDB, cron и возможностью установить корень сайта на `public/`.
- PHP: mbstring, openssl, pdo_mysql, tokenizer, xml, ctype, fileinfo, json, curl, gd (для обработки изображений).
- Node.js 18+ (желательно 20 LTS) для сборки Vite. Если на хостинге Node недоступен, соберите `public/build` локально и загрузите его на сервер.
- Домен и SSL-сертификат: для PWA необходим HTTPS.

### 2. Код и окружение

В SSH перейдите в **каталог проекта, расположенный выше публичного корня** (путь зависит от панели Timeweb):

```bash
git clone --branch feature/legacy-site-crawler https://github.com/asbcorp24/Chmuzuch.git chmuzuch
cd chmuzuch
composer install --no-dev --optimize-autoloader
cp .env.example .env
php artisan key:generate
```

Создайте пустую базу и пользователя MySQL в панели Timeweb. В `.env` укажите:

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
DB_DATABASE=ИМЯ_БАЗЫ
DB_USERNAME=ПОЛЬЗОВАТЕЛЬ_БАЗЫ
DB_PASSWORD=СЛОЖНЫЙ_ПАРОЛЬ
SESSION_DRIVER=file
CACHE_DRIVER=file
FILESYSTEM_DISK=public
```

Не публикуйте `.env` и не добавляйте его в Git. Убедитесь, что `APP_KEY` установлен. **Не запускайте seeders с импортом старого контента** без отдельного решения.

### 3. База, файлы и фронтенд

```bash
php artisan migrate --force
php artisan storage:link
npm install
npm run build
php artisan optimize:clear
php artisan config:cache
php artisan view:cache
```

Для `route:cache` предварительно убедитесь, что маршруты не содержат Closure. Команду `php artisan optimize` применяйте только после проверки совместимости.

Загруженные STL, фото, аудио и видео хранятся в `storage/app/public` и доступны через символическую ссылку `public/storage`. Для больших медиа настройте лимиты PHP `upload_max_filesize` и `post_max_size`, а также ограничения веб-сервера.

### 4. Настройка сайта в Timeweb

В настройках домена установите **Document Root** на полный путь к `chmuzuch/public`. Не используйте корень репозитория и не переносите `.env` в `public`.

Включите HTTPS, перенаправление HTTP → HTTPS и PHP 8.2. Права записи должны быть у PHP-пользователя для `storage` и `bootstrap/cache`:

```bash
chmod -R ug+rwX storage bootstrap/cache
```

Если PHP работает от другого пользователя, настройте владельца и группу через панель или администратора VPS. **Не устанавливайте 777**.

### 5. PWA

В репозитории находятся `public/manifest.webmanifest`, `public/sw.js`, `public/offline.html`, `public/pwa-icon.svg`. После включения HTTPS проверьте в Chrome DevTools → Application:

- Manifest загружается без 404;
- Service Worker зарегистрирован и контролирует публичную страницу;
- офлайн-страница отображается без сети;
- обновление версии сайта не оставляет устаревшие JS/CSS;
- установка на Android доступна.

Для широкой совместимости добавьте растровые PNG-иконки 192×192 и 512×512. Сейчас SVG-иконка уже присутствует, но установку на устройствах необходимо тестировать.

### 6. Планировщик и очереди

При использовании планировщика добавьте в cron Timeweb (укажите **свой абсолютный путь**):

```cron
* * * * * cd /ПУТЬ/К/chmuzuch && /usr/bin/php artisan schedule:run >> /dev/null 2>&1
```

Если приложение использует фоновые задания, запускайте `php artisan queue:work` через Supervisor/systemd на VPS. На обычном хостинге сначала проверьте доступные способы запуска.

### 7. Проверка

```bash
php artisan about
php artisan migrate:status
php artisan route:list
php artisan storage:link
ls -la public/build public/storage
```

В браузере проверьте главную, разделы, новости, концерты, медиатеку, административную авторизацию, загрузку STL, 3D и установку PWA. Маршрут входа администратора уточните по `php artisan route:list`; не предполагается, что он совпадает с проектом vdmsh.

### 8. Обновление без потери данных

Перед обновлением создайте резервную копию базы и `storage/app/public`. Затем:

```bash
git pull --ff-only
composer install --no-dev --optimize-autoloader
php artisan migrate --force
npm install
npm run build
php artisan optimize:clear
php artisan config:cache
php artisan view:cache
```

На production лучше использовать зафиксированные версии зависимостей и `npm ci`, когда в репозитории появится актуальный `package-lock.json`. Не удаляйте `storage`, `.env` и пользовательские файлы при обновлении.

### 9. Ветки

Рабочая ветка: `feature/legacy-site-crawler`. Перенос в `main` — только после отдельного подтверждения.

## Архитектура и миграция контента

Оригинальный сайт используется как справочник структуры и контента: https://xn--g1ajvbu.xn--p1ai/ . Импорт старого контента не выполняется автоматически. См. `docs/OLD_SITE_CONTENT_MAP.md`.
