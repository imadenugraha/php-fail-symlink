# PHP Symlink Deployment Failure Demo

A realistic demonstration of how PHP applications fail when deployed using Capistrano-style symlink deployments due to hardcoded paths and relative path issues.

## The Problem

This project simulates a common real-world issue:

1. **Hardcoded absolute paths** in `config/config.php`:
   ```php
   define('BASE_PATH', '/home/made/belajar/php-fail-symlink');
   ```
   These paths are specific to the development environment and break in production.

2. **Relative paths** throughout the codebase:
   ```php
   require_once '../config/config.php';
   require_once '../src/Router.php';
   ```
   These resolve from the current working directory, not the file location.

3. **Capistrano deployment** creates symlinks:
   ```
   /tmp/deployed-app/
   ├── current -> releases/20251203095254/
   ├── releases/
   │   └── 20251203095254/
   └── shared/
   ```

When the app runs through the `current` symlink, paths break because:
- Hardcoded paths point to non-existent dev directories
- Relative paths resolve incorrectly through symlinks

## Project Structure

```
php-fail-symlink/
├── config/
│   └── config.php              # Hardcoded BASE_PATH (PROBLEMATIC)
├── src/
│   ├── Router.php              # Uses relative paths
│   ├── View.php                # Uses hardcoded VIEWS_PATH
│   └── controllers/
│       ├── HomeController.php  # Uses hardcoded STORAGE_PATH
│       └── PostController.php  # Uses hardcoded STORAGE_PATH
├── views/
│   ├── layout.php
│   ├── home.php
│   └── post.php
├── public/
│   ├── index.php               # Entry point with relative requires
│   └── post.php
├── storage/
│   └── posts.json              # Sample blog data
├── deploy.sh                   # Capistrano-style deployment
├── test-deployment.sh          # Automated test script
├── cleanup.sh                  # Clean up test deployments
└── README.md
```

## Quick Test

Run the automated test to see the failure:

```bash
./test-deployment.sh
```

This will:
1. ✓ Test the app from source directory (works)
2. Deploy using Capistrano-style symlinks
3. ✗ Test the deployed app (fails with path errors)

## Manual Testing

### Test 1: Direct access (works)
```bash
cd public
php -S localhost:8000
# Visit http://localhost:8000
```

### Test 2: Deploy and test (fails)
```bash
# Deploy
./deploy.sh

# Try to run deployed version
cd /tmp/deployed-app/current/public
php -S localhost:8000
# Will fail with path errors!
```

### Cleanup
```bash
./cleanup.sh
```

## Deployment Structure (Capistrano-style)

```
/tmp/deployed-app/
├── current -> releases/20251203095254/    # Symlink to current release
├── releases/
│   ├── 20251203095254/                    # Release 1
│   ├── 20251203095300/                    # Release 2
│   └── 20251203095400/                    # Release 3
└── shared/
    ├── storage/                            # Shared storage (persists across releases)
    │   └── posts.json
    └── config/                             # Shared config
```

Each release has `storage -> ../../shared/storage` symlink.

## Why It Fails

### Problem 1: Hardcoded Paths
```php
// config/config.php
define('BASE_PATH', '/home/made/belajar/php-fail-symlink');  // Dev path
define('VIEWS_PATH', BASE_PATH . '/views');                   // Won't exist in production!
```

When deployed to `/tmp/deployed-app/releases/[timestamp]/`, these paths don't exist.

### Problem 2: Relative Paths
```php
// public/index.php
require_once '../config/config.php';  // Resolves from CWD, not file location
```

With symlinks, the current working directory differs from the file's real location.

### Problem 3: Mixed Issues
```php
// src/View.php
$viewFile = VIEWS_PATH . '/' . $viewName . '.php';  // Uses hardcoded path

// src/Router.php
$controllerFile = '../src/controllers/' . $controller . '.php';  // Relative path
```

Both patterns fail in different ways during deployment.

## The Solution

### Fix 1: Use `__DIR__` for relative paths
```php
// config/config.php - BEFORE
define('BASE_PATH', '/home/made/belajar/php-fail-symlink');

// config/config.php - AFTER
define('BASE_PATH', dirname(__DIR__));  // Relative to config.php location
```

### Fix 2: Use `__DIR__` in requires
```php
// public/index.php - BEFORE
require_once '../config/config.php';

// public/index.php - AFTER
require_once __DIR__ . '/../config/config.php';
```

### Fix 3: Resolve symlinks if needed
```php
define('BASE_PATH', realpath(dirname(__DIR__)));
```

### Fix 4: Use environment variables
```php
define('BASE_PATH', getenv('APP_BASE_PATH') ?: dirname(__DIR__));
```

## Key Learnings

1. **Never hardcode absolute paths** - they're environment-specific
2. **Use `__DIR__`** - it's relative to the file, not the current directory
3. **Be aware of symlinks** - they change how paths resolve
4. **Test deployments** - what works in dev may fail in production
5. **Understand Capistrano** - know how your deployment tool structures directories

## Real-World Impact

This pattern causes failures in:
- Capistrano deployments (Ruby on Rails ecosystem)
- Deployer (PHP deployment tool)
- Custom deployment scripts using symlinks
- Docker volumes with symlinked directories
- Any zero-downtime deployment strategy using symlinks

## Technologies

- PHP 7.4+
- Bash scripting
- Simulated Capistrano-style deployment
