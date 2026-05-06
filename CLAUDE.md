# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

Ladybird School Management Information System (SMIS) — a PHP/MySQL multi-tenant school management web app. It serves as both a public marketing site (`index.php`) and a backend system for school administration (academics, finance, admissions, boarding, SMS, timetable generation).

## Running Locally

The project runs under LAMPP (Apache + MySQL + PHP). No build step required.

```bash
# Start LAMPP
sudo /opt/lampp/lamppctl start

# Access the app
http://localhost/landsims
```

Database is MariaDB 10.4 with PHP 8.1. The central database is `ladybird_smis`. Each school gets its own database (e.g., `722123456_db`).

## Architecture

### Dual-Database Model

This is the most important architectural concept. There are always two database connections:

- **`conn1.php`** — connects to `ladybird_smis` (central DB): stores `user_tbl`, `school_information` (cross-school auth and school registry)
- **`conn2.php`** — connects to the school-specific database (name stored in `$_SESSION['databasename']`): stores all school data (classes, subjects, fees, students, etc.)
- **`mpesaConn.php`** — like conn2 but reads the DB name from a local `$dbnamed` variable instead of session

When registering a new school, a new database is created dynamically and seeded from `ajax/login/db_create.sql`.

### Request Flow

1. User hits a page (e.g., `index.php`, `timetable-generator.php`)
2. Frontend JS in `assets/JS/*.js` makes AJAX GET/POST requests to `ajax/` endpoints
3. Each `ajax/` endpoint includes the appropriate connection file, queries the DB, and echoes HTML or pipe-delimited strings back to the client
4. JS parses the response and updates the DOM

There is no JSON API — responses are typically raw HTML fragments or `|`-delimited strings.

### AJAX Endpoints

Each module has its own PHP file under `ajax/`:

| Module | Endpoint |
|---|---|
| Login / auth | `ajax/login/login.php` |
| Account creation | `ajax/login/login.php` (POST) |
| Email verification | `ajax/login/verify_email.php` |
| Academics | `ajax/academic/academic.php` |
| Finance / fees | `ajax/finance/financial.php` |
| M-Pesa payments | `ajax/finance/school_Mpesa.php` |
| Admissions | `ajax/administration/admissions.php` |
| Boarding | `ajax/boarding/boarding.php` |
| SMS | `ajax/sms/sms.php` |
| Notices | `ajax/notices/notices.php` |
| Profile image | `ajax/image_upload/change_dp.php`, `change_sch_dp.php` |
| Public contact form | `ajax/outer/rqst_user.php` |

### User Roles (`auth` column in `user_tbl`)

| Value | Role |
|---|---|
| 0 | Admin |
| 1 | Headteacher |
| 2 | Teacher |
| 3 | Deputy Principal |
| 4 | Staff |
| 5 | Class Teacher |
| 6 | Student |

Admins (0) and Headteachers (1) can log in at any time. All other roles are restricted by configurable active hours stored in `school_information.from_time` / `to_time`.

### Password Encryption

Passwords are NOT hashed with bcrypt. A custom substitution cipher is used — `encryptCode()` / `decryptCode()` in `assets/encrypt/encrypt.php`. Every 4-character block maps to one plaintext character.

### Session Keys

After login, these session keys are set and used across all pages:
- `$_SESSION['databasename']` — school-specific DB name (used by conn2)
- `$_SESSION['schcode']` — school code (derived from phone number: `substr($phone, 2)`)
- `$_SESSION['authority']` — user role integer
- `$_SESSION['userids']` — user ID

### Third-Party Dependencies (all vendored, no Composer)

- **PHPMailer** — `ajax/login/phpmailer/` — SMTP via `mail.privateemail.com:587`
- **FPDF 1.84** — `assets/fpdf184/` — PDF generation
- **Cloudflare Turnstile** — bot protection on public forms (secret key in `login.php`)
- **Bootstrap 5** + vendor CSS/JS — `assets/vendor/`

## Key Patterns

- All DB queries use MySQLi prepared statements with `bind_param`.
- `conn2.php` echoes a debug line (`echo $_SESSION['databasename']."<br>"`) that should be removed in production.
- School code is derived as `substr($phone_number, 2)` — strips the country code prefix.
- The `comma.php` file (included by financial.php) is in the project root — look there for shared formatting utilities.
