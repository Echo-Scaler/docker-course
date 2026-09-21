# 🛠️ အခန်း (၃) - Dockerfile & Image Building

---

## ၈။ Dockerfile ဆိုတာ ဘာလဲ? (Dockerfile Instructions)

### 📌 အဓိပ္ပာယ်ဖွင့်ဆိုချက်
`Dockerfile` ဆိုသည်မှာ မိမိ စိတ်ကြိုက် Docker Image တစ်ခုကို အစအဆုံး တည်ဆောက်ရန် Docker Engine အတွက် လိုအပ်သော ညွှန်ကြားချက်များ (Instructions) ကို အဆင့်ဆင့် ရေးသားထားသော Plain Text Configuration ဖိုင် ဖြစ်သည်။

---

### 📜 အရေးကြီးသော Dockerfile Instructions များ အသေးစိတ်

| Instruction | အဓိပ္ပာယ် နှင့် အသုံးပြုပုံ | ဥပမာ |
| :--- | :--- | :--- |
| **`FROM`** | အခြေခံယူမည့် Base Image ကို သတ်မှတ်သည် (Dockerfile တိုင်း၏ ပထမဆုံး လိုင်းဖြစ်ရမည်) | `FROM php:8.3-fpm-alpine` |
| **`WORKDIR`** | Container အတွင်း အလုပ်လုပ်မည့် Working Directory လမ်းကြောင်း သတ်မှတ်သည် (Linux ၏ `cd` နှင့် အလားတူသည်) | `WORKDIR /var/www/html` |
| **`COPY`** | Host စက်ထဲမှ ဖိုင်/ဖိုဒါများကို Container ဖိုင်စနစ်ထဲသို့ ကူးယူသည် | `COPY . /var/www/html` |
| **`ADD`** | `COPY` နှင့် တူသော်လည်း URL မှ ဒေါင်းဆွဲနိုင်ပြီး `.tar.gz` ဖိုင်များကို အလိုအလျောက် ဖြည်ပေးနိုင်သည် (ပုံမှန်အားဖြင့် `COPY` ကိုသာ သုံးသင့်သည်) | `ADD app.tar.gz /var/www/` |
| **`RUN`** | Image တည်ဆောက်ချိန် (Build Time) တွင် Linux Command များကို Run ရန် (ဥပမာ- packages သွင်းခြင်း) | `RUN apk update && apk add git curl` |
| **`ENV`** | Container အတွင်း အမြဲတမ်း တည်ရှိနေမည့် Environment Variable များ သတ်မှတ်သည် | `ENV APP_ENV=production` |
| **`ARG`** | Image Build လုပ်ချိန်တွင်သာ ယာယီအသုံးပြုမည့် Build Variable သတ်မှတ်သည် | `ARG PHP_VERSION=8.3` |
| **`EXPOSE`** | Container အလုပ်လုပ်မည့် Network Port ကို အသိပေး ကြေညာသည် (သတိပြုရန်: အပြင်သို့ အလိုအလျောက် ပွင့်မသွားပါ၊ Documentation သဘောသာ ဖြစ်သည်) | `EXPOSE 9000` |
| **`VOLUME`** | Container ထဲရှိ မည်သည့် folder ကို Data Persistence အတွက် Volume လုပ်မည်ဟု ကြေညာသည် | `VOLUME ["/var/www/html/storage"]` |
| **`USER`** | နောက်ဆက်တွဲ Command များကို Root မဟုတ်ဘဲ မည်သည့် Linux User ဖြင့် Run မည်ကို သတ်မှတ်သည် (လုံခြုံရေးအတွက် သုံးသည်) | `USER www-data` |
| **`CMD`** | Container စတင် Run သည့်အခါ အလုပ်လုပ်မည့် Default Command (ပြင်ပမှ `docker run` flag ဖြင့် အလွယ်တကူ Override လုပ်နိုင်သည်) | `CMD ["php-fpm"]` |
| **`ENTRYPOINT`**| Container စတင်ချိန်တွင် မဖြစ်မနေ Run မည့် ပင်မ Executable Process (ပြင်ပမှ Override လုပ်ရန် ခက်ခဲသည်) | `ENTRYPOINT ["docker-entrypoint.sh"]` |

---

### ⚔️ `CMD` vs `ENTRYPOINT` (မကြာခဏ မှားတတ်သော အကြောင်းအရာ)

- **Shell Form vs Exec Form:**
  - Shell Form: `CMD php-fpm` (Behind the scenes တွင် `/bin/sh -c php-fpm` ဟု Run သဖြင့် PID 1 မဟုတ်ဘဲ Stop signal ကောင်းစွာ မရနိုင်ပါ)။
  - **Exec Form (အကြံပြုသည့် ပုံစံ):** `CMD ["php-fpm"]` (JSON Array format ဖြစ်ပြီး Linux Signal များကို တိုက်ရိုက် လက်ခံနိုင်သည်)။

- **တွဲဖက် အသုံးပြုပုံ (Best Practice):**
  ```dockerfile
  # Container သည် အမြဲတမ်း PHP artisan command ကို အခြေခံထားမည်
  ENTRYPOINT ["php", "artisan"]

  # Default argument မှာ route:list ဖြစ်သော်လည်း အပြင်မှ အခြား argument ပေး၍ ရသည်
  CMD ["route:list"]
  ```
  အကယ်၍ `docker run my-image` ဟု run ပါက `php artisan route:list` ဖြစ်မည်။  
  အကယ်၍ `docker run my-image migrate` ဟု run ပါက `php artisan migrate` ဖြစ်သွားမည်။

