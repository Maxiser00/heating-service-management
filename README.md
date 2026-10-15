
# Heating Service Management System

A web application designed to centralize and simplify the daily operations of a heating and maintenance services company.

Originally developed as a collaborative academic project during the **BTS SIO SLAM** program, this application provides tools for managing service interventions, employees, schedules, spare parts, and company vehicles.

The application features role-based access control with dedicated interfaces for administrators, secretaries, and heating technicians.

## Features

### User Management
- Create, view, update, and delete user accounts.
- Assign administrator, secretary, or technician roles.
- Access dedicated dashboards based on user permissions.
- Securely hash user passwords.
- Update user information without requiring a password change.

### Intervention Management
- Create, view, update, and delete service interventions.
- Assign technicians and vehicles to interventions.
- Associate spare parts with interventions.
- Manage intervention statuses and descriptions.
- Allow technicians to view their assigned interventions and add notes.
- Prevent identical-time assignments for the same technician or vehicle.

### Scheduling & Calendar
- Interactive intervention calendars powered by FullCalendar.
- Role-specific calendar views.
- Access intervention details directly from calendar events.
- Visualize upcoming and completed interventions.

### Inventory & Vehicle Management
- Manage spare parts and inventory records.
- Manage company vehicles.
- Associate vehicles and spare parts with interventions.
- Manage fault categories and technician skills.

### Security & Access Control
- User authentication through Symfony Security.
- Role-based authorization.
- Protected controllers and routes.
- Restricted access to administrative operations.
- CSRF protection for supported forms and deletion operations.

## User Roles

| Role | Permissions |
|------|-------------|
| Administrator | Manage users, interventions, inventory, vehicles, faults, skills, and scheduling |
| Secretary | Manage operational resources and interventions without user administration privileges |
| Technician | View assigned interventions, consult their schedule, and add intervention notes |

## Tech Stack

| Category | Technologies |
|----------|--------------|
| Backend | PHP 8.2+, Symfony 7.1 |
| Frontend | Twig, JavaScript, CSS |
| Database | PostgreSQL |
| ORM | Doctrine ORM |
| Calendar | FullCalendar |
| Asset Management | Symfony AssetMapper, Stimulus, UX Turbo |
| Dependency Management | Composer |
| Version Control | Git, GitHub |

## Getting Started

### Prerequisites

Make sure the following tools are installed:

- PHP 8.2 or higher
- Composer
- PostgreSQL
- Symfony CLI (recommended)
- Required PHP extensions for Symfony and Doctrine

### Installation

**1. Clone the repository**

```bash
git clone https://github.com/Maxiser00/heating-service-management.git
cd heating-service-management
```

**2. Install PHP dependencies**

```bash
composer install
```

**3. Install frontend dependencies**

```bash
php bin/console importmap:install
```

**4. Configure environment variables**

Create a `.env.local` file in the project root:

```dotenv
APP_ENV=dev
APP_SECRET=REPLACE_WITH_YOUR_OWN_RANDOM_SECRET
DATABASE_URL="postgresql://user:password@127.0.0.1:5432/heating_service?serverVersion=16&charset=utf8"
```

Replace the database credentials, PostgreSQL version, and application secret with values appropriate for your local environment.

Never commit `.env.local` or production credentials.

**5. Create the database**

```bash
php bin/console doctrine:database:create
```

**6. Run database migrations**

```bash
php bin/console doctrine:migrations:migrate --no-interaction
```

**7. Start the development server**

```bash
symfony server:start
```

Open the local URL displayed by Symfony CLI.

## Demo Database

A fictional dataset is included to make the application easier to explore and evaluate.

The demonstration data includes:

- 1 administrator
- 2 secretaries
- 4 heating technicians
- 5 technician skills
- 5 fault categories
- 4 company vehicles
- 8 spare part references
- 12 service interventions
- Technician-skill and intervention-stock associations

### Import Demo Data

After creating the database and running the migrations, execute:

```bash
php bin/console app:import-demo --force
```

The command is intended exclusively for a fresh, disposable development database.

**Warning:** Do not run the demonstration import against a production database or a database containing important information.

### Demo Accounts

| Role | Email |
|------|-------|
| Administrator | admin@demo.local |
| Secretary | secretaire1@demo.local |
| Secretary | secretaire2@demo.local |
| Technician | chauffagiste1@demo.local |
| Technician | chauffagiste2@demo.local |
| Technician | chauffagiste3@demo.local |
| Technician | chauffagiste4@demo.local |

All demonstration accounts are intended for local testing only.

The SQL seed contains password hashes. Use the corresponding demonstration credentials configured for your local dataset.

Never reuse demonstration credentials in a public deployment.

## Administrator Setup

An administrator account can also be created manually using the Symfony console command:

```bash
php bin/console app:create-admin
```

The command interactively requests:

- Email address
- First name
- Last name
- Birth date
- Phone number
- Password

Passwords are entered without being displayed and are securely hashed using Symfony's password hasher.

This command is particularly useful when setting up the application without importing demonstration data.

## Project Structure

```text
assets/                  Frontend JavaScript and CSS
config/                  Symfony configuration
migrations/              Doctrine database migrations
public/                  Public application entry point
src/
  Command/               Console commands
  Controller/            Application controllers
  Entity/                Doctrine entities
  Form/                  Symfony forms
templates/               Twig templates
heating_demo_seed.sql    Fictional demonstration dataset
importmap.php            Frontend dependency configuration
composer.json            PHP dependency configuration
```

## Screenshots

Screenshots of the application will be added to illustrate:

- Authentication
- Administrator dashboard
- Secretary dashboard
- Technician dashboard
- Intervention management
- Interactive calendar
- Inventory and vehicle management

## Project Background

This application was developed collaboratively as part of the **BTS Services Informatiques aux Organisations (SIO), option Solutions Logicielles et Applications Métier (SLAM)**.

The project provided practical experience in:

- Full-stack web development with Symfony
- Relational database design and management
- Authentication and role-based access control
- Business-oriented application development
- Collaborative development using Git
- Interface design and dynamic scheduling

## Contributors

This project was developed collaboratively by four contributors:

- **[Maxiser00](https://github.com/Maxiser00)** — Project contributor and repository maintainer
- **Giovanny BRUNET** — Project contributor
- **Contributor 01** — Project contributor
- **Contributor 02** — Project contributor

The original development history is preserved separately.

This repository serves as a portfolio presentation of the collaborative project. Its current Git history does not represent the original distribution of contributions.

## Project Status

**Academic project — initial development completed.**

The application is maintained as a portfolio project and may receive documentation updates, bug fixes, and technical improvements.

The demonstration environment has been configured and role-based authentication has been tested. Comprehensive automated and functional testing has not yet been completed.

## License

No open-source license is currently granted.

This project was developed collaboratively. Publication, distribution, and reuse of the source code remain subject to the rights of its contributors.
