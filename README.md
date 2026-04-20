# SmartSeason Field Monitoring System

A full-stack web application for tracking crop progress across multiple fields during a growing season.

Built with **Laravel 11**, **Livewire 3**, **Tailwind CSS**, and **PostgreSQL**.

---

## Tech Stack

| Layer      | Technology                      |
|------------|---------------------------------|
| Backend    | Laravel 11                      |
| Frontend   | Livewire 3 + Volt               |
| Styling    | Tailwind CSS v4                 |
| Database   | PostgreSQL                      |
| Auth       | Laravel Breeze (Livewire stack) |

---

## Setup Instructions

### 1. Prerequisites

- PHP 8.2+ with extensions: `pgsql`, `pdo_pgsql`, `mbstring`, `xml`, `curl`
- Composer
- Node.js 18+
- PostgreSQL

### 2. Install PHP PostgreSQL extension (if not installed)

```bash
sudo apt-get install php8.4-pgsql
```

### 3. Clone and install dependencies

```bash
git clone <repo-url> SmartSeason-FMS
cd SmartSeason-FMS
composer install
npm install
```

### 4. Configure environment

```bash
cp .env.example .env
php artisan key:generate
```

Edit `.env` and set your PostgreSQL credentials:

```env
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=smartseason-fms
DB_USERNAME=your_pg_user
DB_PASSWORD=your_pg_password
```

### 5. Create the database

```bash
psql -U your_pg_user -d postgres
```

```sql
ALTER DATABASE template1 REFRESH COLLATION VERSION; -- fix collation mismatch if needed
CREATE DATABASE "smartseason-fms";
\q
```

### 6. Run migrations and seed demo data

```bash
php artisan migrate
php artisan db:seed
```

### 7. Build frontend assets

```bash
npm run build
# or for development with hot reload:
npm run dev
```

### 8. Start the development server

```bash
php artisan serve
```

Visit: **http://localhost:8000**

---

## Demo Credentials

| Role        | Email                     | Password |
|-------------|---------------------------|----------|
| Admin       | admin@smartseason.com     | password |
| Field Agent | agent1@smartseason.com    | password |
| Field Agent | agent2@smartseason.com    | password |

---

## Design Decisions

### Architecture
- **Monorepo**: Single Laravel application handles backend logic and frontend rendering via Livewire — no separate API or SPA needed.
- **Livewire 3**: Reactive components with zero JavaScript. Class-based components in `app/Livewire/` with matching Blade views in `resources/views/livewire/`.
- **Role-based middleware**: Two custom middleware classes (`EnsureAdmin`, `EnsureAgent`) applied at the route group level, keeping route definitions clean.
- **PHP Enums**: Backed enums (`FieldStage`, `FieldStatus`, `UserRole`) provide type safety and centralize label/color/badge logic.

### Field Status Logic

Status is **computed at runtime** via a model accessor on `Field`:

| Condition | Status |
|---|---|
| `stage === 'harvested'` | **Completed** |
| Any observation has `is_risk_flag = true` (and not harvested) | **At Risk** |
| All others | **Active** |

The `is_risk_flag` is set by Field Agents when submitting observations. This approach was chosen because:
- It is **explicit** — agents consciously flag risk, reducing false positives from automated time-based rules.
- It is **auditable** — the risk flag lives on the observation record with a timestamp and author.
- A time-based rule (e.g. "no stage change in 30 days") could be added as a complementary signal later.

### Role Separation

- **Admin**: Full visibility of all fields and agents. Can create/edit fields and assign them to agents. Sees an activity feed of all recent observations.
- **Field Agent**: Sees only their assigned fields. Can update the crop stage and log observations, with an optional risk flag.

---

## Assumptions

1. A field is assigned to **one agent** at a time.
2. **Any admin** can create or edit any field — there is no per-admin ownership.
3. Registration is open (any user can register with either role). In production, admin registration would be invite-gated.
4. The risk flag is **additive** — once raised on an observation it stays in history. The status only clears when the field is marked Harvested. A "resolve risk" action could be added in a future iteration.
5. Pagination is applied on the admin fields list. Agent dashboard shows all assigned fields (typically a small set).