---

## ၉။ Docker Build နှင့် Multi-Stage Builds

### 🐘 လက်တွေ့ Laravel Production Dockerfile ဥပမာ

အောက်ပါ Dockerfile သည် Multi-Stage Build နည်းပညာကို သုံး၍ Composer နှင့် Node.js Frontend (Vite) ကို သီးခြား build ပြီး အသေးဆုံး၊ အလုံခြုံဆုံး Production PHP-FPM Image ရရှိအောင် ရေးသားထားခြင်း ဖြစ်သည်-

```dockerfile
# ==========================================
# အဆင့် (၁): Composer Dependencies Build Stage
# ==========================================
FROM composer:2.7 AS composer_build
WORKDIR /app
COPY composer.json composer.lock ./
# Production အတွက် dev package များ မပါဘဲ optimize လုပ်၍ သွင်းခြင်း
RUN composer install --no-dev --optimize-autoloader --no-interaction --no-progress

# ==========================================
# အဆင့် (၂): Frontend Assets Build Stage (Vite/Tailwind)
# ==========================================
FROM node:20-alpine AS node_build
WORKDIR /app
COPY package.json package-lock.json ./
RUN npm ci
COPY resources/ resources/
COPY vite.config.js ./
RUN npm run build

# ==========================================
# အဆင့် (၃): Final Production Image (PHP 8.3 FPM)
# ==========================================
FROM php:8.3-fpm-alpine

# လိုအပ်သော Linux OS level packages များနှင့် PHP Extensions သွင်းခြင်း
RUN apk update && apk add --no-cache \
    curl \
    libpng-dev \
    libzip-dev \
    zip \
    unzip \
    oniguruma-dev

# Laravel အတွက် မရှိမဖြစ် PHP extensions များ တပ်ဆင်ခြင်း
RUN docker-php-ext-install pdo_mysql mbstring gd zip opcache

# အလုပ်လုပ်မည့် directory သတ်မှတ်ခြင်း
WORKDIR /var/www/html

# Source code အားလုံး ကူးယူခြင်း
COPY . /var/www/html

# Stage 1 မှ Vendor libraries နှင့် Stage 2 မှ Built frontend assets များကိုသာ ရွေးကူးခြင်း
COPY --from=composer_build /app/vendor /var/www/html/vendor
COPY --from=node_build /app/public/build /var/www/html/public/build

# Permission ပိုင်း သတ်မှတ်ပေးခြင်း (www-data သို့ လွှဲပြောင်းပေးခြင်း)
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Port 9000 တွင် FastCGI process ဖွင့်လှစ်ခြင်း
EXPOSE 9000

# www-data user ဖြင့်သာ လည်ပတ်စေခြင်း (Security Best Practice)
USER www-data

# Container စတင်ချိန်တွင် PHP-FPM စတင် run မည်
CMD ["php-fpm"]
```

---

### ⚡ Layer Caching ကို အကောင်းဆုံး အသုံးချနည်း

Docker Image build လုပ်သည့်အခါ အချိန်အကြာဆုံး အဆင့်မှာ `composer install` သို့မဟုတ် `npm install` ဖြစ်သည်။

❌ **မလုပ်သင့်သော ပုံစံ:**
```dockerfile
COPY . .
RUN composer install
```
*(အကြောင်းပြချက်: Source code တစ်ကြောင်း ပြင်လိုက်ရုံနှင့် `COPY . .` လိုင်း ပျက်စီးသွားပြီး `composer install` ကို အစအဆုံး ပြန် run သဖြင့် Build အလွန် ကြာသည်)*

✅ **လုပ်သင့်သော ပုံစံ (Layer Cache Optimization):**
```dockerfile
COPY composer.json composer.lock ./
RUN composer install --no-dev
COPY . .
```
*(အကျိုးကျေးဇူး: `composer.json` မပြောင်းလဲသရွေ့ `composer install` ကို နောက်တစ်ကြိမ် build တိုင်း အစက ပြန်မလုပ်တော့ဘဲ Cache မှ စက္ကန့်ပိုင်းအတွင်း ယူသုံးသည်)*

---

### 🌐 Docker Buildx (Cross-Platform Builds)

ယခုခေတ်တွင် Mac M1/M2/M3/M4 (ARM64) သုံးပြီး Cloud Server သည် Intel/AMD (AMD64) ဖြစ်နေသော အခြေအနေများတွင် `buildx` ဖြင့် Multi-arch image build လုပ်နိုင်ပါသည်-

```bash
# Buildx builder အသစ်တစ်ခု ဆောက်ပြီး သုံးခြင်း
docker buildx create --name mybuilder --use

# AMD64 နှင့် ARM64 နှစ်မျိုးစလုံးအတွက် build ပြီး Docker Hub သို့ တစ်ခါတည်း push လုပ်ခြင်း
docker buildx build --platform linux/amd64,linux/arm64 -t username/laravel-app:1.0 --push .
```
