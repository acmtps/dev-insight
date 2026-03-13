# DevInsight

DevInsight is a GitHub analytics dashboard that generates insights about developer activity, repositories, and technology usage.

---

## Features

- GitHub API integration
- Repository analytics
- Language distribution
- Repository statistics
- Redis Caching
- Vue dashboard
- REST API

---

## Tech Stack

Backend
 - Laravel
 - Redis
 - GitHub REST API

 Frontend
  - Vue 3
  - Axios
  - Chart.js
  - TailwindCSS

## Architecture

```
Vue Dashboard
     │
Axios API
     │
Laravel API
     │
Service Layer
     │
GitHub API
     │
Redis Cache
```

---

## Installation

### Clone Repository

```bash
git clone https://github.com/acmtps/devinsight
cd devinsight
```

---


## Installation

### Clone Repository

```bash
git clone https://github.com/acmtps/dev-insight.git
cd dev-insight
```

---

### Install Backend

```bash
composer install
cp .env.example .env
php artisan key:generate
```

Add GitHub token to `.env`

```
GITHUB_TOKEN=your_token_here
```

---

### Start Redis

```bash
brew services start redis
```

---

### Run Backend

```bash
php artisan serve
```

---

### Install Frontend

```bash
cd devinsight-ui
npm install
npm run dev
```

---

## API Endpoint

```
GET /api/analyze/{username}
```

Example:

```
GET /api/analyze/acmtps
```

Response

```json
{
  "top_languages": {
    "PHP": 5,
    "Python": 1,
    "HTML": 1,
    "Blade": 1,
    "TypeScript": 1,
    "JavaScript": 1
  },
  "total_stars": 0,
  "total_forks": 0,
  "repos": 12
}
```

---

## Future Improvements

- GitHub GraphQL API integration
- Contribution heatmap
- Developer activity timeline
- Export analytics reports (PDF)
- Organization analytics
- Team insights dashboard

---



This project demonstrates:

- Laravel service architecture
- API integrations
- Redis caching
- asynchronous processing
- frontend data visualization