# Project Name

> BeMo Help Desk

---

## Installation and Setup

### 1. Clone the repository

```bash
git https://github.com/RKB271189/BeMo-HelpDesk-Ticket-App.git
cd project-name
```

### 2. Run commands

```bash
composer install
cp .env.example .env


npm install
npm run build
or 
npm run dev
```

### 3. Update .env and run artisan command

```bash

OPENAI_API_KEY=
OPENAI_ORGANIZATION=

php artisan key:generate

php artisan migrate
php artisan db:seed

php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### 4. Change vite.config.js

```bash  
"/api": "http://localhost:8080", ## change this as needed
````
