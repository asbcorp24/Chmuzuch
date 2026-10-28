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

Публичные файлы: `/manifest.webmanifest`, `/sw.js`, `/offline.html`, `/pwa-icon.svg`. PWA работает только через HTTPS (или localhost). Админка, API, STL и загруженные пользовательские файлы исключены из кэширования Service Worker. Текущая версия использует SVG-иконку; для максимальной совместимости Android и iOS перед релизом нужны PNG 192×192, 512×512 и apple-touch-icon. Генератор добавлен: `python3 -m pip install cairosvg && python3 tools/generate_pwa_icons.py`; полученные PNG следует добавить в Git и прописать в manifest/Blade.

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


## Развёртывание на Timeweb

Проект: Laravel 9, PHP 8.1+ (рекомендуется совместимая версия PHP 8.2), MySQL, Node.js 20, Vite и Three.js. Схема развёртывания основана на `asbcorp24/vdmsh`, но команды адаптированы под этот репозиторий.

**Рекомендуется Timeweb VPS/VDS** с SSH, Composer и Node.js. На обычном виртуальном хостинге проверьте доступность SSH, CLI PHP и возможность указать корень сайта `public`. Не направляйте веб-сервер в корень Laravel.

### 1. Подготовка сервера

Установите PHP 8.2 CLI/FPM с расширениями `mbstring`, `openssl`, `pdo_mysql`, `xml`, `ctype`, `fileinfo`, `tokenizer`, `bcmath`; Composer 2; MySQL/MariaDB; Git; Node.js 20+ и npm. В панели Timeweb создайте сайт, базу MySQL и пользователя БД. Включите SSL (Let's Encrypt).

Пример для сервера с SSH (замените путь на реальный путь Timeweb):

```bash
cd /var/www/DOMAIN
git clone --branch feature/legacy-site-crawler https://github.com/asbcorp24/Chmuzuch.git .
composer install --no-dev --prefer-dist --optimize-autoloader
cp .env.example .env
php artisan key:generate
```

Если каталог уже содержит файлы Timeweb, клонируйте репозиторий в пустой каталог приложения, а не поверх системных файлов.

### 2. Настройка .env

```dotenv
APP_NAME="Чебоксарское музыкальное училище"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://DOMAIN
LOG_LEVEL=warning
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=DB_NAME
DB_USERNAME=DB_USER
DB_PASSWORD=DB_PASSWORD
FILESYSTEM_DISK=public
SESSION_DRIVER=file
CACHE_DRIVER=file
```

Никогда не коммитьте рабочий `.env`. Используйте отдельные учётные данные БД и сильные пароли.

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

**Не выполняйте `db:seed` автоматически:** перенос содержимого старого сайта и первоначальное наполнение CMS должны запускаться только после отдельного согласования. Перед публикацией создайте администратора предусмотренным проектом способом и проверьте маршруты авторизации.

Каталоги `storage` и `bootstrap/cache` должны быть доступны на запись PHP-процессу. Не используйте права `777`. Публичный корень сайта должен указывать на `/var/www/DOMAIN/public` (фактический путь зависит от Timeweb).

### 4. PWA и STL

- Для установки PWA нужен рабочий HTTPS, `/manifest.webmanifest`, `/sw.js`, `/offline.html`, `/pwa-icon.svg`.
- После сборки проверьте `/build/manifest.json` и отсутствие ошибок JavaScript.
- STL загружаются в `storage/app/public/models/stl`; `storage:link` делает их доступными по `/storage/models/stl/...`.
- При отсутствии STL отображается стандартная 3D-модель. При недоступном WebGL отображается текстовый резервный символ.
- Для стабильной установки PWA на Android нужны также PNG-иконки 192×192 и 512×512; текущий SVG — базовый вариант.
- Служебные маршруты `/admin`, `/api`, файлы `/storage` и STL не должны кэшироваться Service Worker.

### 5. Обновление и откат

Перед обновлением сделайте резервные копии базы и `storage/app/public`:

```bash
git fetch origin
git checkout feature/legacy-site-crawler
git pull --ff-only origin feature/legacy-site-crawler
composer install --no-dev --prefer-dist --optimize-autoloader
php artisan migrate --force
npm install
npm run build
php artisan optimize:clear
php artisan config:cache
php artisan view:cache
```

Миграции БД не откатывайте вслепую. Для отката сохраните предыдущий Git-коммит, резервную копию БД и загруженных файлов. Ветка `main` не используется до отдельного разрешения.

### 6. Проверка после установки

```bash
php artisan about
php artisan migrate:status
php artisan route:list
php artisan storage:link
```

В браузере проверьте главную страницу и интерактивные разделы, административный вход, загрузку STL, 3D на динамических страницах, концерты, плеер, медиа, мобильное меню и установку PWA. Убедитесь, что `/.env` недоступен извне.

### 7. Очереди и планировщик

Если появятся фоновые задания, настройте Supervisor/systemd для `php artisan queue:work`. Если появятся запланированные задачи, добавьте cron с `php artisan schedule:run` раз в минуту. Для текущего проекта это не обязательные шаги без соответствующих задач.
