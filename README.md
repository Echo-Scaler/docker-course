# 🐳 Complete Docker Course (အခြေခံမှ Intermediate/Advanced အဆင့်ထိ)

> **ကျွမ်းကျင် Docker Instructor တစ်ယောက်ကဲ့သို့ အသေးစိတ် မြန်မာလို လမ်းညွှန်ချက်**
> 
> အခြေခံ Concept များမှစ၍ Real-World PHP/Laravel Multi-Container Production အထိ လက်တွေ့ အသုံးချနိုင်အောင် စနစ်တကျ ရေးသားထားပါသည်။

---

## 📚 သင်ရိုးမာတိကာ (Course Table of Contents)

ဤ Course တွင် Docker နှင့် ပတ်သက်သော အရေးပါသည့် အကြောင်းအရာ ၃၀ အပြင် လက်တွေ့ အသုံးများဆုံး Docker CLI Commands နှင့် Docker Compose Commands များကို အသေးစိတ် ရှင်းလင်းထားပါသည်။

| အခန်း | သင်ခန်းစာခေါင်းစဉ် | အသေးစိတ် ပါဝင်သော အကြောင်းအရာများ |
| :--- | :--- | :--- |
| **00** | [Command Reference Guide](file:///Users/kyawwaiyan/Documents/my-Home-tech/Docker-Course/DOCKER-COMMANDS-REFERENCE.md) | CLI & Compose Commands အားလုံး၏ Syntax, Flags, Examples |
| **01** | [Docker Fundamentals & Architecture](file:///Users/kyawwaiyan/Documents/my-Home-tech/Docker-Course/01-docker-fundamentals-and-architecture.md) | Fundamentals, VM vs Docker, Architecture, Docker Engine, CLI Setup |
| **02** | [Images, Containers & Registries](file:///Users/kyawwaiyan/Documents/my-Home-tech/Docker-Course/02-images-containers-and-registries.md) | Layers, UnionFS, Tags, Container Writable Layer, Docker Hub |
| **03** | [Dockerfile & Image Building](file:///Users/kyawwaiyan/Documents/my-Home-tech/Docker-Course/03-dockerfile-and-building-images.md) | Dockerfile Instructions, Layer Caching, Multi-Stage Build, Buildx |
| **04** | [Storage: Volumes & Bind Mounts](file:///Users/kyawwaiyan/Documents/my-Home-tech/Docker-Course/04-storage-volumes-and-bind-mounts.md) | Data Persistence, Named Volumes, Bind Mounts, Permissions |
| **05** | [Networking, Ports & Environment](file:///Users/kyawwaiyan/Documents/my-Home-tech/Docker-Course/05-networking-ports-and-dns.md) | Bridge/Host/Overlay, Port Mapping, DNS, Env Variables, .env |
| **06** | [Docker Compose & Multi-Container](file:///Users/kyawwaiyan/Documents/my-Home-tech/Docker-Course/06-docker-compose-and-multi-container.md) | docker-compose.yml Structure, Services, Networks, Multi-Container |
| **07** | [PHP, Laravel, Nginx, MySQL & Redis](file:///Users/kyawwaiyan/Documents/my-Home-tech/Docker-Course/07-php-laravel-nginx-mysql-redis-stack.md) | PHP-FPM Extensions, Laravel Config, Nginx Reverse Proxy, MySQL, Redis |
| **08** | [Lifecycle, Debugging & Security](file:///Users/kyawwaiyan/Documents/my-Home-tech/Docker-Course/08-lifecycle-debugging-and-security.md) | Container States, Logs, Exec, Top, Stats, Non-root User, Security |
| **09** | [Workflow, Optimization & Best Practices](file:///Users/kyawwaiyan/Documents/my-Home-tech/Docker-Course/09-dev-workflow-production-optimization-best-practices.md) | Dev Workflow, Production Setup, Image Optimization, Best Practices |
| **10** | [Real-World Laravel Project Setup](file:///Users/kyawwaiyan/Documents/my-Home-tech/Docker-Course/10-real-world-laravel-docker-project.md) | အဆင်သင့် Run နိုင်သော Nginx + PHP 8.3 + MySQL + Redis + Mailpit Stack |
| **🚀 ADV** | [**Advanced Docker & Kubernetes (K8s)**](file:///Users/kyawwaiyan/Documents/my-Home-tech/Docker-Course/advanced-docker-kubernetes-production/README.md) | **DevOps Production Guide:** Kubernetes, Swarm, Ingress, PV/PVC, HPA, Helm, GitOps (ArgoCD & GitHub Actions), Monitoring |

---

## 🎯 သင်ယူသူများအတွက် လမ်းညွှန်ချက် (How to Follow This Course)

1. **စတင်လေ့လာသူများ (Beginners):**
   - [01-docker-fundamentals-and-architecture.md](file:///Users/kyawwaiyan/Documents/my-Home-tech/Docker-Course/01-docker-fundamentals-and-architecture.md) မှ စတင်ဖတ်ပါ။
   - Docker Container ဆိုတာဘာလဲ၊ Virtual Machine နဲ့ ဘယ်လိုကွာခြားလဲဆိုတာကို သေချာနားလည်အောင် အရင်လုပ်ပါ။
   - CLI command များကို လက်တွေ့ terminal တွင် ရိုက်ထည့်ပြီး စမ်းသပ်ကြည့်ပါ။

2. **Web/Laravel Developers:**
   - အခန်း ၃၊ ၄၊ ၅ တို့ကို အခြေခံပြီးနောက် [07-php-laravel-nginx-mysql-redis-stack.md](file:///Users/kyawwaiyan/Documents/my-Home-tech/Docker-Course/07-php-laravel-nginx-mysql-redis-stack.md) နှင့် [10-real-world-laravel-docker-project.md](file:///Users/kyawwaiyan/Documents/my-Home-tech/Docker-Course/10-real-world-laravel-docker-project.md) သို့ တိုက်ရိုက်သွားရောက် လေ့လာနိုင်ပါသည်။
   - လက်တွေ့ `laravel-docker-project` folder ထဲရှိ Configuration များကို Run ကြည့်နိုင်ပါသည်။

3. **DevOps & Production Engineers (Advanced):**
   - [advanced-docker-kubernetes-production/](file:///Users/kyawwaiyan/Documents/my-Home-tech/Docker-Course/advanced-docker-kubernetes-production/README.md) သို့ သွားရောက်၍ Multi-Node Clustering, Kubernetes Architecture, High Availability, GitOps CI/CD နှင့် Production Manifests များကို လေ့လာနိုင်ပါသည်။

4. **Quick Command Lookup:**
   - Command တိုင်း၏ flag များ၊ ရှင်းလင်းချက်များနှင့် ဥပမာများကို [DOCKER-COMMANDS-REFERENCE.md](file:///Users/kyawwaiyan/Documents/my-Home-tech/Docker-Course/DOCKER-COMMANDS-REFERENCE.md) တွင် အချိန်မရွေး ရှာဖွေကြည့်ရှုနိုင်ပါသည်။

---
*Ready to master Docker and Kubernetes? Let's get started!*

