# 🐙 အခန်း (၆) - Docker Compose & Multi-Container Applications

---

## ၁၅။ Docker Compose ဆိုတာ ဘာလဲ? (Why Docker Compose?)

### 😫 Single Docker CLI ဖြင့် အလုပ်လုပ်ရသော ဒုက္ခ
သင်သည် Laravel Application အပြည့်အစုံတစ်ခု Run လိုပါက အောက်ပါအတိုင်း Command ပေါင်းများစွာကို တစ်ခုပြီးတစ်ခု အရှည်ကြီး ရိုက်ထည့်ရပါမည်-
```bash
docker network create laravel-net
docker volume create mysql-data

# MySQL Run ရန်
docker run -d --name db --network laravel-net -v mysql-data:/var/lib/mysql -e MYSQL_ROOT_PASSWORD=secret mysql:8.0

# Redis Run ရန်
docker run -d --name redis --network laravel-net redis:alpine

# PHP-FPM Run ရန်
docker run -d --name app --network laravel-net -v $(pwd):/var/www/html php:8.3-fpm

# Nginx Web Server Run ရန်
docker run -d --name web --network laravel-net -p 80:80 -v $(pwd):/var/www/html nginx:alpine
```
ဤသို့ Command များကို အလွတ်မှတ်ပြီး နေ့တိုင်း ရိုက်နေရခြင်းသည် အမှားများစေပြီး အလွန် လက်ဝင်စေပါသည်။

### 💡 Docker Compose ၏ အခန်းကဏ္ဍ
**Docker Compose** သည် Multi-Container Applications များကို **YAML Configuration File (`docker-compose.yml`)** တစ်ခုတည်းတွင် စနစ်တကျ ကြေညာပြီး-
```bash
docker compose up -d
```
ဟူသော Command တစ်ကြောင်းတည်းဖြင့် Container အားလုံး၊ Network များနှင့် Volume များကို **တစ်ပြိုင်နက်တည်း (All in One)** အဆင်သင့် ဖြစ်အောင် ဆောက်လုပ် Run ပေးသည့် Tool ဖြစ်သည်။

---

## ၁၆။ Multi-Container Architecture & `docker-compose.yml` ဖွဲ့စည်းပုံ

အောက်တွင် ခေတ်မီ Web Architecture အရ Container ၄ ခုဖြင့် တည်ဆောက်ထားသော စနစ်ကို လေ့လာကြည့်ပါ-

```mermaid
graph LR
    User["🌐 Web Browser (Client)"] -->|Port 80| NGINX["Nginx Web Server Container<br/>(Reverse Proxy & Static Files)"]
    NGINX -->|FastCGI (Port 9000)| PHP["Laravel PHP-FPM Container<br/>(Application Logic)"]
    PHP -->|Port 3306| MYSQL["MySQL Database Container<br/>(Data Persistence)"]
    PHP -->|Port 6379| REDIS["Redis Container<br/>(Cache & Session)"]
```

---

### 📝 `docker-compose.yml` ဖိုင်တည်ဆောက်ပုံ အပြည့်အစုံ

