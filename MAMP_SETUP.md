# Run Otoku Circle With MAMP

## 1. Put the project in MAMP htdocs

Recommended folder:

```text
C:\MAMP\htdocs\otoku-circle
```

The page URL will be:

```text
http://localhost/otoku-circle/
```

If your MAMP Apache port is `8888`, use:

```text
http://localhost:8888/otoku-circle/
```

## 2. Start MAMP

Open MAMP and start:

- Apache
- MySQL

## 3. Open phpMyAdmin

Common URL:

```text
http://localhost/phpMyAdmin/
```

If your MAMP port is `8888`:

```text
http://localhost:8888/phpMyAdmin/
```

## 4. Import the database

In phpMyAdmin:

1. Open the `Import` tab.
2. Choose `database.sql`.
3. Click `Go`.

This creates:

- Database: `otoku_circle`
- Table: `users`
- Table: `stores`

## 5. Check database config

Open:

```text
includes/config.php
```

Default MAMP settings in this project:

```php
const DB_HOST = "127.0.0.1";
const DB_NAME = "otoku_circle";
const DB_USER = "root";
const DB_PASS = "root";
```

If your MAMP MySQL password is different, change `DB_PASS`.

## 6. Open setup check

Open:

```text
http://localhost/otoku-circle/setup_check.php
```

or:

```text
http://localhost:8888/otoku-circle/setup_check.php
```

Everything should show green.

## 7. Test the app

Open:

```text
http://localhost/otoku-circle/index.php
```

Test these pages:

- `register.php`
- `login.php`
- `profile.php`
- `nearby.php`
- `create_store.php`
- `create.php`

## Current working features

- UI pages
- Dark/light mode
- Register
- Login
- Logout
- Community place creation
- Community places fallback data

## Not finished yet

- Real post database
- Real image upload
- Comments database
- Likes/bookmarks
- Notifications database
