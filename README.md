# Чебоксарское музыкальное училище — Chmuzuch

Сайт училища на Laravel 9, PHP 8.2, MySQL, Vite, Three.js. Публичный сайт, CMS, медиатека, концерты, интерактивные STL-сцены и PWA.

Разработка: `feature/legacy-site-crawler`. Не сливать в `main` без подтверждения. Старый сайт используется как ориентир по структуре; импорт старого контента отдельно согласуется.

## Развёртывание на Timeweb

Инструкция рассчитана на **Timeweb VPS/VDS с SSH и возможностью настроить document root**, по принципу проекта [vdmsh](https://github.com/asbcorp24/vdmsh). На обычном виртуальном хостинге доступность SSH, Composer, Node.js, cron и смены корня сайта зависит от тарифа. Если этих функций нет — используйте VPS.

### 1. Подготовка сервера

- Ubuntu 22.04/24.04, nginx + PHP-FPM **8.2** (Laravel 9 требует PHP >=8.0.2), MySQL 8 / MariaDB.
- PHP-расширения: `mbstring xml curl zip gd fileinfo openssl pdo_mysql bcmath tokenizer ctype`.
- Composer 2, Git, Node.js 20 LTS + npm (для сборки Vite).
- Домен с A/AAAA-записью на IP сервера; выпустить SSL Let's Encrypt.
- Корень веб-сайта должен быть **`/var/www/chmuzuch/public`**, не каталог проекта.

Пример команд для Ubuntu (пакеты и PHP-FPM уточните под установленную ОС):

```bash
sudo apt update
sudo apt install -y nginx mysql-server git unzip curl composer php8.2-fpm php8.2-cli php8.2-mysql php8.2-mbstring php8.2-xml php8.2-curl php8.2-zip php8.2-gd php8.2-bcmath
sudo mkdir -p /var/www/chmuzuch
sudo chown -R "$USER":www-data /var/www/chmuzuch
cd /var/www/chmuzuch
git clone --branch feature/legacy-site-crawler https://github.com/asbcorp24/Chmuzuch.git .
composer install --no-dev --prefer-dist --optimize-autoloader
cp .env.example .env
php artisan key:generate
```

Установите Node.js 20 LTS из доверенного репозитория или nvm перед `npm install`. Не запускайте `npm ci`, пока в репозитории нет `package-lock.json`.

### 2. База данных и .env

Создайте отдельную БД и пользователя MySQL (не используйте root в приложении):

```sql
CREATE DATABASE chmuzuch CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER 'chmuzuch'@'localhost' IDENTIFIED BY 'REPLACE_WITH_STRONG_PASSWORD';
GRANT ALL PRIVILEGES ON chmuzuch.* TO 'chmuzuch'@'localhost';
```

Заполните `.env` на сервере:

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
DB_USERNAME=chmuzuch
DB_PASSWORD=ЗАМЕНИТЬ_НА_СЕКРЕТ
SESSION_DRIVER=file
CACHE_DRIVER=file
FILESYSTEM_DISK=public
```

Не коммитьте `.env` в Git и не раскрывайте `APP_KEY`.

### 3. Первоначальная установка

```bash
cd /var/www/chmuzuch
php artisan migrate --force
php artisan storage:link
npm install
npm run build
php artisan optimize:clear
php artisan config:cache
php artisan view:cache
chmod -R ug+rwX storage bootstrap/cache
```

**Важно:** в этом репозитории пока нет подтверждённого штатного сидера администратора. Не запускайте `migrate --seed` без проверки сидеров. Создание первой учётной записи администратора следует реализовать отдельной защищённой командой/сидером; не регистрируйте открытый публичный маршрут создания администратора.

### 4. Nginx

Пример server-блока (путь PHP-FPM и домен замените):

```nginx
server {
    listen 80;
    server_name ВАШ-ДОМЕН;
    root /var/www/chmuzuch/public;
    index index.php;
    client_max_body_size 64M;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }
    location ~ \.php$ {
        include snippets/fastcgi-php.conf;
        fastcgi_pass unix:/run/php/php8.2-fpm.sock;
    }
    location ~ /\.(?!well-known).* { deny all; }
}
```

После проверки nginx включите HTTPS через Certbot или SSL-панель Timeweb. **Не оставляйте production на HTTP:** PWA Service Worker работает только в защищённом контексте.

Для загрузки STL (до 20 МБ) и медиа согласуйте `client_max_body_size`, `upload_max_filesize` и `post_max_size` (например 64M), а также лимиты времени выполнения.

### 5. PWA и 3D

- `/manifest.webmanifest`, `/sw.js`, `/offline.html`, `/pwa-icon.svg` должны открываться без авторизации и возвращать HTTP 200.
- Для полной совместимости установщика Android нужны PNG-иконки 192×192 и 512×512, включая maskable; SVG уже добавлена как базовая иконка.
- STL хранятся в `storage/app/public/models/stl`, доступны через `public/storage` после `storage:link`.
- Для страницы без STL или при ошибке загрузки используется стандартная Three.js-модель.
- Service Worker не кэширует админку, API, `/storage/` и STL, чтобы не сохранять персональные данные и большие модели офлайн.
- После обновления проверяйте установку PWA в Chrome Android, офлайн-экран и 3D на главной и динамических страницах.

### 6. Проверка

```bash
php artisan about
php artisan migrate:status
php artisan route:list
php artisan storage:link
curl -I https://ВАШ-ДОМЕН/
curl -I https://ВАШ-ДОМЕН/manifest.webmanifest
curl -I https://ВАШ-ДОМЕН/sw.js
```

Проверьте вручную: главную и интерактивные разделы, админку и авторизацию, сохранение контента, загрузку STL и медиа, воспроизведение концертов, PWA-установку и офлайн-страницу. **Сборка и браузерные тесты ещё не подтверждены.**

### 7. Обновление без потери файлов

Перед обновлением сделайте дамп БД и резервную копию `storage/app/public` и `.env` в защищённое хранилище. Затем:

```bash
cd /var/www/chmuzuch
git pull --ff-only origin feature/legacy-site-crawler
composer install --no-dev --prefer-dist --optimize-autoloader
php artisan migrate --force
npm install
npm run build
php artisan optimize:clear
php artisan config:cache
php artisan view:cache
```

Не удаляйте `storage/app/public`, не выполняйте `migrate:fresh` на рабочей базе. Если потребуется очередь, настройте Supervisor; планировщик Laravel — cron `* * * * * cd /var/www/chmuzuch && php artisan schedule:run >/dev/null 2>&1`.

### 8. Известные задачи до запуска

- Проверить наличие `composer.lock` и `package-lock.json` и воспроизводимость установки.
- Создать безопасный механизм первого администратора.
- Сгенерировать PNG-иконки PWA и проверить установку на Android.
- Проверить 3D STL на всех публичных шаблонах, включая концерты и новости.
- Выполнить smoke-тесты и резервное копирование перед публикацией.