```yaml
# Docker Compose Version (ယခု Compose v2 တွင် version မထည့်လည်း ရပါသည်)
services:

  # -------------------------------------------------------------
  # ၁။ Nginx Web Server Service
  # -------------------------------------------------------------
  nginx:
    image: nginx:alpine
    container_name: laravel-nginx
    restart: unless-stopped
    ports:
      - "80:80"        # Host Port 80 သို့ ဖွင့်လှစ်ပေးထားသည်
    volumes:
      - ./:/var/www/html                     # Laravel Source Code Bind Mount
      - ./docker/nginx:/etc/nginx/conf.d     # Nginx Configuration Bind Mount
    depends_on:
      - php                                  # PHP မတက်မချင်း Nginx ကို မ run ပါ
    networks:
      - laravel-network

  # -------------------------------------------------------------
  # ၂။ Laravel PHP 8.3 FPM Application Service
  # -------------------------------------------------------------
  php:
    build:
      context: .
      dockerfile: Dockerfile                 # Local Dockerfile မှ Custom Build မည်
    container_name: laravel-app
    restart: unless-stopped
    volumes:
      - ./:/var/www/html                     # Source Code Live Sync
    environment:
      - DB_HOST=mysql                        # Service Name 'mysql' ကို တိုက်ရိုက် သုံးနိုင်သည်
      - REDIS_HOST=redis                     # Service Name 'redis' ကို တိုက်ရိုက် သုံးနိုင်သည်
    depends_on:
      mysql:
        condition: service_healthy           # MySQL Healthcheck အောင်မြင်မှသာ PHP စတင်မည်
      redis:
        condition: service_started
    networks:
      - laravel-network

  # -------------------------------------------------------------
  # ၃။ MySQL Database Service
  # -------------------------------------------------------------
  mysql:
    image: mysql:8.0
    container_name: laravel-mysql
    restart: unless-stopped
    environment:
      MYSQL_ROOT_PASSWORD: root_secret
      MYSQL_DATABASE: laravel_db
      MYSQL_USER: laravel_user
      MYSQL_PASSWORD: user_secret
    ports:
      - "127.0.0.1:3306:3306"                # Local စက်မှ TablePlus / DBeaver ဖြင့် ဝင်ကြည့်ရန်
    volumes:
      - mysql-data:/var/lib/mysql            # Persistent Data Volume
    healthcheck:                             # Database အမှန်တကယ် အဆင်သင့်ဖြစ်မဖြစ် စစ်ဆေးခြင်း
      test: ["CMD", "mysqladmin", "ping", "-h", "localhost", "-u", "root", "-proot_secret"]
      interval: 5s
      timeout: 5s
      retries: 5
    networks:
      - laravel-network

  # -------------------------------------------------------------
  # ၄။ Redis In-Memory Cache Service
  # -------------------------------------------------------------
  redis:
    image: redis:alpine
    container_name: laravel-redis
    restart: unless-stopped
    volumes:
      - redis-data:/data
    networks:
      - laravel-network

# ---------------------------------------------------------------
# Persistent Volumes ကြေညာခြင်း
# ---------------------------------------------------------------
volumes:
  mysql-data:
    driver: local
  redis-data:
    driver: local

# ---------------------------------------------------------------
# Custom Bridge Network ကြေညာခြင်း
# ---------------------------------------------------------------
networks:
  laravel-network:
    driver: bridge
```

---

### 🔑 အရေးကြီးသော Compose သဘောတရားများ

1. **`build` vs `image`:**
   - `image: mysql:8.0` : Docker Hub ပေါ်ရှိ Official Image ကို တိုက်ရိုက် ဒေါင်းလုဒ်ဆွဲယူသည်။
   - `build: .` : ကိုယ်ပိုင် Directory ထဲရှိ `Dockerfile` ကို သုံးပြီး Custom Image အဖြစ် တည်ဆောက်သည်။

2. **`depends_on` နှင့် `condition: service_healthy`:**
   - သာမန် `depends_on` သည် MySQL container စတင် boot တက်သည်နှင့် PHP container ကို ချက်ချင်း run လိုက်သည်။ သို့သော် MySQL သည် Internal Initialization လုပ်ရန် စက္ကန့် ၂၀ ခန့် ကြာတတ်သဖြင့် Laravel ဘက်မှ `Database Connection Refused` error တက်တတ်သည်။
   - `condition: service_healthy` ကို သုံးလိုက်ပါက MySQL က Ping ပြန်ပြီး အမှန်တကယ် လက်ခံနိုင်သည့် အခြေအနေရောက်မှသာ PHP service စတင် အလုပ်လုပ်မည် ဖြစ်သည်။

3. **Multi-Container Lifecycle စီမံခန့်ခွဲပုံ:**
   ```bash
   # Containers အားလုံးကို Background တွင် စတင် run ခြင်း
   docker compose up -d

   # Status စစ်ဆေးခြင်း
   docker compose ps

   # Log များကို Live ကြည့်ရှုခြင်း
   docker compose logs -f

   # Stack တစ်ခုလုံးကို ပြန်လည် ပိတ်သိမ်းခြင်း
   docker compose down
   ```
