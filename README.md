# The Leads School — Website & Admin Panel

The official website and admin panel for **Leads School System**, Shahpur Sadar, Sargodha, Pakistan. Built with PHP, MySQL, HTML5, CSS3, and JavaScript.

Live site: [theleadschoolshahpur.com](https://theleadschoolshahpur.com/)

## Features

### Public Website
- Responsive design (desktop, tablet, mobile)
- Home, About, Mission & Vision, Core Values, Leadership
- Academics: Courses, Faculty, Examination results
- Admission: online application form, downloads, notifications
- Student Life: Events, News
- Photo Gallery with admin-editable categories
- Contact page with map and inquiry form

### Admin Panel (`/AdminCP`)
- Password-protected login (hashed passwords)
- Dashboard with site statistics
- Manage: Home page content, About page, Academics (courses/faculty/exams), Admissions, Contact & campus info, Gallery & categories, Student life (events/news)
- Theme Manager — site-wide brand colors and logo, editable without touching code
- Site Settings — name, contact info, social links, footer content
- Analytics tracking for page views

## Tech Stack
- **Backend:** PHP 8+, MySQLi
- **Frontend:** HTML5, CSS3 (custom, CSS-variable-based theme system), vanilla JavaScript
- **Icons:** Font Awesome 6.4
- **Database:** MySQL/MariaDB

## Local Setup (XAMPP)

1. Clone/copy this repo into `htdocs/theleadschoolshahpur/`
2. Create a MySQL database and import `theleadschool.sql`
3. Check `includes/config.php` matches your local DB credentials (`DB_HOST`, `DB_USER`, `DB_PASS`, `DB_NAME`)
4. Ensure these folders are writable: `uploads/`, `images/logos/`, `images/hero/`, `images/faculty/`, `images/leadership/`
5. Visit `http://localhost/theleadschoolshahpur/` for the site, `http://localhost/theleadschoolshahpur/AdminCP/login.php` for the admin panel

Admin credentials are stored (hashed) in the `admin_users` table — there is no default password baked into the code.

## Deployment

This repo includes a `.cpanel.yml` for cPanel's Git Version Control deployment feature. On push, it copies the repo contents into the configured document root — see the comments in that file to point it at the right domain path.

`*.sql` files are blocked from direct web access via `.htaccess`, but the live database still needs to be created/imported manually through phpMyAdmin (or similar) on first deploy — the deployment step does not do this automatically.

## Project Structure

```
theleadschoolshahpur/
├── AdminCP/              # Admin panel (login-protected)
├── css/                  # Stylesheet (style.css — brand tokens in :root)
├── js/                   # Front-end JavaScript
├── includes/             # Shared PHP: config, header, footer, helpers
├── images/, uploads/     # Media (logos, hero images, faculty/leadership photos, uploads)
├── *.php                 # Public pages (index, about, courses, admission, etc.)
└── theleadschool.sql     # Database schema + seed data
```

## Notes

- The `settings` table drives most editable site text (site name, contact info, hero content, page headers, CTAs) via `includes/settings_helper.php` — most copy changes should go through AdminCP rather than editing PHP files directly.
- Brand colors are CSS variables in `css/style.css`, also editable live via AdminCP → Theme Manager.
