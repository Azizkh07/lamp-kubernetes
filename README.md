# 🚀 LAMP Stack Deployment on Kubernetes

[![Kubernetes](https://img.shields.io/badge/Kubernetes-326CE5?style=for-the-badge&logo=kubernetes&logoColor=white)](https://kubernetes.io/)
[![Docker](https://img.shields.io/badge/Docker-2496ED?style=for-the-badge&logo=docker&logoColor=white)](https://docker.com/)
[![Apache](https://img.shields.io/badge/Apache-D22128?style=for-the-badge&logo=apache&logoColor=white)](https://httpd.apache.org/)
[![MySQL](https://img.shields. io/badge/MySQL-4479A1?style=for-the-badge&logo=mysql&logoColor=white)](https://www.mysql.com/)
[![PHP](https://img.shields.io/badge/PHP-777BB4? style=for-the-badge&logo=php&logoColor=white)](https://www.php.net/)

## 📋 Description

Déploiement complet d'une architecture **LAMP** (Linux, Apache, MySQL, PHP) conteneurisée, déployée et orchestrée sur **Kubernetes** avec une approche Cloud & DevOps moderne. 

Complete deployment of a containerized **LAMP** stack (Linux, Apache, MySQL, PHP) orchestrated on **Kubernetes** with a modern Cloud & DevOps approach. 

## ✨ Fonctionnalités / Features

- 🐳 **Conteneurisation Docker** complète de la stack LAMP
- ☸️ **Orchestration Kubernetes** avec déploiements et services
- 🔄 **Services ClusterIP & NodePort** pour la gestion du trafic
- 🧪 **Tests d'accessibilité interne** entre les composants
- 📦 **Publication des images Docker** sur Docker Hub
- 🎼 **Orchestration Docker Compose** pour le développement local
- 🔐 **Gestion des secrets** Kubernetes pour les credentials
- 📊 **Persistent Volumes** pour la persistance des données MySQL

## 🏗️ Architecture

```
┌─────────────────────────────────────────┐
│         Kubernetes Cluster              │
│                                         │
│  ┌──────────────┐   ┌───────────────┐ │
│  │   Apache     │   │    MySQL      │ │
│  │   + PHP      │◄──┤   Database    │ │
│  │  Deployment  │   │   Deployment  │ │
│  └──────┬───────┘   └───────┬───────┘ │
│         │                   │         │
│  ┌──────▼───────┐   ┌───────▼───────┐ │
│  │  NodePort    │   │   ClusterIP   │ │
│  │   Service    │   │    Service    │ │
│  └──────────────┘   └───────────────┘ │
│         │                             │
└─────────┼─────────────────────────────┘
          │
     ┌────▼────┐
     │  Users  │
     └─────────┘
```

## 🛠️ Technologies Utilisées / Technologies Used

- **Kubernetes** - Orchestration de conteneurs
- **Docker** - Conteneurisation
- **Apache HTTP Server** - Serveur web
- **MySQL** - Base de données relationnelle
- **PHP** - Langage de script côté serveur
- **Docker Compose** - Orchestration multi-conteneurs
- **kubectl** - CLI Kubernetes

## 📦 Prérequis / Prerequisites

- Docker Engine (>= 20.10)
- Kubernetes cluster (>= 1.24) ou Minikube
- kubectl CLI
- Docker Compose (>= 2.0)
- Compte Docker Hub (pour la publication d'images)

## 🚀 Installation et Déploiement

### 1️⃣ Cloner le repository

```bash
git clone https://github.com/Azizkh07/lamp-kubernetes.git
cd lamp-kubernetes
```

### 2️⃣ Configuration locale avec Docker Compose

```bash
# Démarrer l'environnement local
docker-compose up -d

# Vérifier les conteneurs
docker-compose ps

# Accéder à l'application
# http://localhost:8080
```

### 3️⃣ Déploiement sur Kubernetes

```bash
# Créer le namespace
kubectl create namespace lamp-stack

# Déployer MySQL
kubectl apply -f k8s/mysql-deployment.yaml
kubectl apply -f k8s/mysql-service.yaml

# Déployer Apache + PHP
kubectl apply -f k8s/apache-deployment.yaml
kubectl apply -f k8s/apache-service.yaml

# Vérifier les déploiements
kubectl get pods -n lamp-stack
kubectl get services -n lamp-stack
```

### 4️⃣ Tests d'accessibilité

```bash
# Tester la connexion à MySQL depuis un pod Apache
kubectl exec -it <apache-pod-name> -n lamp-stack -- mysql -h mysql-service -u root -p

# Tester l'application web
kubectl get svc apache-service -n lamp-stack
# Accéder via NodePort: http://<node-ip>:<node-port>
```

## 📁 Structure du Projet

```
lamp-kubernetes/
├── docker/
│   ├── apache/
│   │   ├── Dockerfile
│   │   └── apache-config.conf
│   └── mysql/
│       └── Dockerfile
├── k8s/
│   ├── mysql-deployment.yaml
│   ├── mysql-service.yaml
│   ├── mysql-pv.yaml
│   ├── mysql-pvc.yaml
│   ├── apache-deployment.yaml
│   ├── apache-service.yaml
│   └── secrets. yaml
├── app/
│   ├── index.php
│   └── db-test.php
├── docker-compose.yml
└── README.md
```

## 🧪 Tests

### Test de connexion MySQL

```bash
# Depuis un pod Apache
kubectl exec -it <apache-pod> -n lamp-stack -- php /var/www/html/db-test.php
```

### Test de l'application web

```bash
# Obtenir l'URL du service
minikube service apache-service -n lamp-stack --url
# ou
kubectl port-forward svc/apache-service 8080:80 -n lamp-stack
```

## 📤 Publication des Images Docker

```bash
# Se connecter à Docker Hub
docker login

# Taguer les images
docker tag lamp-apache:latest Azizkh07/lamp-apache:v1.0
docker tag lamp-mysql:latest Azizkh07/lamp-mysql:v1.0

# Publier les images
docker push Azizkh07/lamp-apache:v1.0
docker push Azizkh07/lamp-mysql:v1.0
```

## 🔧 Configuration

### Variables d'environnement MySQL

```yaml
MYSQL_ROOT_PASSWORD: your_password
MYSQL_DATABASE: lamp_db
MYSQL_USER: lamp_user
MYSQL_PASSWORD: user_password
```

### Configuration Apache

- Port: 80 (interne), 30080 (NodePort)
- Document Root: `/var/www/html`
- PHP Version: 8.x

## 📊 Monitoring

```bash
# Surveiller les pods
kubectl get pods -n lamp-stack -w

# Logs Apache
kubectl logs -f <apache-pod> -n lamp-stack

# Logs MySQL
kubectl logs -f <mysql-pod> -n lamp-stack
```

## 🐛 Troubleshooting

### Le pod MySQL ne démarre pas

```bash
# Vérifier les logs
kubectl logs <mysql-pod> -n lamp-stack

# Vérifier les persistent volumes
kubectl get pv,pvc -n lamp-stack
```

### Impossible d'accéder à l'application

```bash
# Vérifier les services
kubectl get svc -n lamp-stack

# Vérifier les endpoints
kubectl get endpoints -n lamp-stack
```

## 🤝 Contributions

Les contributions sont les bienvenues! N'hésitez pas à ouvrir une issue ou une pull request.

1. Fork le projet
2. Créez votre branche (`git checkout -b feature/AmazingFeature`)
3.  Committez vos changements (`git commit -m 'Add some AmazingFeature'`)
4.  Push vers la branche (`git push origin feature/AmazingFeature`)
5. Ouvrez une Pull Request

## 📝 License

Ce projet est sous licence MIT - voir le fichier [LICENSE](LICENSE) pour plus de détails.

## 👤 Auteur

**Aziz**

- GitHub: [@Azizkh07](https://github.com/Azizkh07)
## 🙏 Remerciements

- Documentation Kubernetes officielle
- Communauté Docker
- Contributeurs open source

---

⭐ Si ce projet vous a aidé, n'hésitez pas à lui donner une étoile! 
```
