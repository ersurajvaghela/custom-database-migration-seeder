# custom-database-migration-seeder

This repository provides a tiny, framework-free PHP migration + seeder utility.
It demonstrates simple migration and seeder scripts using PDO and plain SQL files.

**Prerequisites**
- **PHP**: CLI PHP installed (7.4+ recommended).
- **PDO** extension**:** PDO and the PDO driver for your database (the example uses MySQL).
- **Database**: A running MySQL server (or change DSN in `db.php`).

**Files**
- `db.php`: Database connection (edit DSN, user, password for your environment).
- `migrate.php`: Scans `migrations/`, applies not-yet-applied migrations and records them in the `migrations` table.
- `rollback.php`: Rolls back the last applied migration (runs the migration `down` SQL and removes its record).
- `seed.php`: Scans `seeders/` and executes each seeder (each seeder should return a callable that accepts the PDO instance).
- `migrations/`: PHP files that return an array with `up` and `down` SQL strings.
- `seeders/`: PHP files that return a closure accepting `$pdo` to perform inserts or other seed logic.

**Migration file format**
Each migration file returns an array with `up` and `down` SQL strings. Example (`migrations/001_create_users_table.php`):

```php
return [
		"up" => "CREATE TABLE ...;",
		"down" => "DROP TABLE ...;"
];
```

`migrate.php` will ensure a `migrations` table exists:

```sql
CREATE TABLE IF NOT EXISTS migrations (
	id INT AUTO_INCREMENT PRIMARY KEY,
	migration VARCHAR(255),
	migrated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

When a migration runs successfully, the script inserts a record into that table so it won't run again.

**Seeder file format**
Each seeder returns a callable which receives the PDO instance. Example (`seeders/UsersSeeder.php`):

```php
return function($pdo) {
		// use prepared statements / bulk inserts
		$stmt = $pdo->prepare("INSERT INTO users (name,email) VALUES (?,?)");
		$stmt->execute(['John Doe','john@example.com']);
};
```

**Usage**
- Configure DB connection in `db.php` (set DSN, username, password).
- Run migrations:

```bash
php migrate.php
```

- Roll back the last migration:

```bash
php rollback.php
```

- Run seeders:

```bash
php seed.php
```

**Notes & Troubleshooting**
- If migrations don't run, check that migration files end with `.php` and return the `up`/`down` array.
- If seeders fail, verify they return a callable that accepts `$pdo` and use prepared statements to avoid SQL injection.
- To use a different database, update the `$dsn` in `db.php`.

**License**
This repository is an * — adapt freely for learning and small projects.
