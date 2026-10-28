# Чебоксарское музыкальное училище — Chmuzuch

Laravel 9 / PHP 8.1–8.2 / MySQL / Vite 4 / Three.js. Сайт и CMS с интерактивной главной страницей, концертами, медиатекой, PWA и настраиваемыми STL-сценами.

**Разработка:** `feature/legacy-site-crawler`. Не переключайтесь на `main` при развертывании текущей версии без отдельного решения. Исходный сайт — ориентир по структуре; автоматический импорт старого контента не выполняется.

## Развертывание на Timeweb

Ниже процедура для **Timeweb Cloud VPS / виртуального сервера** с SSH и возможностью настроить nginx или Apache. Для обычного виртуального хостинга Timeweb заранее проверьте возможность выбрать PHP 8.1/8.2, запустить Composer/Artisan и настроить корень сайта на `public`. На хостинге без SSH сборку Vite выполните локально и загрузите каталог `public/build`.

### 1. Подготовка

- Домен с A/AAAA-записью на сервер; HTTPS-сертификат (Let's Encrypt).
- PHP 8.1 или 8.2 с расширениями: `mbstring`, `openssl`, `pdo_mysql`, `xml`, `ctype`, `fileinfo`, `tokenizer`, `bcmath`.
- MySQL 8 / MariaDB 10.6+, Composer 2, Git; Node.js 20 и npm для сборки на сервере.
- Document root **обязательно** `/var/www/ДОМЕН/public` (или фактический путь Timeweb до `public`). Не публикуйте корень проекта: там находится `.env`.

### 2. Код и зависимости

```bash
cd /var/www
git clone --branch feature/legacy-site-crawler https://github.com/asbcorp24/Chmuzuch.git chmuzuch
cd chmuzuch
composer install --no-dev --optimize-autoloader
cp .env.example .env
php artisan key:generate
```

Если GitHub недоступен на сервере, загрузите архив **этой ветки**, распакуйте в каталог приложения, затем выполните Composer-команды.

### 3. База и .env

Создайте **пустую** БД и пользователя с правами на неё. В `.env` установите:

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
DB_DATABASE=chmuzuch
DB_USERNAME=chmuzuch_user
DB_PASSWORD=ЗАМЕНИТЕ_НА_СЕКРЕТ
SESSION_DRIVER=file
CACHE_DRIVER=file
FILESYSTEM_DISK=public
```

Не публикуйте `.env` и не сохраняйте реальные пароли в Git. Если пароль содержит специальные символы, заключите значение в двойные кавычки.

### 4. Миграции, медиа и фронтенд

```bash
php artisan migrate --force
php artisan storage:link
npm install
npm run build
php artisan optimize:clear
php artisan config:cache
php artisan view:cache
```

**Не запускайте `migrate:fresh` на работающем сайте.** Не выполняйте `db:seed` без предварительной проверки сидеров: проект не должен автоматически заполняться контентом старого сайта. Права на запись нужны для `storage` и `bootstrap/cache` пользователю PHP-FPM; не применяйте `chmod 777`.

Медиа и STL сохраняются в `storage/app/public`; URL `/storage/...` работает после `storage:link`. Для STL увеличьте при необходимости `upload_max_filesize` и `post_max_size` в PHP (текущий лимит формы STL — 20 МБ). Для больших видео настройте лимиты отдельно.

### 5. Настройка сайта в Timeweb

1. Создайте сайт/виртуальный хост с доменом.
2. Укажите корневую папку сайта: `/var/www/chmuzuch/public` (замените на ваш фактический путь).
3. Выберите PHP 8.1 или 8.2, настройте PHP-FPM.
4. Подключите SSL и перенаправление HTTP → HTTPS.
5. В nginx настройте `try_files $uri $uri/ /index.php?$query_string;`; в Apache включите `mod_rewrite` и разрешите правила `public/.htaccess`.
6. Убедитесь, что `/manifest.webmanifest`, `/sw.js`, `/offline.html` и `/pwa-icon.svg` открываются без авторизации.

### 6. Администратор

В текущей ветке не подтверждён автоматический сидер первого администратора. **Не используйте инструкции из vdmsh с `ADMIN_EMAIL`/`ADMIN_PASSWORD` как готовую функциональность этого проекта.** Перед запуском проверьте миграцию таблицы `users` и создание пользователя с ролью `super_admin` и `is_active=1`; пароль хранится только как Laravel Hash. Вход: `/admin/login`.

### 7. PWA и 3D

PWA требует HTTPS (кроме localhost). Установочные метаданные: `public/manifest.webmanifest`, Service Worker: `public/sw.js`. Офлайн-страница доступна по `/offline.html`. Админка, API и STL исключены из офлайн-кэширования: для просмотра 3D-файлов нужен интернет. SVG-иконка присутствует; для максимальной совместимости Android/iOS дополнительно подготовьте PNG 192/512 и Apple Touch Icon.

3D на главной настраивается в конструкторе главной, на динамических страницах — в редакторе страницы: STL, поворот X/Y/Z, масштаб. Если STL отсутствует или не загружается, отображается стандартная 3D-фигура. Перед публикацией проверьте загрузку модели, работу WebGL и мобильную производительность.

### 8. Проверка после запуска

```bash
php artisan about
php artisan migrate:status
php artisan route:list
php artisan storage:link
curl -I https://ВАШ-ДОМЕН/
curl -I https://ВАШ-ДОМЕН/manifest.webmanifest
curl -I https://ВАШ-ДОМЕН/sw.js
```

Проверьте вручную: главную и интерактивное меню, динамические страницы, 3D с STL и без STL, медиа, концерты, `/admin/login`, сохранение материалов, установку PWA в Chrome Android, офлайн-экран. Проверьте консоль браузера и `storage/logs/laravel.log`. Наличие файлов PWA **не означает**, что установка уже протестирована на устройствах.

### 9. Обновление и откат

Перед обновлением создайте резервную копию **БД**, `.env`, `storage/app/public`, а также запишите текущий SHA коммита.

```bash
git fetch origin
git checkout feature/legacy-site-crawler
git pull --ff-only origin feature/legacy-site-crawler
composer install --no-dev --optimize-autoloader
php artisan migrate --force
npm install
npm run build
php artisan optimize:clear
php artisan config:cache
php artisan view:cache
```

При проблеме откатите код на записанный SHA и восстановите БД из резервной копии, если миграции изменили схему. Простое `git checkout` не отменяет миграции. Для обновления Service Worker меняйте значение `VERSION` в `public/sw.js` и проверяйте отсутствие устаревших ресурсов.

### 10. Планировщик и очереди (если понадобятся)

Cron раз в минуту (путь скорректируйте):

```cron
* * * * * cd /var/www/chmuzuch && php artisan schedule:run >> /dev/null 2>&1
```

Если используются очереди, настройте Supervisor/systemd для `php artisan queue:work`; на обычном виртуальном хостинге это может быть недоступно.

## Различия с проектом vdmsh

Схема установки взята за основу из `asbcorp24/vdmsh`: Git → Composer → .env → миграции → storage:link → Vite → кеши → HTTPS. **Но** vdmsh использует Laravel 11, PHP 8.2+ и ветку `develop`, а Chmuzuch сейчас использует Laravel 9 и ветку `feature/legacy-site-crawler`. Не копируйте слепо сидеры и команды создания администратора из vdmsh.

## Документация

См. `docs/OLD_SITE_CONTENT_MAP.md` — карта структуры исходного сайта.
