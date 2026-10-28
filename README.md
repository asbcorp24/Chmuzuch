# Чебоксарское музыкальное училище — Chmuzuch

Сайт и CMS БПОУ «Чебоксарское музыкальное училище им. Ф. П. Павлова». Laravel 9, PHP 8.2, MySQL, Vite, Three.js, STL, PWA.

> Инструкции развёртывания адаптированы по образцу проекта [vdmsh](https://github.com/asbcorp24/vdmsh), но версии и команды приведены для **этого** репозитория. Контент старого сайта не импортируется автоматически.

## Развёртывание на виртуальном сервере Timeweb Cloud (VPS/VDS)

Рекомендуемая ОС: Ubuntu 22.04 LTS. Начальная конфигурация: 2 vCPU, 4 ГБ RAM, SSD 40+ ГБ (увеличить для медиатеки). Потребуются домен, публичный IP, SSH-доступ с sudo и открытые порты 22, 80, 443.

### 1. Системные пакеты

```bash
sudo apt update && sudo apt upgrade -y
sudo apt install -y nginx mysql-server git unzip curl ca-certificates software-properties-common
sudo add-apt-repository -y ppa:ondrej/php
sudo apt update
sudo apt install -y php8.2-fpm php8.2-cli php8.2-mysql php8.2-mbstring php8.2-xml php8.2-curl php8.2-zip php8.2-gd php8.2-bcmath php8.2-intl
sudo apt install -y composer
php -v
composer --version
```

Установите Node.js 20 LTS из официального репозитория NodeSource или через nvm для пользователя развёртывания. Проверьте `node -v` и `npm -v`. Для автоматического HTTPS: `sudo apt install -y certbot python3-certbot-nginx`.

### 2. База данных

```bash
sudo mysql
```

В консоли MySQL (замените пароль):

```sql
CREATE DATABASE chmuzuch CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER 'chmuzuch'@'localhost' IDENTIFIED BY 'REPLACE_WITH_STRONG_PASSWORD';
GRANT ALL PRIVILEGES ON chmuzuch.* TO 'chmuzuch'@'localhost';
FLUSH PRIVILEGES;
EXIT;
```

### 3. Код и переменные окружения

```bash
sudo mkdir -p /var/www/chmuzuch
sudo chown -R "$USER":www-data /var/www/chmuzuch
git clone --branch feature/legacy-site-crawler https://github.com/asbcorp24/Chmuzuch.git /var/www/chmuzuch
cd /var/www/chmuzuch
composer install --no-dev --prefer-dist --optimize-autoloader
cp .env.example .env
php artisan key:generate
nano .env
```

Укажите как минимум:

```dotenv
APP_NAME="Чебоксарское музыкальное училище"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://YOUR_DOMAIN
LOG_LEVEL=warning
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=chmuzuch
DB_USERNAME=chmuzuch
DB_PASSWORD=REPLACE_WITH_STRONG_PASSWORD
SESSION_DRIVER=file
FILESYSTEM_DISK=public
```

Не размещайте `.env` в публичном каталоге и не коммитьте его. Проверьте, что секреты отсутствуют в логах и резервных копиях, доступных через веб.

### 4. Миграции, файлы и сборка

```bash
php artisan migrate --force
php artisan storage:link
npm install
npm run build
sudo chgrp -R www-data storage bootstrap/cache
sudo chmod -R ug+rwX storage bootstrap/cache
php artisan optimize
```

**Важно:** в текущем проекте не подтверждён сидер для первого администратора. Не запускайте `migrate --seed` без проверки. Перед публичным запуском настройте создание администратора через защищённую консольную команду или проверенный сидер; не оставляйте публичный маршрут первичной регистрации.

### 5. Nginx

Создайте `/etc/nginx/sites-available/chmuzuch`:

```nginx
server {
    listen 80;
    server_name YOUR_DOMAIN;
    root /var/www/chmuzuch/public;
    index index.php;
    charset utf-8;
    client_max_body_size 30M;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        include snippets/fastcgi-php.conf;
        fastcgi_pass unix:/run/php/php8.2-fpm.sock;
    }

    location ~ /\. { deny all; }
    location ~* \.(env|log|sql|bak)$ { deny all; }
}
```

Активируйте:

```bash
sudo ln -s /etc/nginx/sites-available/chmuzuch /etc/nginx/sites-enabled/chmuzuch
sudo nginx -t && sudo systemctl reload nginx
sudo certbot --nginx -d YOUR_DOMAIN
```

В панели Timeweb направьте A-запись домена на IP VPS. Если используется AAAA-запись, убедитесь, что IPv6 тоже настроен. После выдачи сертификата убедитесь, что HTTP перенаправляется на HTTPS.

### 6. PWA и 3D

PWA использует `/manifest.webmanifest`, `/sw.js`, `/offline.html`, `/pwa-icon.svg`. Service Worker работает по HTTPS (или localhost). В Chrome DevTools → Application проверьте Manifest, Service Workers и возможность установки.

Загрузка STL и медиа идёт в `storage/app/public`; символьная ссылка `public/storage` создаётся через `php artisan storage:link`. Для загрузок STL настроен лимит 20 МБ; `client_max_body_size` Nginx выше него, но проверьте `upload_max_filesize` и `post_max_size` PHP-FPM.

Не кэшируйте административные страницы и приватные данные через Service Worker. Офлайн-режим ограничен статикой и ранее доступными ресурсами; полноценная автономная медиатека не реализована.

### 7. Планировщик и обновление

Cron при необходимости:

```cron
* * * * * cd /var/www/chmuzuch && /usr/bin/php8.2 artisan schedule:run >> /dev/null 2>&1
```

Обновление после резервного копирования БД и `storage/app/public`:

```bash
cd /var/www/chmuzuch
git pull --ff-only
composer install --no-dev --prefer-dist --optimize-autoloader
php artisan migrate --force
npm install
npm run build
php artisan optimize:clear
php artisan optimize
```

Не выполняйте `git reset --hard` на сервере с незакоммиченными изменениями.

### 8. Контрольный список перед публикацией

- DNS, HTTPS и автоматическое продление сертификата работают.
- `php artisan about`, `php artisan migrate:status`, `php artisan route:list` проходят без ошибок.
- `APP_DEBUG=false`, каталог проекта закрыт от прямой выдачи.
- Главная, меню, новости, концерты, медиа и формы проверены на телефоне и ПК.
- STL загружается, поворачивается, а при отсутствии файла отображается модель по умолчанию.
- PWA устанавливается на Android, офлайн-экран работает.
- Авторизация администратора, права доступа и загрузка файлов протестированы.
- Резервное копирование MySQL и `storage/app/public` настроено и проверено восстановлением.

## Ветки

Разработка: `feature/legacy-site-crawler`. Слияние в `main` — только после явного подтверждения. Деплой из feature-ветки подходит для тестового стенда; для боевого запуска рекомендуется сначала провести приёмку и утвердить релиз.

## Развёртывание на Timeweb

Разворачиваем по схеме проекта [vdmsh](https://github.com/asbcorp24/vdmsh): Git → Composer → .env → миграции → Vite → кеширование. Проект использует Laravel 9, PHP 8.0.2+ (рекомендуется PHP 8.2), MySQL, Vite 4, Three.js.

**Рекомендуется Timeweb Cloud VPS** с Ubuntu, SSH, PHP-FPM, Composer 2, Node.js 20 и MySQL/MariaDB. Для обычного виртуального хостинга нужно предварительно проверить SSH, расширения PHP и настройку document root.

Корень сайта в настройках веб-сервера: **/var/www/chmuzuch/public**, а не корень репозитория. Домен должен работать через HTTPS для PWA.

### Установка

```bash
cd /var/www
git clone -b feature/legacy-site-crawler https://github.com/asbcorp24/Chmuzuch.git chmuzuch
cd chmuzuch
composer install --no-dev --prefer-dist --optimize-autoloader
cp .env.example .env
php artisan key:generate
```

Создайте в Timeweb базу данных и пользователя. В .env установите APP_ENV=production, APP_DEBUG=false, APP_URL=https://ВАШ-ДОМЕН, DB_HOST, DB_DATABASE, DB_USERNAME и DB_PASSWORD. Не публикуйте .env и не добавляйте его в Git.

```bash
php artisan migrate --force
php artisan storage:link
npm install
npm run build
php artisan optimize:clear
php artisan config:cache
php artisan view:cache
chmod -R ug+rwX storage bootstrap/cache
```

**Не запускайте автоматический импорт старого контента.** Проверенного сидера первого администратора пока нет: его необходимо подготовить и проверить отдельно. Пароль администратора не хранить в Git.

### Настройка Timeweb

В панели Timeweb задайте корневую директорию сайта public, включите SSL и перенаправление HTTP на HTTPS. Для nginx используйте Laravel try_files с передачей запросов в index.php и корректный сокет PHP-FPM. Папки storage и bootstrap/cache должны быть доступны на запись PHP-процессу; не ставьте 777.

### Проверка PWA и 3D

Проверьте адреса /manifest.webmanifest, /sw.js, /offline.html, /pwa-icon.svg. Для полной совместимости установки на Android дополнительно нужны PNG-иконки 192 и 512 пикселей. Проверьте на смартфоне установку через Chrome, работу меню, 3D-модель по умолчанию, загрузку STL и повороты модели. Большие STL и медиа не кэшируются автоматически.

### Проверка приложения

```bash
php artisan about
php artisan migrate:status
php artisan route:list
test -f public/build/manifest.json
```

Откройте главную, /admin/login, новости, концерты, динамические страницы и мобильную версию.

### Обновление

Перед обновлением сделайте резервную копию БД, .env и storage/app/public.

```bash
php artisan down
git pull --ff-only origin feature/legacy-site-crawler
composer install --no-dev --prefer-dist --optimize-autoloader
php artisan migrate --force
npm install
npm run build
php artisan optimize:clear
php artisan config:cache
php artisan view:cache
php artisan up
```

Если обновление завершилось с ошибкой, исправьте её перед возвратом сайта в рабочий режим. Разработка продолжается в feature/legacy-site-crawler; main без отдельного согласования не изменяется.
