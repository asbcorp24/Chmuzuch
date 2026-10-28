# Чебоксарское музыкальное училище — Chmuzuch

Новый сайт и CMS БПОУ «Чебоксарское музыкальное училище им. Ф. П. Павлова». Laravel 9, PHP, MySQL, Vite, Three.js/STL, адаптивный интерфейс и PWA.

Разработка: `feature/legacy-site-crawler`. Не сливать в `main` без отдельного согласования. Старый сайт используется только как справочник структуры: https://xn--g1ajvbu.xn--p1ai/ . Импорт старого контента и сидирование реальными материалами **не выполнять без отдельного разрешения**.

## Развёртывание: по схеме ДШИ Волжска (vdmsh)

Ориентир: https://github.com/asbcorp24/vdmsh . Отличие: здесь **Laravel 9**, а не Laravel 11. Для первого развёртывания рекомендуются Ubuntu + FASTPANEL, PHP 8.2, MySQL 8 / MariaDB 10.6+, Composer 2, Node.js 20 и HTTPS.

Необходимые PHP-расширения: mbstring, openssl, pdo_mysql, tokenizer, xml, ctype, fileinfo, bcmath. Сервер должен иметь доступ к GitHub и реестрам Composer/npm.

### 1. Подготовка сайта

В FASTPANEL создайте сайт, PHP 8.2, БД и пользователя БД. Document root должен быть **каталогом `public`**, например:

```text
/var/www/USER/data/www/DOMAIN/public
```

Не публикуйте корень проекта: `.env`, `storage`, `vendor` не должны быть доступны по HTTP.

### 2. Установка

```bash
cd /var/www/USER/data/www/DOMAIN
git clone --branch feature/legacy-site-crawler https://github.com/asbcorp24/Chmuzuch.git .
composer install --no-dev --optimize-autoloader
cp .env.example .env
php artisan key:generate
```

В `.env` установите:

```dotenv
APP_NAME="Чебоксарское музыкальное училище"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://DOMAIN
LOG_LEVEL=warning
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=chmuzuch
DB_USERNAME=chmuzuch
DB_PASSWORD=CHANGE_ME
SESSION_DRIVER=file
FILESYSTEM_DISK=public
```

Используйте отдельного пользователя БД с минимально необходимыми правами. Не публикуйте пароль или `APP_KEY`.

### 3. Миграции, ресурсы и сборка

```bash
php artisan migrate --force
php artisan storage:link
npm install
npm run build
php artisan optimize
```

**Важно:** в текущей ветке пока отсутствуют `composer.lock` и `package-lock.json`. Поэтому `composer install` без lock-файла может разрешить новые версии зависимостей, а `npm ci` сейчас неприменим. Перед production-релизом сформируйте и зафиксируйте lock-файлы в Git, после этого используйте `npm ci` и `composer install` для воспроизводимых обновлений. Не запускайте `composer update` на работающем сервере.

```bash
chmod -R ug+rwX storage bootstrap/cache
```

Настройте владельца/группу для пользователя PHP-FPM. Не используйте `chmod 777`.

### 4. Администратор и контент

В отличие от vdmsh, у этого проекта пока нет проверенного `DatabaseSeeder` для создания администратора через `ADMIN_EMAIL` / `ADMIN_PASSWORD`. Не рассчитывайте, что `migrate --seed` создаст учётную запись. Перед публикацией требуется отдельная проверенная команда безопасного создания администратора. Не создавайте пользователя вручную с паролем в открытом виде.

CMS: `/admin`; публичный сайт: `/`. После первого входа настройте меню, главную, динамические страницы, медиа и 3D-модели. Для STL нужен `storage:link`, загружаемые файлы находятся в `storage/app/public/models/stl`. Если STL не назначен или не загрузился, показывается стандартная модель.

### 5. PWA

Публичные файлы: `/manifest.webmanifest`, `/sw.js`, `/offline.html`, `/pwa-icon.svg`. PWA работает только через HTTPS (или localhost). Админка, API, STL и загруженные пользовательские файлы исключены из кэширования Service Worker. Текущая версия использует SVG-иконку; для максимальной совместимости Android и iOS перед релизом нужны PNG 192×192, 512×512 и apple-touch-icon.

Проверить в Chrome DevTools → Application → Manifest / Service Workers, затем на Android — «Установить приложение». Проверить обновление приложения, офлайн-страницу, 3D, аудио и мобильное меню.

### 6. Проверка после развёртывания

```bash
php artisan about
php artisan migrate:status
php artisan route:list
php artisan optimize:clear
php artisan optimize
```

Откройте главную, `/admin`, динамические страницы, концерты и PWA-манифест. Убедитесь, что `/storage/...` доступен только для публичных загруженных файлов, HTTPS включён и `APP_DEBUG=false`. Проверяйте `storage/logs/laravel.log` при ошибках. Не считайте проект production-ready без браузерного smoke-тестирования и проверки маршрутов.

### 7. Обновление

Сначала сделайте резервные копии БД, `.env` и `storage/app/public`. Выполняйте обновление в согласованное окно:

```bash
php artisan down
git pull --ff-only
composer install --no-dev --optimize-autoloader
php artisan migrate --force
npm install
npm run build
php artisan optimize:clear
php artisan optimize
php artisan up
```

После добавления lock-файлов замените `npm install` на `npm ci`. Убедитесь, что `php artisan up` выполнен даже при ошибке обновления; при сбое восстановите файлы и БД из резервной копии.

### 8. Фоновые процессы

Если используются очереди, настройте Supervisor/systemd:

```bash
php artisan queue:work --sleep=3 --tries=3 --max-time=3600
```

Для задач по расписанию cron (каждую минуту):

```cron
* * * * * cd /var/www/USER/data/www/DOMAIN && php artisan schedule:run >> /dev/null 2>&1
```

Включайте только если соответствующие задачи действительно используются.

## Перед публикацией

- [ ] Проверить миграции на чистой БД и способ создания первого администратора.
- [ ] Зафиксировать `composer.lock` и `package-lock.json`.
- [ ] Сгенерировать PNG-иконки и проверить PWA на Android/iOS.
- [ ] Проверить все Blade-шаблоны, маршруты, меню, формы и мобильную адаптацию.
- [ ] Проверить загрузку STL, fallback 3D и отсутствие ошибок WebGL.
- [ ] Настроить HTTPS, права каталогов, backup, логи и мониторинг.
- [ ] Не импортировать legacy-контент без отдельного согласования.

См. также `docs/OLD_SITE_CONTENT_MAP.md`.
