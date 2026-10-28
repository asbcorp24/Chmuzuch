# Чебоксарское музыкальное училище — Chmuzuch

Сайт и CMS БПОУ «Чебоксарское музыкальное училище им. Ф. П. Павлова» на Laravel 9, PHP, MySQL, Vite и Three.js. Интерактивная главная, динамические страницы с STL, медиатека, концерты и PWA.

**Развёртывание: виртуальный хостинг Timeweb (не VPS)**. Подход основан на [инструкции ДШИ](https://github.com/asbcorp24/vdmsh), но здесь **Laravel 9** и ветка **`feature/legacy-site-crawler`**. Не копируйте команды для Laravel 11 без проверки.

## Требования

- Тариф Timeweb с PHP **8.2** (Laravel 9 поддерживает PHP >= 8.0.2), MySQL/MariaDB, HTTPS и доступом по SSH; проверьте наличие `pdo_mysql`, `mbstring`, `openssl`, `xml`, `ctype`, `fileinfo`, `tokenizer`.
- Composer 2 на хостинге **или** установка зависимостей локально с совместимой версией PHP.
- Node.js нужен только **для сборки**; на виртуальном хостинге постоянно работающий Node.js не требуется.
- Достаточно дискового пространства для `vendor`, `storage`, загружаемых медиа и STL.

## 1. Создать сайт и базу в панели Timeweb

1. Добавьте домен в панели Timeweb и выпустите SSL-сертификат.
2. Создайте базу MySQL, пользователя и пароль; запишите точные `DB_HOST` и `DB_PORT` из панели.
3. Узнайте **реальный путь к каталогу сайта** и возможность менять корневую папку домена.
4. **Корень сайта должен указывать на `public/`**, а `.env`, `vendor`, `storage` и исходники должны оставаться за пределами веб-корня. Не переносите весь Laravel в публичный каталог.
5. Если в тарифе нельзя направить домен на `public/`, настройте безопасный симлинк веб-корня на `public/` (если Timeweb разрешает) либо обратитесь в поддержку. **Не публикуйте корень проекта и не копируйте `.env` в `public_html`.**

## 2. Получить код

Подключитесь по SSH, перейдите в **непубличный** каталог проекта и выполните:

```bash
git clone --branch feature/legacy-site-crawler https://github.com/asbcorp24/Chmuzuch.git chmuzuch
cd chmuzuch
cp .env.example .env
```

Путь к каталогу зависит от учётной записи Timeweb; не используйте примерный путь как готовый. Если Git/SSH недоступны, подготовьте релиз локально и загрузите его через SFTP, сохранив структуру каталогов.

## 3. Настроить .env

```dotenv
APP_NAME="ЧМУ"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://ВАШ-ДОМЕН
LOG_CHANNEL=stack
LOG_LEVEL=warning
DB_CONNECTION=mysql
DB_HOST=ХОСТ_ИЗ_TIMEWEB
DB_PORT=3306
DB_DATABASE=ИМЯ_БАЗЫ
DB_USERNAME=ПОЛЬЗОВАТЕЛЬ_БД
DB_PASSWORD="СЛОЖНЫЙ_ПАРОЛЬ"
SESSION_DRIVER=file
CACHE_DRIVER=file
FILESYSTEM_DISK=public
```

`APP_KEY` создаётся **один раз**; при обновлениях не генерируйте его повторно. Не коммитьте реальные пароли и `.env` в Git.

## 4. Зависимости и миграции

```bash
composer install --no-dev --prefer-dist --optimize-autoloader
php artisan key:generate
php artisan migrate --force
php artisan storage:link
php artisan optimize
```

**Внимание:** не запускайте `db:seed` автоматически. Импорт старого сайта и тестовые данные требуют отдельного решения. Перед миграциями существующей БД сделайте резервную копию.

Если PHP CLI в SSH отличается от PHP сайта, укажите путь к нужному исполняемому файлу PHP из панели Timeweb. Если `composer` недоступен, устанавливайте зависимости локально на совместимой платформе, затем переносите `vendor`.

## 5. Готовые ассеты — без Node.js на Timeweb

**Node.js, npm и Vite на Timeweb не устанавливать и не запускать.**

В репозитории настроен GitHub Actions workflow `.github/workflows/build-public-assets.yml`. Он собирает проект на GitHub и коммитит сгенерированные файлы **непосредственно в `public/build/` текущей ветки**, включая `manifest.json`. Для запуска вручную: GitHub → Actions → **Build public assets for Timeweb** → Run workflow → выбрать `feature/legacy-site-crawler`.

Перед первым развёртыванием **обязательно убедитесь**, что в нужной ветке есть непустой файл `public/build/manifest.json`. Пока файла нет, сборка не подтверждена и сайт с директивой `@vite` может выдавать ошибку.

На Timeweb достаточно получить обновления Git:

```bash
git checkout feature/legacy-site-crawler
git pull --ff-only
test -s public/build/manifest.json && echo "Vite assets OK"
php artisan optimize:clear
php artisan optimize
```

Если GitHub Actions недоступен из-за квоты или прав записи, нужно один раз собрать проект **на компьютере разработчика** и закоммитить каталог `public/build/` в эту ветку. Копировать на Timeweb только исходники `resources/js` и `resources/css` недостаточно. Не используйте Vite dev server в production.

## 6. Права, файлы и 3D

- PHP должен иметь право записи в `storage/` и `bootstrap/cache/`. Не используйте `chmod 777`.
- `php artisan storage:link` создаёт ссылку `public/storage` → `storage/app/public`. Если симлинки запрещены тарифом, уточните у Timeweb допустимую схему публикации файлов; без неё загруженные изображения и STL не откроются.
- STL хранятся в `storage/app/public/models/stl/`. В CMS можно выбрать STL и повороты X/Y/Z; при отсутствии/ошибке загрузки выводится модель по умолчанию.
- Ограничения `upload_max_filesize` и `post_max_size` PHP должны быть **больше максимального размера STL** (сейчас до 20 МБ) и прочих медиа; проверьте лимиты панели.
- Большие 3D-модели и видео могут замедлять мобильный браузер. Используйте оптимизированные файлы.

## 7. PWA

Сайт содержит `public/manifest.webmanifest`, `public/sw.js`, `public/offline.html`, `public/pwa-icon.svg`. Установка требует HTTPS. Service Worker не должен кэшировать админку и приватные данные. Для широкой совместимости Android добавьте PNG-иконки **192×192 и 512×512** и проверьте установку на реальном устройстве; один SVG не гарантирует поддержку во всех браузерах.

Проверка:
- `https://ВАШ-ДОМЕН/manifest.webmanifest` → JSON;
- `https://ВАШ-ДОМЕН/sw.js` → JavaScript;
- `https://ВАШ-ДОМЕН/offline.html` → страница без сети;
- Chrome DevTools → Application → Manifest / Service Workers;
- главная, раскрытие разделов, 3D STL, установка на Android и офлайн-экран.

## 8. Проверка после запуска

```bash
php artisan about
php artisan migrate:status
php artisan route:list
php artisan optimize:clear
php artisan optimize
```

Откройте главную, `/admin/login`, новости, концерты, динамические страницы, медиа. Проверьте запись в `storage/logs/laravel.log` при ошибках. Администратора создавайте по фактическому механизму авторизации проекта; **не предполагается**, что сидер автоматически создаёт учётную запись.

## 9. Обновление

Перед обновлением сохраните дамп БД, `.env` и `storage/app/public`. Затем:

```bash
git pull --ff-only
composer install --no-dev --prefer-dist --optimize-autoloader
php artisan migrate --force
php artisan optimize:clear
php artisan optimize
```

Дождитесь GitHub Actions и проверьте, что новая сборка закоммичена в `public/build/` **до** `git pull` на Timeweb. Проверьте кэш PWA и обновление Service Worker. Для отката кода используйте проверенный предыдущий релиз; миграции БД не всегда обратимы.

## 10. Cron и очереди

Если нужны плановые задачи, создайте в панели Timeweb cron раз в минуту (если тариф допускает):

```cron
* * * * * cd /ПОЛНЫЙ/ПУТЬ/К/chmuzuch && /ПУТЬ/К/php artisan schedule:run >/dev/null 2>&1
```

Постоянный `queue:work` на обычном виртуальном хостинге обычно не подходит. Если очереди действительно используются, согласуйте подходящий cron-режим либо отдельный сервер.

## Статус

Инструкция подготовлена для Timeweb, но реальный деплой **не проводился**: необходимо проверить ограничения тарифа, PHP CLI, веб-корень, права и PWA на домене. Разработка ведётся в `feature/legacy-site-crawler`; перенос в `main` только после отдельного подтверждения. Старый сайт — источник структуры и контента для будущей миграции, не повод автоматически импортировать данные.
