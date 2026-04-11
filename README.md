# AWP Server-side home assignment - Phase 2

## Video link

[Student name (neptun code) video](https://)

## Statement

Student's name: ....
Student's Neptun code: ....

This solution was submitted and created by the student named above 
for the "Server-side home assignment" assessment of the Advanced web programming 
course.

I hereby declare that this solution is my own work. 
I have not copied or used solutions from third parties. 
I did not forward my solution to other students, nor did I publish it anywhere. 
I understand that According to Section Section 377/A of ELTE Academic Regulations 
for Students, I will not be able complete the subject if I use an any disallowed 
aid or provide unauthorised assistance to another student.

ELTE Academic Regulations for Students, Regulations on the Faculty of Informatics, 
Section 377/A: "A student who uses aids other than those specified by the instructor 
or provides unauthorised assistance to another student during an evaluation 
(exam, test, homework assignment) requiring the preparation of a computer programme 
or programme module is in violation of the academic rules, and shall not be 
permitted to complete the subject in the given semester and therefore shall not 
obtain the credit awarded for the subject."

Budapest, 2026

## Project Requirements – Checklist

### Database Requirements

- [x] At least 5 database tables with meaningful relationships and clear responsibilities
  - `users`, `properties`, `apartments`, `leases`, `maintenance_requests`
- [x] At least one 1‑to‑N (one‑to‑many) relationship implemented and actively used
  - `properties` → `apartments` (one property has many apartments)
- [x] At least one N‑to‑N (many‑to‑many) relationship with a proper pivot table
  - `users` ↔ `apartments` via `leases` (a tenant can lease many apartments over time, an apartment can have many tenants over time)
- [x] Consistent use of primary keys, foreign keys, and unique constraints
  - All tables use `id` as primary key; `leases` has `tenant_id` and `apartment_id` as foreign keys
- [x] At least one table with 10 or more fields (complex data modeling)
  - `users`: id, name, email, password, role, is_active, phone, avatar, email_verified_at, created_at, updated_at (11 fields)
  - `apartments`: id, property_id, unit_number, floor, rent_amount, bedrooms, bathrooms, size_sqm, has_parking, is_available, status, created_at, updated_at (13 fields)
- [x] Schema must include various data types:
  - [x] integer — `floor`, `bedrooms`, `bathrooms`
  - [x] boolean — `is_active`, `has_parking`, `is_available`
  - [x] enum — `role` (admin/owner/tenant), `status` (available/occupied/maintenance), `priority` (low/medium/high/urgent)
  - [x] timestamp — `created_at`, `updated_at` on all tables, `resolved_at` on maintenance_requests
  - [x] date — `start_date`, `end_date` on leases

### Frontend Pages

- [x] Responsive, visually appealing UI (usable on desktop and mobile)
  - Tailwind CSS used throughout with responsive grid layouts
- [x] Use of a component library (Bootstrap, Tailwind, Flowbite, etc.)
  - Tailwind CSS via Laravel Breeze scaffolding
- [x] At least 10 distinct pages with unique functionality or content
  1. Login page
  2. Register page
  3. Admin dashboard
  4. Owner dashboard
  5. Tenant dashboard
  6. Properties index
  7. Property create/edit
  8. Apartments index (per property)
  9. Apartment create/edit
  10. Leases index
  11. Lease create
  12. Lease edit/show
  13. Maintenance requests index
  14. Maintenance request create
  15. Maintenance request edit
  16. Admin user management
  17. Tenant apartment detail view

### CRUD Functionality

- [x] CRUD implemented for an entity on the "N" side of a one‑to‑many relationship
  - `Apartment` belongs to `Property` (N side of 1-to-N) — full CRUD implemented
- [x] CRUD implemented for an entity on the "N" side of a many‑to‑many relationship
  - `Lease` connects `users` and `apartments` (pivot/N side of N-to-N) — full CRUD implemented
- [x] Forms must include multiple input types:
  - [x] Checkbox list — apartment create/edit form (`has_parking`, `is_available`)
  - [x] Radio buttons — maintenance request form (`priority`: low/medium/high/urgent)
  - [x] Select dropdown — lease create form (tenant selector, apartment selector)
  - [x] File upload component — maintenance request form (issue photo upload)

### Authentication & Authorization

- [x] Full authentication and authorization using Laravel's built‑in tools
  - Laravel Breeze handles login, register, logout, password hashing
- [x] Logged‑in users cannot access protected data belonging to other users
  - Tenants only see their own leases and maintenance requests
  - Owners only see their own properties and apartments
- [x] Sensitive actions must be controlled by roles or permissions
  - Custom `RoleMiddleware` enforces `admin`, `owner`, `tenant` role separation
  - Properties and leases routes protected by `role:owner,admin` middleware
  - Admin user management protected by `role:admin` middleware

### Admin Interfaces

- [x] Administrator user‑management page(s)
  - `/admin/users` — lists all users, allows role changes via dropdown
- [x] Full CRUD management for at least one non‑user entity
  - Full CRUD for `Properties`, `Apartments`, `Leases`, `MaintenanceRequests`

### Technology Requirements

- [x] Laravel
  - Laravel 13
- [x] Laravel Breeze for authentication scaffolding
  - Installed with Blade stack
- [x] SQLite as the database engine
  - Configured in `.env` with `DB_CONNECTION=sqlite`