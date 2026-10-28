# Чебоксарское музыкальное училище — Chmuzuch

Laravel 9 / PHP 8.1+ / MySQL / Vite / Three.js. Развёртывание по схеме проекта [vdmsh](https://github.com/asbcorp24/vdmsh), адаптированной для **Timeweb**. Разработка ведётся в ветке `feature/legacy-site-crawler`; в `main` изменения переносятся только после согласования.

## Требования

- Хостинг Timeweb с PHP **8.1 или 8.2** и поддержкой Composer/SSH; PHP 8.0 не рекомендуется. Для Laravel 9 обязательно PHP >=8.0.2.
- Расширения PHP: mbstring, openssl, pdo_mysql, tokenizer, xml, ctype, fileinfo, curl, gd.
- MySQL / MariaDB; Composer 2; Node.js и npm для сборки (можно собирать локально).
- HTTPS для PWA и service worker; домен с корректным SSL.
- Корень веб-сайта **должен указывать на `public/`**, а не на корень Laravel.

## 1. Подготовка Timeweb

Создайте сайт/домен и базу MySQL в панели Timeweb. Установите подходящую версию PHP, включите HTTPS и SSH. Запишите имя БД, пользователя, пароль, адрес сервера БД и фактический путь к каталогу проекта.

**Важно:** если тариф не позволяет установить document root на `.../public`, используйте VPS/Cloud Server Timeweb или настройку веб-сервера с нужным корнем. **Не переносите `.env`, `vendor` и `app` в публичный каталог.**

## 2. Загрузка исходников

По SSH перейдите в **непубличную** папку проекта (путь зависит от вашего аккаунта Timeweb):

```bash
cd /home/USER/PROJECT
git clone --branch feature/legacy-site-crawler https://github.com/asbcorp24/Chmuzuch.git .
composer install --no-dev --prefer-dist --optimize-autoloader
cp .env.example .env
php artisan key:generate
```

При закрытом репозитории потребуется GitHub-токен или SSH-ключ с доступом. Если нет SSH или Composer на тарифе, собирайте проект локально и загружайте через SFTP, сохраняя структуру и не публикуя приватные каталоги.

## 3. Настройка окружения

В `.env`:

```dotenv
APP_NAME="Чебоксарское музыкальное училище"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://YOUR-DOMAIN.RU
LOG_CHANNEL=stack
LOG_LEVEL=warning

DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=YOUR_DATABASE
DB_USERNAME=YOUR_DB_USER
DB_PASSWORD=YOUR_STRONG_PASSWORD

SESSION_DRIVER=file
CACHE_DRIVER=file
FILESYSTEM_DISK=public
```

Используйте **реальные** реквизиты БД из панели Timeweb. Никогда не коммитьте `.env`. Проверьте права на запись для `storage/` и `bootstrap/cache/`; не назначайте `777`.

## 4. База, медиа, сборка

```bash
php artisan migrate --force
php artisan storage:link
npm install
npm run build
php artisan optimize
```

**Не запускайте `db:seed` автоматически:** в этом проекте запрещён импорт старого контента до отдельного согласования. Убедитесь, что в `public/build` есть собранные CSS/JS и `manifest.json`. Если Node.js отсутствует на сервере, выполните `npm install && npm run build` локально и загрузите `public/build/`.

Для STL, фотографий и прочих медиа используется диск `public`: `storage/app/public` и символьная ссылка `public/storage`. На Timeweb проверьте разрешение на symlink. Если оно запрещено, нужен иной безопасный способ выдачи медиа через веб-сервер.

## 5. PWA

PWA-файлы в `public/`: `manifest.webmanifest`, `sw.js`, `offline.html`, `pwa-icon.svg`. HTTPS обязателен (кроме localhost). После публикации проверьте:

- `https://YOUR-DOMAIN.RU/manifest.webmanifest` — код 200 и JSON.
- `https://YOUR-DOMAIN.RU/sw.js` — код 200, JavaScript, без редиректа на HTML.
- `https://YOUR-DOMAIN.RU/offline.html` — код 200.
- DevTools → Application → Manifest и Service Workers; установка на Android.
- 3D на главной и динамических страницах, STL, возврат к стандартной модели, работа после обновления.
- Для максимально широкой поддержки установки **ещё требуются PNG-иконки 192×192 и 512×512**. SVG-иконка уже предусмотрена.

Service worker намеренно не кэширует административные страницы, API, `/storage/` и STL. Полноценный офлайн-доступ ко всему сайту не обещается.

## 6. Проверка после установки

```bash
php artisan about
php artisan migrate:status
php artisan route:list
php artisan config:clear
```

Проверьте главную, разделы CMS, формы, афишу, концерты, медиатеку, вход администратора, загрузку медиа и настройки STL. **Администратора создавайте через предусмотренный проектом механизм**, не полагайтесь на сидеры из другого репозитория. Пока наличие штатного production bootstrap администратора отдельно не подтверждено.

## 7. Обновление без потери данных

Перед обновлением сделайте резервную копию базы данных и `storage/app/public`. Затем:

```bash
git fetch origin
git checkout feature/legacy-site-crawler
git pull --ff-only origin feature/legacy-site-crawler
composer install --no-dev --prefer-dist --optimize-autoloader
php artisan migrate --force
npm install
npm run build
php artisan optimize
```

При обновлении не перезаписывайте рабочий `.env`. После выпуска обновления PWA убедитесь, что старый Service Worker не удерживает устаревшие ресурсы.

## 8. Диагностика

- **500**: смотрите `storage/logs/laravel.log`, права, APP_KEY, подключение к БД.
- **404 на страницах Laravel**: неверный document root или rewrite; используйте `public/`.
- **Vite manifest not found**: отсутствует `public/build/manifest.json`, запустите сборку.
- **Не видны STL и изображения**: проверьте `public/storage`, права, URL файла и доступность `/storage/models/stl/...`.
- **PWA не устанавливается**: HTTPS, manifest, service worker, иконки, ошибки консоли.
- **После деплоя старый интерфейс**: `php artisan optimize:clear`, пересборка Vite и обновление service worker.

## Дополнительно

Для Timeweb VPS/Cloud Server можно настроить cron `* * * * * cd /path/to/project && php artisan schedule:run >/dev/null 2>&1`, если используются запланированные задания. Очереди включайте только при реальном использовании и с отдельным worker-процессом.

Документация по исходной структуре: `docs/OLD_SITE_CONTENT_MAP.md`. Старый сайт — ориентир по содержанию, **не шаблон дизайна**.


## Timeweb: сборка фронтенда Vite после развёртывания

Проект использует Laravel 9, Vite 4 и Three.js. На Timeweb выполняйте команды **в корне Laravel**, где расположены `package.json` и `vite.config.js`:

```bash
node -v
npm -v
npm install
npm run build
test -f public/build/manifest.json && echo "Vite build OK"
php artisan optimize:clear
```

Рекомендуется Node.js 18 или 20. Если в репозитории есть `package-lock.json`, для воспроизводимой сборки используйте `npm ci` вместо `npm install`.

**Веб-корень домена:** каталог `public`, не корень проекта. Vite создаёт `public/build/manifest.json` и `public/build/assets/`. Не путайте `public/manifest.webmanifest` (PWA) с `public/build/manifest.json` (Vite). Файл `public/hot` от локального dev-сервера на production должен отсутствовать.

Если Timeweb не позволяет запускать Node.js, выполните `npm install && npm run build` на компьютере с Node.js 20, затем загрузите **весь** каталог `public/build` в соответствующий каталог сервера. После обновления сборки выполните `php artisan optimize:clear`.

Для пользовательских STL и медиа требуется `php artisan storage:link`. Для PWA необходим HTTPS. Проверяйте в браузере главную, 3D-модели, динамические страницы, музыку, меню и установку приложения. Не включайте `APP_DEBUG=true` на production.

**Важно:** команды выше являются инструкцией; сборка непосредственно на сервере Timeweb не запускается из GitHub и должна быть выполнена в SSH или через локальную сборку.

## Развёртывание на Timeweb без Node.js

Проект использует Laravel 9 (PHP 8.0.2+ по composer.json; рекомендуется совместимый PHP 8.2), MySQL и Vite. Схема аналогична vdmsh, но сборка JavaScript/CSS происходит **в GitHub Actions**, не на Timeweb. Ветка разработки: `feature/legacy-site-crawler`; в `main` не сливать без согласования.

### 1. Сборка фронтенда в GitHub

Откройте **Actions → Build Timeweb release → Run workflow**, выберите `feature/legacy-site-crawler`. После успешного выполнения скачайте артефакт `timeweb-public-build`, извлеките из него `timeweb-public-build.tar.gz`. В архиве находится каталог `build/`, который необходимо распаковать **в `public/`** на сервере, чтобы появился `public/build/manifest.json`.

Workflow запускает Node.js 20, устанавливает npm-зависимости и выполняет `npm run build`. Он не публикует скомпилированные файлы в git, чтобы не раздувать историю. Если GitHub Actions не запускается из-за квоты или ограничений, скачайте исходники и выполните сборку на другом компьютере с Node.js 20, затем загрузите `public/build` на Timeweb.

### 2. Хостинг

Нужен тариф Timeweb с PHP, MySQL, Composer/SSH (либо возможность загрузить готовый каталог `vendor`). Укажите **корень сайта на `public/`**, а не на корень репозитория. Не размещайте `.env` в публичной директории.

На сервере:
```bash
git clone -b feature/legacy-site-crawler https://github.com/asbcorp24/Chmuzuch.git chmuzuch
cd chmuzuch
composer install --no-dev --optimize-autoloader
cp .env.example .env
php artisan key:generate
```

Укажите в `.env`:
```dotenv
APP_ENV=production
APP_DEBUG=false
APP_URL=https://ВАШ-ДОМЕН
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=ИМЯ_БАЗЫ
DB_USERNAME=ПОЛЬЗОВАТЕЛЬ
DB_PASSWORD=ПАРОЛЬ
FILESYSTEM_DISK=public
```

Далее после настройки базы:
```bash
php artisan migrate --force
php artisan storage:link
php artisan optimize:clear
php artisan config:cache
php artisan view:cache
```

**Важно:** не выполнять `migrate --seed` без проверки сидеров — старый контент пока не переносим. Не использовать `APP_DEBUG=true` на рабочем сайте. Права на запись необходимы для `storage/` и `bootstrap/cache/`; не устанавливайте 777.

### 3. Загрузка готовой сборки

Загрузите содержимое `public/build` из артефакта GitHub в `<корень проекта>/public/build`. Проверьте наличие `public/build/manifest.json` и файлов CSS/JS в `public/build/assets`. На Timeweb **не выполнять** `npm install` или `npm run build`.

### 4. PWA и STL

PWA работает по HTTPS. Проверьте доступность `/manifest.webmanifest`, `/sw.js`, `/offline.html`, `/pwa-icon.svg`. В админке загрузите тестовый STL и проверьте отображение на главной и динамических страницах. Для пользовательских STL и изображений обязателен рабочий `public/storage` → `storage/app/public`.

### 5. Обновление

Перед обновлением сделайте резервную копию БД, `.env` и `storage/app/public`. Затем:
```bash
git pull --ff-only
composer install --no-dev --optimize-autoloader
php artisan migrate --force
php artisan optimize:clear
php artisan config:cache
php artisan view:cache
```
Скачайте новый `timeweb-public-build` из GitHub Actions и замените `public/build` целиком. Для пользователей PWA может потребоваться обновление страницы/Service Worker.

### 6. Контроль после установки

```bash
php artisan about
php artisan migrate:status
php artisan route:list
test -s public/build/manifest.json && echo "Vite assets OK"
```
Откройте главную, несколько внутренних страниц, концерты, административный вход, проверьте ссылки и адаптивность. В браузере убедитесь, что нет ошибок загрузки CSS/JS, STL и Service Worker. **Успешный workflow не означает, что сайт уже протестирован на Timeweb.**
