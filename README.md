
# Heating Service Management System

A web application designed to centralize and streamline daily operations in a heating and maintenance services company.

Originally developed as a collaborative academic project during the **BTS SIO SLAM** program, this application provides tools for managing service interventions, employees, schedules, spare parts, and company vehicles.

The system features role-based access control and dedicated interfaces for administrators, secretaries, and technicians.

## Features

### User Management

- Create, update, and manage user accounts.
- Assign administrator, secretary, or technician roles.
- Provide dedicated dashboards based on user permissions.
- Restrict access to administrative features.

### Intervention Management

- Create, view, update, and manage service interventions.
- Assign technicians and vehicles to interventions.
- Associate spare parts with service interventions.
- Allow technicians to add notes to their assigned interventions.
- Prevent conflicting technician or vehicle assignments at the same date and time.

### Scheduling & Calendar

- Dynamic intervention calendars powered by FullCalendar.
- Role-specific calendar views.
- Access intervention details directly from calendar events.
- Manage technician assignments and intervention planning.

### Inventory & Vehicle Management

- Create, view, update, and delete spare parts and inventory records.
- Manage company vehicles.
- Associate vehicles and resources with interventions.

### Security & Access Control

- User authentication.
- Role-based authorization.
- Protected routes and controllers.
- Restricted access to sensitive operations.
- Password hashing through Symfony Security.

## User Roles

| Role | Permissions |
|------|-------------|
| Administrator | Full access to users, interventions, inventory, vehicles, and scheduling |
| Secretary | Access to operational modules, excluding user administration |
| Technician | Access to assigned interventions and ability to add notes |

## Tech Stack

| Category | Technologies |
|----------|--------------|
| Backend | PHP 8.2+, Symfony 7.1 |
| Frontend | Twig, JavaScript, CSS |
| Database | PostgreSQL |
| ORM | Doctrine ORM |
| Scheduling | FullCalendar |
| Asset Management | Symfony AssetMapper, Stimulus, UX Turbo |
| Dependency Management | Composer |
| Development Tools | PhpStorm, Git |

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
git clone git@github.com:Maxiser00/heating-service-management.git
cd heating-service-management
```

**2. Install PHP dependencies**

```bash
composer install
```

**3. Configure environment variables**

Create a `.env.local` file in the project root.

Example configuration:

```dotenv
APP_ENV=dev
APP_SECRET=REPLACE_WITH_YOUR_OWN_RANDOM_SECRET
DATABASE_URL="postgresql://user:password@127.0.0.1:5432/heating_service?serverVersion=16&charset=utf8"
```

Replace the example credentials and PostgreSQL version with your local configuration.

Do not commit `.env.local` or any production credentials.

**4. Create the database**

```bash
php bin/console doctrine:database:create
```

**5. Run database migrations**

```bash
php bin/console doctrine:migrations:migrate
```

**6. Start the development server**

```bash
symfony server:start
```

Open the local URL provided by Symfony CLI.

### Initial Administrator Setup

An administrator account is required to access management features.

The initial account creation procedure has not yet been documented for this repository.

Do not deploy the application with predefined or publicly known administrator credentials.

## Screenshots

Screenshots of the application interface, dashboards, intervention management, and scheduling features will be added later.

## Project Background

This application was developed as a collaborative academic project during the **BTS Services Informatiques aux Organisations (SIO), option Solutions Logicielles et Applications Métier (SLAM)**.

The project provided practical experience in:

- Full-stack web development with Symfony.
- Relational database modeling and management.
- Authentication and role-based access control.
- Business-oriented application development.
- Collaborative development using Git.
- Interface design and dynamic scheduling.

## Contributors

This project was developed collaboratively by four contributors:

- **[Maxiser00](https://github.com/Maxiser00)** — Project contributor and repository maintainer.
- **Giovanny BRUNET** — Project contributor.
- **Contributor 01** — Project contributor.
- **Contributor 02** — Project contributor.

The original development history is preserved separately.

This repository is intended as a portfolio presentation of the collaborative project. The new Git history does not represent the original distribution of contributions.

## Project Status

**Academic project — development completed.**

The application is preserved as a portfolio project and may receive documentation updates, maintenance improvements, and technical enhancements.

## License

No open-source license is currently granted.

The project was developed collaboratively. Publication, distribution, and reuse of the source code remain subject to the rights of its contributors.
