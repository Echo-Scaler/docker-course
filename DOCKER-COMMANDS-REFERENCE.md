# 📖 Docker & Docker Compose Commands Reference Guide (မြန်မာဘာသာ)

ဤဖိုင်တွင် Docker CLI နှင့် Docker Compose command တိုင်းကို အောက်ပါ Rule အတိုင်း စနစ်တကျ အသေးစိတ် ရှင်းလင်းပေးထားပါသည်-
1. **ရည်ရွယ်ချက် (Purpose & What it does)**
2. **Syntax (ပုံစံ)**
3. **အသုံးများသော Flag များ (Common Options/Flags)**
4. **လက်တွေ့ အသုံးပြုပုံ ဥပမာ (Real-World Practical Example)**
5. **ရလဒ်နှင့် ရှင်းလင်းချက် (Output & Detailed Explanation)**

---

## 📑 မာတိကာ (Table of Contents)

1. [Docker System & Information Commands](#1-docker-system--information-commands)
2. [Docker Registry & Authentication Commands](#2-docker-registry--authentication-commands)
3. [Docker Image Management Commands](#3-docker-image-management-commands)
4. [Docker Build & Buildx Commands](#4-docker-build--buildx-commands)
5. [Docker Container Lifecycle Commands](#5-docker-container-lifecycle-commands)
6. [Docker Monitoring, Inspection & Debugging Commands](#6-docker-monitoring-inspection--debugging-commands)
7. [Docker Execution, File Transfer & Import/Export](#7-docker-execution-file-transfer--importexport)
8. [Docker Volume Management Commands](#8-docker-volume-management-commands)
9. [Docker Network Management Commands](#9-docker-network-management-commands)
10. [Docker Compose Commands](#10-docker-compose-commands)

---

## 1. Docker System & Information Commands

### `docker version`
- **ရည်ရွယ်ချက်:** သင်၏စက်ထဲတွင် သွင်းထားသော Docker Client နှင့် Docker Server (Daemon) ၏ Version အချက်အလက်များ၊ Git commit၊ Go version နှင့် OS/Arch တို့ကို ကြည့်ရှုရန် အသုံးပြုသည်။
- **Syntax:**
  ```bash
  docker version [OPTIONS]
  ```
- **အသုံးများသော Options:**
  - `--format` : Output ကို Go template / JSON format ဖြင့် ထုတ်ယူရန် (ဥပမာ- `docker version --format '{{.Server.Version}}'`)
- **Real-World Example:**
  ```bash
  docker version
  ```
- **ရှင်းလင်းချက်:**
  Client အပိုင်းသာမက Docker Daemon (Server) ပါ အလုပ်လုပ်နေခြင်း ရှိ/မရှိ ဤ command ဖြင့် ချက်ချင်း သိရှိနိုင်သည်။ Server မ run ထားပါက `Cannot connect to the Docker daemon` ဟု ပြပါမည်။

---

### `docker info`
- **ရည်ရွယ်ချက်:** Docker Engine ၏ တစ်ခုလုံးဆိုင်ရာ အသေးစိတ် အခြေအနေ (System-wide Information) ကို ကြည့်ရှုရန်။ Total containers အရေအတွက် (running, paused, stopped), Image အရေအတွက်, Storage Driver, Cgroup Driver, CPU, RAM စသည်တို့ကို ပြသပေးသည်။
- **Syntax:**
  ```bash
  docker info [OPTIONS]
  ```
- **Real-World Example:**
  ```bash
  docker info
  ```
- **ရှင်းလင်းချက်:**
  Production server သို့မဟုတ် Local machine တွင် Docker အတွက် CPU ဘယ်လောက်၊ Memory ဘယ်လောက် သတ်မှတ်ပေးထားသလဲ၊ Storage driver (overlay2) မှန်ကန်မှု ရှိ/မရှိ စစ်ဆေးရာတွင် မဖြစ်မနေ အသုံးပြုရသည်။

---

### `docker help`
- **ရည်ရွယ်ချက်:** Docker commands များနှင့် ပတ်သက်သော အကူအညီနှင့် အသုံးပြုပုံ (Help documentation) ကို command line ထဲတွင် ဖတ်ရှုရန်။
- **Syntax:**
  ```bash
  docker help [COMMAND]
  # သို့မဟုတ်
  docker [COMMAND] --help
  ```
- **Real-World Example:**
  ```bash
  docker run --help
  ```
- **ရှင်းလင်းချက်:**
  Command တစ်ခု၏ ရနိုင်သော flags များကို အင်တာနက် မလိုဘဲ terminal တွင် တိုက်ရိုက် ကြည့်ရှုရန် အလွန် အသုံးဝင်သည်။

---

### `docker system df`
- **ရည်ရွယ်ချက်:** Docker က သင့် Hard Drive ထဲတွင် နေရာ (Disk space) မည်မျှ သုံးစွဲထားသည်ကို Images, Containers, Local Volumes နှင့် Build Cache တစ်ခုချင်းစီအလိုက် ရှင်းလင်းစွာ ပြသပေးသည်။
- **Syntax:**
  ```bash
  docker system df [OPTIONS]
  ```
- **Options:**
  - `-v, --verbose` : Image, Container တစ်ခုချင်းစီ ဘယ်လောက်ယူထားသည်ကို အသေးစိတ် ကြည့်ရန်။
- **Real-World Example:**
  ```bash
  docker system df
  ```
- **Output ရှင်းလင်းချက်:**
  `RECLAIMABLE` ကော်လံကို ကြည့်ခြင်းအားဖြင့် မသုံးတော့သည့် Container/Image များကို ဖျက်လိုက်ပါက Disk space မည်မျှ ပြန်ရနိုင်မည်ကို သိရှိနိုင်သည်။

---

### `docker system prune`
- **ရည်ရွယ်ချက်:** မလိုအပ်တော့သော (အသုံးမပြုတော့သော Stopped containers, Dangling images, Unused networks နှင့် Build caches) အားလုံးကို တစ်ချက်တည်းဖြင့် Clean-up လုပ်ပြီး Disk space ပြန်လည် ရယူရန်။
- **Syntax:**
  ```bash
  docker system prune [OPTIONS]
  ```
- **Options:**
  - `-a, --all` : Stopped container က အသုံးမပြုသော image အားလုံးကိုပါ ဖျက်ပစ်ရန်။
  - `--volumes` : အသုံးမပြုတော့သော Anonymous volumes များကိုပါ ဖျက်ရန်။
  - `-f, --force` : Confirmation မတောင်းဘဲ တိုက်ရိုက် ဖျက်ရန်။
- **Real-World Example:**
  ```bash
  docker system prune -a --volumes -f
  ```
- **သတိပြုရန်:** Production ပတ်ဝန်းကျင်တွင် စဉ်းစားပြီးမှသာ သုံးသင့်သည်။ Volume ထဲတွင် data အရေးကြီးပါက သီးသန့် backup ယူထားရမည်။

---

## 2. Docker Registry & Authentication Commands

### `docker login`
- **ရည်ရွယ်ချက်:** Docker Hub သို့မဟုတ် Private Container Registry (AWS ECR, GitHub Packages `ghcr.io`, GitLab Registry) သို့ အကောင့်ဝင်ရန်။
- **Syntax:**
  ```bash
  docker login [OPTIONS] [SERVER]
  ```
- **Options:**
  - `-u, --username` : Username
  - `-p, --password` : Password သို့မဟုတ် Personal Access Token (PAT)
- **Real-World Example:**
  ```bash
  # Docker Hub အတွက်
  docker login -u myusername

  # GitHub Container Registry အတွက်
  docker login ghcr.io -u github_username
  ```

---

### `docker logout`
- **ရည်ရွယ်ချက်:** ချိတ်ဆက်ထားသော Registry မှ Sign out လုပ်ပြီး လုံခြုံရေးအရ စက်ထဲရှိ Token/Credential များကို ဖျက်ပစ်ရန်။
- **Syntax:**
  ```bash
  docker logout [SERVER]
  ```
- **Real-World Example:**
  ```bash
  docker logout
  ```

---

### `docker search`
- **ရည်ရွယ်ချက်:** Docker Hub ပေါ်ရှိ Public Image များကို Terminal ထဲမှ တိုက်ရိုက် ရှာဖွေရန်။
- **Syntax:**
  ```bash
  docker search [OPTIONS] TERM
  ```
- **Options:**
  - `--filter "is-official=true"` : Official image များကိုသာ ရွေးရှာရန်။
  - `--limit N` : ပြသမည့် အရေအတွက် ကန့်သတ်ရန် (Default: 25)။
- **Real-World Example:**
  ```bash
  docker search --filter "is-official=true" --limit 5 php
  ```

---

### `docker pull`
- **ရည်ရွယ်ချက်:** Docker Hub သို့မဟုတ် Remote Registry တစ်ခုခုမှ Image ကို Local စက်ထဲသို့ Download ဆွဲယူရန်။
- **Syntax:**
  ```bash
  docker pull [OPTIONS] NAME[:TAG|@DIGEST]
  ```
- **Real-World Example:**
  ```bash
  docker pull php:8.3-fpm-alpine
  docker pull mysql:8.0
  ```
- **ရှင်းလင်းချက်:** Tag မထည့်ပေးပါက Docker သည် default အနေဖြင့် `:latest` tag ကို ဆွဲယူမည် ဖြစ်သည်။

---

### `docker push`
- **ရည်ရွယ်ချက်:** Local စက်တွင် တည်ဆောက်ထားသော Custom Docker Image ကို Docker Hub သို့မဟုတ် Private Registry သို့ Upload တင်ရန်။
- **Syntax:**
  ```bash
  docker push [OPTIONS] NAME[:TAG]
  ```
- **Real-World Example:**
  ```bash
  docker tag my-laravel-app:v1.0 myusername/my-laravel-app:v1.0
  docker push myusername/my-laravel-app:v1.0
  ```

---

## 3. Docker Image Management Commands

### `docker images` / `docker image ls`
- **ရည်ရွယ်ချက်:** Local machine တွင် ဒေါင်းလုဒ်ဆွဲထားသော သို့မဟုတ် Build လုပ်ထားသော Docker Images စာရင်းကို ကြည့်ရှုရန်။
- **Syntax:**
  ```bash
  docker images [OPTIONS] [REPOSITORY[:TAG]]
  ```
- **Options:**
  - `-a, --all` : Intermediate images အားလုံးကိုပါ ကြည့်ရန်။
  - `-q, --quiet` : Image IDs များကိုသာ ထုတ်ယူရန် (Scripting တွင် အလွန်သုံးသည်)။
- **Real-World Example:**
  ```bash
  docker images
  ```

---

### `docker image inspect`
- **ရည်ရွယ်ချက်:** Image တစ်ခု၏ အသေးစိတ် အချက်အလက်များ (Layers, Environment Variables, Exposed Ports, Default Entrypoint, OS Architecture စသည်) ကို JSON format ဖြင့် အသေးစိတ် ကြည့်ရှုရန်။
- **Syntax:**
  ```bash
  docker image inspect IMAGE_NAME[:TAG]
  ```
- **Real-World Example:**
  ```bash
  docker image inspect nginx:alpine
  ```

---

### `docker image history`
- **ရည်ရွယ်ချက်:** Image တစ်ခုကို တည်ဆောက်ခဲ့စဉ်က Dockerfile အဆင့်ဆင့် (Layers) များနှင့် Layer တစ်ခုချင်းစီ၏ Size ကို ပြန်လည် စစ်ဆေးရန်။
- **Syntax:**
  ```bash
  docker image history [OPTIONS] IMAGE
  ```
- **Real-World Example:**
  ```bash
  docker image history php:8.3-fpm
  ```
- **ရှင်းလင်းချက်:** Image Size ကြီးနေပါက မည်သည့် layer က MB အများဆုံး ယူထားသည်ကို ရှာဖွေရန် အလွန် အသုံးဝင်သည်။

---

### `docker tag`
- **ရည်ရွယ်ချက်:** Image တစ်ခုကို နာမည်အသစ် သို့မဟုတ် Version Tag အသစ် သတ်မှတ်ပေးရန် (Registry သို့ Push မလုပ်မီ မဖြစ်မနေ သုံးရသည်)။
- **Syntax:**
  ```bash
  docker tag SOURCE_IMAGE[:TAG] TARGET_IMAGE[:TAG]
  ```
- **Real-World Example:**
  ```bash
  docker tag laravel-app:latest kyawwaiyan/laravel-app:1.0.0
  ```

---

### `docker image rm` (သို့မဟုတ် `docker rmi`)
- **ရည်ရွယ်ချက်:** မလိုလားအပ်သော Local Docker Image များကို ဖျက်ပစ်ရန်။
- **Syntax:**
  ```bash
  docker image rm [OPTIONS] IMAGE [IMAGE...]
  ```
- **Options:**
  - `-f, --force` : Container တစ်ခုခုက သုံးနေသော်လည်း ဇွတ်အတင်း ဖျက်ရန်။
- **Real-World Example:**
  ```bash
  docker image rm nginx:alpine
  ```

---

### `docker image prune`
- **ရည်ရွယ်ချက်:** Tag မရှိတော့သော Dangling images (`<none>:<none>`) များကို ရှင်းထုတ်ရန်။
- **Syntax:**
  ```bash
  docker image prune [OPTIONS]
  ```
- **Options:**
  - `-a, --all` : Container များနှင့် မချိတ်ဆက်ထားသော Image အားလုံးကို ဖျက်ရန်။
- **Real-World Example:**
  ```bash
  docker image prune -f
  ```

---

### `docker save` နှင့် `docker load`
- **ရည်ရွယ်ချက်:**
  - `docker save` : Docker Image ကို `.tar` file အဖြစ် Export ထုတ်ရန် (အင်တာနက်မရှိသော Offline Server သို့ ကူးယူရန်)။
  - `docker load` : ထို `.tar` file ကို Docker Image အဖြစ် ပြန်လည် သွင်းယူရန်။
- **Syntax & Real-World Example:**
  ```bash
  # Image ကို tar file ထုတ်ခြင်း
  docker save -o my-laravel-app.tar my-laravel-app:v1.0

  # အခြား server တစ်ခုတွင် tar file ကို ပြန်သွင်းခြင်း
  docker load -i my-laravel-app.tar
  ```

---

## 4. Docker Build & Buildx Commands

### `docker build`
- **ရည်ရွယ်ချက်:** `Dockerfile` ထဲတွင် ရေးသားထားသော ညွှန်ကြားချက်များအတိုင်း Docker Image အသစ်တစ်ခု တည်ဆောက်ရန်။
- **Syntax:**
  ```bash
  docker build [OPTIONS] PATH | URL
  ```
- **အသုံးများသော Options:**
  - `-t, --tag` : Image နာမည်နှင့် Tag ပေးရန် (ဥပမာ- `-t my-app:1.0`)
  - `-f, --file` : အခြား အမည်ရှိသော Dockerfile ကို ညွှန်ပြရန် (ဥပမာ- `-f Dockerfile.prod`)
  - `--no-cache` : ယခင် build cache များကို မသုံးဘဲ အစမှ ပြန်လည် build လုပ်ရန်
  - `--build-arg` : Dockerfile ထဲရှိ `ARG` သို့ တန်ဖိုး ပေးပို့ရန်
- **Real-World Example:**
  ```bash
  docker build -t laravel-app:latest .
  docker build --no-cache -t laravel-app:v2 -f Dockerfile.prod .
  ```
- **ရှင်းလင်းချက်:** နောက်ဆုံးက အစက် `.` သည် လက်ရှိ directory (Build Context) ကို ကိုယ်စားပြုသည်။

---

### `docker buildx build`
- **ရည်ရွယ်ချက်:** Multi-Architecture Images (ဥပမာ- Apple Silicon `linux/arm64` နှင့် Cloud Linux Server `linux/amd64` နှစ်မျိုးစလုံးတွင် run နိုင်သော Image) တည်ဆောက်ရန်။
- **Syntax:**
  ```bash
  docker buildx build [OPTIONS] PATH
  ```
- **Options:**
  - `--platform` : Target platform များ သတ်မှတ်ရန် (ဥပမာ- `linux/amd64,linux/arm64`)
  - `--push` : Build ပြီးသည်နှင့် Registry သို့ တိုက်ရိုက် push တင်ရန်
- **Real-World Example:**
  ```bash
  docker buildx build --platform linux/amd64,linux/arm64 -t kyawwaiyan/laravel-app:v1.0 --push .
  ```

---

## 5. Docker Container Lifecycle Commands

### `docker create`
- **ရည်ရွယ်ချက်:** Image တစ်ခုမှ Container အသစ်တစ်ခုကို ဆောက်ထားသော်လည်း ချက်ချင်း မ Run ဘဲ 'Created' အခြေအနေဖြင့် ထားရှိရန်။
- **Syntax:**
  ```bash
  docker create [OPTIONS] IMAGE [COMMAND] [ARG...]
  ```
- **Real-World Example:**
  ```bash
  docker create --name my-redis-cache redis:alpine
  ```

---

### `docker run` (⭐️ အရေးအကြီးဆုံး Command)
- **ရည်ရွယ်ချက်:** Image တစ်ခုမှ Container အသစ်ကို Create လုပ်ပြီး ချက်ချင်း Start (Run) လုပ်ရန်။
- **Syntax:**
  ```bash
  docker run [OPTIONS] IMAGE [COMMAND] [ARG...]
  ```
- **မဖြစ်မနေ သိရမည့် Flags များ:**
  - `-d, --detach` : Background (daemon) အနေဖြင့် run ရန် (Terminal မပိတ်ဘဲ နောက်ကွယ်တွင် အလုပ်လုပ်နေစေရန်)
  - `-p, --publish` : Host Port နှင့် Container Port ကို ချိတ်ဆက်ရန် (ဥပမာ- `-p 8080:80`)
  - `--name` : Container အား မှတ်မိလွယ်သော နာမည်ပေးရန်
  - `-v, --volume` : Volume သို့မဟုတ် Bind mount ချိတ်ဆက်ရန် (ဥပမာ- `-v /host/path:/container/path`)
  - `-e, --env` : Environment Variable ပေးပို့ရန် (ဥပမာ- `-e APP_ENV=production`)
  - `--env-file` : `.env` file တစ်ခုလုံးကို တိုက်ရိုက် ထည့်သွင်းရန်
  - `--network` : Container အား မည်သည့် Docker Network ထဲ ထည့်မည်ကို သတ်မှတ်ရန်
  - `--restart` : Crash ဖြစ်ပါက သို့မဟုတ် Docker restart ဖြစ်ပါက အလိုအလျောက် ပြန် run စေရန် (ဥပမာ- `--restart unless-stopped`)
  - `-it` : Interactive terminal mode ဖြင့် bash/sh ထဲ ချက်ချင်း ဝင်ရောက်ရန်
  - `--rm` : Container ရပ်တန့် (Exit) သွားသည်နှင့် အလိုအလျောက် Container ကို ဖျက်ပစ်ရန်
- **Real-World Examples:**
  ```bash
  # Background Nginx container run ခြင်း
  docker run -d --name my-web-server -p 8080:80 nginx:alpine

  # MySQL Database container volume နှင့် root password ဖြင့် run ခြင်း
  docker run -d \
    --name mysql-db \
    -p 3306:3306 \
    -e MYSQL_ROOT_PASSWORD=secret \
    -e MYSQL_DATABASE=laravel_db \
    -v mysql_data:/var/lib/mysql \
    --restart unless-stopped \
    mysql:8.0

  # Interactive mode ဖြင့် Ubuntu container ထဲ ဝင်စမ်းခြင်း
  docker run --rm -it ubuntu:22.04 bash
  ```

---

### `docker start`, `docker stop`, `docker restart`
- **ရည်ရွယ်ချက်:**
  - `docker stop` : Run နေသော Container ကို Graceful shutdown (`SIGTERM`) ဖြင့် ပုံမှန် ရပ်တန့်ရန်။
  - `docker start` : Stopped ဖြစ်နေသော Container ကို ပြန်လည် Run ရန်။
  - `docker restart` : Container ကို ရပ်ပြီး ချက်ချင်း ပြန်ဖွင့်ရန်။
- **Real-World Example:**
  ```bash
  docker stop my-web-server
  docker start my-web-server
  docker restart my-web-server
  ```

---

### `docker pause` နှင့် `docker unpause`
- **ရည်ရွယ်ချက်:**
  - `docker pause` : Linux `cgroups freezer` ကို သုံး၍ Container ၏ Process အားလုံးကို ခေတ္တ အေးခဲ (Freeze) ထားရန် (CPU အသုံးမပြုတော့ဘဲ Memory ပေါ်တွင် အခြေအနေအတိုင်း တည်ရှိနေမည်)။
  - `docker unpause` : ခေတ္တရပ်ထားသော Container ကို ပြန်လည် ဆက်လက် လည်ပတ်စေရန်။
- **Real-World Example:**
  ```bash
  docker pause mysql-db
  docker unpause mysql-db
  ```

---

### `docker kill`
- **ရည်ရွယ်ချက်:** Container ကို Graceful shutdown မစောင့်တော့ဘဲ ချက်ချင်း ချက်ချင်း အင်အားသုံး ရပ်တန့်ရန် (`SIGKILL` ပို့သည်)။
- **Real-World Example:**
  ```bash
  docker kill stuck-container
  ```

---

### `docker rm`
- **ရည်ရွယ်ချက်:** ရပ်တန့်ထားသော (Stopped) Container များကို စက်ထဲမှ ဖျက်ပစ်ရန်။
- **Options:**
  - `-f, --force` : Run နေသော Container ကို အတင်းရပ်ပြီး ချက်ချင်း ဖျက်ရန်။
  - `-v` : Container နှင့် တွဲနေသော anonymous volume များကိုပါ ဖျက်ရန်။
- **Real-World Example:**
  ```bash
  docker rm my-web-server
  # Stopped container အားလုံး တစ်ပြိုင်နက် ဖျက်ခြင်း
  docker rm $(docker ps -a -q)
  ```

---

### `docker rename`
- **ရည်ရွယ်ချက်:** Container တစ်ခု၏ နာမည်ကို အသစ် ပြောင်းလဲရန်။
- **Real-World Example:**
  ```bash
  docker rename old-app-name new-app-name
  ```

---

### `docker update`
- **ရည်ရွယ်ချက်:** Run နေသော Container ၏ Resource limit (CPU, Memory, Restart policy) များကို Container မဖျက်ဘဲ Dynamic ပြင်ဆင်ရန်။
- **Real-World Example:**
  ```bash
  docker update --memory 1024m --cpus 1.5 my-web-server
  docker update --restart unless-stopped mysql-db
  ```

---

## 6. Docker Monitoring, Inspection & Debugging Commands

### `docker ps` နှင့် `docker ps -a`
- **ရည်ရွယ်ချက်:**
  - `docker ps` : လက်ရှိ Run နေသော (Active) Containers များကို ကြည့်ရန်။
  - `docker ps -a` : ရပ်တန့်နေသော (Stopped / Exited) Containers များအပါအဝင် အားလုံးကို ကြည့်ရန်။
- **Options:**
  - `-q` : Container IDs များကိုသာ ထုတ်ပြရန်။
  - `--filter "status=exited"` : Filter ဖြင့် ရှာဖွေရန်။
- **Real-World Example:**
  ```bash
  docker ps
  docker ps -a
  ```

---

### `docker inspect`
- **ရည်ရွယ်ချက်:** Container သို့မဟုတ် Image သို့မဟုတ် Volume သို့မဟုတ် Network ၏ Low-level configuration အချက်အလက်အားလုံး (IP Address, Mount paths, Env vars, State, MAC address) ကို JSON ဖြင့် အသေးစိတ် ကြည့်ရှုရန်။
- **Real-World Example:**
  ```bash
  # Container IP Address ကို တိုက်ရိုက် ထုတ်ယူခြင်း
  docker inspect --format='{{range .NetworkSettings.Networks}}{{.IPAddress}}{{end}}' my-web-server
  ```

---

### `docker stats`
- **ရည်ရွယ်ချက်:** Run နေသော Container များ၏ CPU %, Memory Usage, Memory %, Network I/O, Block I/O (Disk) တို့ကို Live Real-time Resource Monitor ပြသပေးသည်။
- **Real-World Example:**
  ```bash
  docker stats
  docker stats --no-stream # တစ်ကြိမ်သာ Snapshot ထုတ်ကြည့်ခြင်း
  ```

---

### `docker top`
- **ရည်ရွယ်ချက်:** Container တစ်ခုအတွင်း လည်ပတ်နေသော Linux OS level processes (PID, User, Command) များကို ကြည့်ရန်။
- **Real-World Example:**
  ```bash
  docker top my-web-server
  ```

---

### `docker port`
- **ရည်ရွယ်ချက်:** Container တစ်ခု၏ မည်သည့် Container Port သည် Host Machine ၏ မည်သည့် Port သို့ Map လုပ်ထားသည်ကို ကြည့်ရန်။
- **Real-World Example:**
  ```bash
  docker port my-web-server
  # Output ဥပမာ: 80/tcp -> 0.0.0.0:8080
  ```

---

### `docker diff`
- **ရည်ရွယ်ချက်:** Container စတင် run ချိန်မှစ၍ Container file system ထဲတွင် မည်သည့် file များ အသစ်ထည့်ထားသလဲ (A - Added)၊ မည်သည့် file ပြင်ထားသလဲ (C - Changed)၊ မည်သည့် file ဖျက်ထားသလဲ (D - Deleted) ကို စစ်ဆေးရန်။
- **Real-World Example:**
  ```bash
  docker diff my-web-server
  ```

---

### `docker events`
- **ရည်ရွယ်ချက်:** Docker Engine ပေါ်တွင် ဖြစ်ပျက်နေသော Real-time events များ (Container start, die, kill, volume attach စသည်) ကို Live စောင့်ကြည့်ရန်။
- **Real-World Example:**
  ```bash
  docker events
  ```

---

### `docker logs`
- **ရည်ရွယ်ချက်:** Container အတွင်းရှိ Application (Laravel, Nginx, MySQL စသည်) မှ ထွက်လာသော `stdout` နှင့် `stderr` logs များကို ကြည့်ရှုရန်။
- **အသုံးများသော Options:**
  - `-f, --follow` : Real-time streaming log ကြည့်ရန် (Live log tailing)
  - `--tail N` : နောက်ဆုံး N လိုင်းသာ ကြည့်ရန် (ဥပမာ- `--tail 100`)
  - `-t, --timestamps` : Log ထွက်သည့် အချိန် နာရီပါ ထည့်ပြရန်
- **Real-World Example:**
  ```bash
  docker logs -f --tail 50 my-web-server
  ```

---

## 7. Docker Execution, File Transfer & Import/Export

### `docker exec` (⭐️ Debugging တွင် အသုံးအများဆုံး)
- **ရည်ရွယ်ချက်:** လက်ရှိ Run နေသော Container အတွင်းသို့ ဝင်ရောက်ပြီး Command များ ရိုက်ထည့်ရန် (သို့မဟုတ် Bash Terminal ဖွင့်ရန်)။
- **Options:**
  - `-it` : Interactive Pseudo-TTY ဖွင့်ရန် (Terminal ဝင်ရန် မဖြစ်မနေ လိုသည်)
  - `-u, --user` : Root သို့မဟုတ် အခြား User အနေဖြင့် ဝင်ရန် (ဥပမာ- `-u www-data`)
- **Real-World Examples:**
  ```bash
  # Laravel Container အတွင်းသို့ Bash shell ဖြင့် ဝင်ရောက်ခြင်း
  docker exec -it my-laravel-app bash

  # Container အပြင်ဘက်မှနေ၍ Laravel Artisan command လှမ်း run ခြင်း
  docker exec -it my-laravel-app php artisan migrate --seed
  docker exec -it my-laravel-app php artisan cache:clear
  ```

---

### `docker attach`
- **ရည်ရွယ်ချက်:** Container ၏ Main Process (PID 1) ၏ Standard Input/Output သို့ တိုက်ရိုက် တွဲဆက် (attach) လုပ်ရန်။
- **သတိပြုရန်:** `Ctrl + C` နှိပ်လိုက်ပါက Container တစ်ခုလုံးပါ ရပ်တန့်သွားမည် ဖြစ်သည်။ (ထွက်လိုပါက `Ctrl + P`, `Ctrl + Q` တွဲနှိပ်ရသည်)။ Debugging အတွက် `docker exec` ကို ပို၍ အကြံပြုသည်။

---

### `docker cp`
- **ရည်ရွယ်ချက်:** Host Machine နှင့် Container ကြားတွင် File သို့မဟုတ် Folder များကို ကူးယူ (Copy) ရန်။
- **Syntax:**
  ```bash
  docker cp [OPTIONS] SRC_PATH DEST_PATH
  ```
- **Real-World Examples:**
  ```bash
  # Host မှ ဖိုင်ကို Container ထဲ ကူးထည့်ခြင်း
  docker cp ./default.conf my-nginx:/etc/nginx/conf.d/default.conf

  # Container ထဲမှ Laravel error log ကို Host စက်ထဲ ကူးထုတ်ခြင်း
  docker cp my-laravel-app:/var/www/html/storage/logs/laravel.log ./local-laravel.log
  ```

---

### `docker commit`
- **ရည်ရွယ်ချက်:** ပြင်ဆင်ပြောင်းလဲထားသော Container တစ်ခု၏ အခြေအနေကို Image အသစ်တစ်ခုအဖြစ် Save လုပ်ရန်။
- **Real-World Example:**
  ```bash
  docker commit -m "installed curl and vim" my-web-server my-custom-nginx:v1
  ```

---

### `docker export` နှင့် `docker import`
- **ရည်ရွယ်ချက်:**
  - `docker export` : Container တစ်ခုလုံး၏ File System အား tar file အဖြစ် ထုတ်ယူရန်။
  - `docker import` : ထို File System tar file မှ Image အဖြစ် ပြန်ပြောင်းရန်။
- **Real-World Example:**
  ```bash
  docker export my-laravel-app > laravel-container-fs.tar
  cat laravel-container-fs.tar | docker import - my-imported-laravel:v1
  ```

---

## 8. Docker Volume Management Commands

### `docker volume create`
- **ရည်ရွယ်ချက်:** Docker မှ စီမံခန့်ခွဲသော Persistent Named Storage Volume အသစ်တစ်ခု ဆောက်ရန်။
- **Syntax:**
  ```bash
  docker volume create [OPTIONS] [VOLUME_NAME]
  ```
- **Real-World Example:**
  ```bash
  docker volume create mysql_database_data
  ```

---

### `docker volume ls`
- **ရည်ရွယ်ချက်:** စက်ထဲရှိ Volume အားလုံးစာရင်းကို ကြည့်ရန်။
- **Real-World Example:**
  ```bash
  docker volume ls
  ```

---

### `docker volume inspect`
- **ရည်ရွယ်ချက်:** Volume ၏ အချက်အလက်များ၊ အထူးသဖြင့် Host Machine ၏ မည်သည့် Path (`Mountpoint`) တွင် တကယ် သိမ်းထားသည်ကို ကြည့်ရန်။
- **Real-World Example:**
  ```bash
  docker volume inspect mysql_database_data
  ```

---

### `docker volume rm`
- **ရည်ရွယ်ချက်:** အသုံးမလိုတော့သော Volume တစ်ခုကို ဖျက်ရန်။ (မည်သည့် Container ကမျှ သုံးမနေမှသာ ဖျက်၍ ရမည်)။
- **Real-World Example:**
  ```bash
  docker volume rm mysql_database_data
  ```

---

### `docker volume prune`
- **ရည်ရွယ်ချက်:** မည်သည့် Container ကမျှ ချိတ်ဆက် အသုံးမပြုတော့သော Volume (Dangling volumes) အားလုံးကို တစ်ခါတည်း အကုန်ရှင်းပစ်ရန်။
- **Real-World Example:**
  ```bash
  docker volume prune -f
  ```

---

## 9. Docker Network Management Commands

### `docker network create`
- **ရည်ရွယ်ချက်:** Container များ အချင်းချင်း Container Name ဖြင့် DNS resolution အသုံးပြုကာ ဆက်သွယ်နိုင်စေရန် Custom Network (Default: `bridge`) တစ်ခု တည်ဆောက်ရန်။
- **Syntax:**
  ```bash
  docker network create [OPTIONS] NETWORK_NAME
  ```
- **Options:**
  - `-d, --driver` : Network driver ရွေးရန် (`bridge`, `overlay`, `macvlan`)
- **Real-World Example:**
  ```bash
  docker network create laravel-network
  ```

---

### `docker network ls`
- **ရည်ရွယ်ချက်:** စက်ထဲရှိ Docker Networks စာရင်း အားလုံးကို ကြည့်ရှုရန်။
- **Real-World Example:**
  ```bash
  docker network ls
  ```

---

### `docker network inspect`
- **ရည်ရွယ်ချက်:** အဆိုပါ Network ထဲတွင် မည်သည့် Subnet, Gateway ရှိသလဲ၊ မည်သည့် Container များ ချိတ်ဆက်ထားပြီး IP address ဘယ်လောက် အသီးသီး ရရှိထားသလဲကို ကြည့်ရှုရန်။
- **Real-World Example:**
  ```bash
  docker network inspect laravel-network
  ```

---

### `docker network connect` နှင့် `docker network disconnect`
- **ရည်ရွယ်ချက်:** Run နေသော Container တစ်ခုကို Network အသစ်တစ်ခုထဲသို့ Dynamic ထည့်သွင်းခြင်း သို့မဟုတ် ချိတ်ဆက်မှု ဖြုတ်ပစ်ခြင်း။
- **Real-World Example:**
  ```bash
  # laravel-app ကို redis-network ထဲ ထပ်ချိတ်ခြင်း
  docker network connect redis-network my-laravel-app

  # ဖြုတ်ပစ်ခြင်း
  docker network disconnect redis-network my-laravel-app
  ```

---

### `docker network rm` နှင့် `docker network prune`
- **ရည်ရွယ်ချက်:**
  - `docker network rm` : အသုံးမပြုတော့သော Network တစ်ခုကို ဖျက်ရန်။
  - `docker network prune` : မည်သည့် Container မှ အသုံးမပြုတော့သော မလိုအပ်သည့် Networks အားလုံးကို ရှင်းပစ်ရန်။
- **Real-World Example:**
  ```bash
  docker network rm laravel-network
  docker network prune -f
  ```

---

## 10. Docker Compose Commands

Docker Compose သည် Multi-container applications (ဥပမာ- Nginx + Laravel PHP + MySQL + Redis) များကို `docker-compose.yml` ဖိုင်တစ်ခုတည်းဖြင့် တစ်ပြိုင်နက် စီမံခန့်ခွဲသည့် Tool ဖြစ်သည်။

### `docker compose version`
- **ရည်ရွယ်ချက်:** Docker Compose Plugin ၏ version ကို စစ်ဆေးရန်။
- **Real-World Example:**
  ```bash
  docker compose version
  ```

---

### `docker compose up` နှင့် `docker compose up -d`
- **ရည်ရွယ်ချက်:** `docker-compose.yml` ထဲရှိ Service အားလုံးကို Build လုပ်ခြင်း၊ Network/Volume များ ဆောက်ခြင်းနှင့် Container များကို စတင် Run ပေးခြင်း။
- **Options:**
  - `-d` : Detached mode (Background တွင် Run စေရန် - အသုံးအများဆုံး)
  - `--build` : Image များကို မဖြစ်မနေ အသစ် ပြန်လည် Rebuild လုပ်စေရန်
- **Real-World Example:**
  ```bash
  docker compose up -d
  docker compose up -d --build
  ```

---

### `docker compose down`
- **ရည်ရွယ်ချက်:** `docker compose up` ဖြင့် ဖွင့်ထားသော Containers, Networks များကို အကုန် ရပ်တန့်ပြီး ဖျက်သိမ်းပေးရန်။
- **Options:**
  - `-v, --volumes` : Compose ထဲတွင် ကြေညာထားသော Named Volumes များကိုပါ တစ်ခါတည်း ဖျက်ရန် (Database data အသစ် စတင်လိုသည့်အခါ သုံးသည်)။
- **Real-World Example:**
  ```bash
  docker compose down
  docker compose down -v
  ```

---

### `docker compose start`, `docker compose stop`, `docker compose restart`
- **ရည်ရွယ်ချက်:** Compose services များကို Container မဖျက်ဘဲ ခေတ္တ ရပ်တန့်ရန်၊ ပြန်လည် စတင်ရန် သို့မဟုတ် Restart ချရန်။
- **Real-World Example:**
  ```bash
  docker compose stop
  docker compose start
  docker compose restart php
  ```

---

### `docker compose ps`
- **ရည်ရွယ်ချက်:** လက်ရှိ Compose stack ထဲတွင် ပါဝင်သော Containers များ၏ အခြေအနေ၊ Ports များနှင့် Status ကို စစ်ဆေးရန်။
- **Real-World Example:**
  ```bash
  docker compose ps
  ```

---

### `docker compose logs` နှင့် `docker compose logs -f`
- **ရည်ရွယ်ချက်:** Compose stack ထဲရှိ Services အားလုံး၏ Logs များကို တပြိုင်နက်တည်း ကြည့်ရှုရန်။ Service နာမည် သတ်မှတ်ပေးပါက ထို Service တစ်ခုတည်း၏ Log ကို ကြည့်နိုင်သည်။
- **Real-World Example:**
  ```bash
  # Services အားလုံး၏ Log ကို Live စောင့်ကြည့်ခြင်း
  docker compose logs -f

  # PHP service log တစ်ခုတည်းကိုသာ ကြည့်ခြင်း
  docker compose logs -f php
  ```

---

### `docker compose exec`
- **ရည်ရွယ်ချက်:** Compose ထဲတွင် Run နေသော Service Container ထဲသို့ ဝင်ရောက် Command ရိုက်ရန်။
- **Real-World Example:**
  ```bash
  # Laravel App ထဲသို့ ဝင်ရောက်ပြီး migration run ခြင်း
  docker compose exec php php artisan migrate
  docker compose exec php composer install
  ```

---

### `docker compose run`
- **ရည်ရွယ်ချက်:** Service တစ်ခုအတွက် One-off (တစ်ကြိမ်တည်း သုံးမည့်) Task Container အသစ် run ရန် (ဥပမာ- Test run ခြင်း သို့မဟုတ် npm build လုပ်ခြင်း)။
- **Real-World Example:**
  ```bash
  docker compose run --rm node npm run build
  ```

---

### `docker compose build`
- **ရည်ရွယ်ချက်:** `docker-compose.yml` ထဲရှိ `build:` ပါဝင်သော Services များကို Image အဖြစ် Build လုပ်ရန်။
- **Options:**
  - `--no-cache` : Cache မသုံးဘဲ build ရန်။
- **Real-World Example:**
  ```bash
  docker compose build --no-cache
  ```

---

### `docker compose pull` နှင့် `docker compose push`
- **ရည်ရွယ်ချက်:** Compose ဖိုင်ထဲရှိ Service images များကို Registry မှ ကြိုတင် ဒေါင်းလုဒ် ဆွဲခြင်း သို့မဟုတ် Build ထားသော custom images များကို Registry သို့ Push လုပ်ခြင်း။
- **Real-World Example:**
  ```bash
  docker compose pull
  docker compose push
  ```

---

### `docker compose config`
- **ရည်ရွယ်ချက်:** `docker-compose.yml` ၏ Syntax မှန်ကန်မှု ရှိ/မရှိ စစ်ဆေးရန် (Validate) နှင့် Environment variables များ နေရာဝင်သွားပြီးနောက် နောက်ဆုံး ထွက်ပေါ်လာသော Compose configuration အပြည့်အစုံကို Preview ကြည့်ရန်။
- **Real-World Example:**
  ```bash
  docker compose config
  ```

---

### `docker compose images`
- **ရည်ရွယ်ချက်:** Compose services များက အသုံးပြုထားသော Docker Images များ၏ အမည်၊ Tag နှင့် Size တို့ကို ကြည့်ရန်။
- **Real-World Example:**
  ```bash
  docker compose images
  ```

---

### `docker compose top`
- **ရည်ရွယ်ချက်:** Compose Services များ အားလုံးထဲတွင် မည်သည့် OS level processes များ အလုပ်လုပ်နေသည်ကို ကြည့်ရန်။
- **Real-World Example:**
  ```bash
  docker compose top
  ```

---

### `docker compose cp`
- **ရည်ရွယ်ချက်:** Host machine နှင့် Compose service container တစ်ခုခုကြား File ကူးယူရန်။
- **Real-World Example:**
  ```bash
  docker compose cp ./my-file.sql mysql:/my-file.sql
  ```

---

### `docker compose rm` နှင့် `docker compose kill`
- **ရည်ရွယ်ချက်:**
  - `docker compose kill` : Compose services များကို အတင်းအဓမ္မ `SIGKILL` ဖြင့် ရပ်တန့်ရန်။
  - `docker compose rm` : ရပ်တန့်သွားသော Compose service containers များကို ဖျက်ရန်။
- **Real-World Example:**
  ```bash
  docker compose kill
  docker compose rm -f
  ```
