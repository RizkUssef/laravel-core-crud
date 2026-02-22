# 🚀 Laravel Core CRUD Package

<p align="center">

[![Latest Version on Packagist](https://img.shields.io/packagist/v/rizkussef/laravel-core-crud.svg?style=flat-square)](https://packagist.org/packages/rizkussef/laravel-core-crud)
[![Total Downloads](https://img.shields.io/packagist/dt/rizkussef/laravel-core-crud.svg?style=flat-square)](https://packagist.org/packages/rizkussef/laravel-core-crud)
[![License](https://img.shields.io/packagist/l/rizkussef/laravel-core-crud.svg?style=flat-square)](LICENSE)

</p>

A clean, scalable **Core CRUD architecture for Laravel**, built around a reusable **Base Service** and **Base Controller** with automatic:

* ✅ Model Resolution
* ✅ Resource Resolution
* ✅ Collection Handling
* ✅ Pagination
* ✅ API

Designed to eliminate repetitive CRUD logic while keeping your application clean and maintainable.

---

# 📦 Installation

Install via Composer:

```bash
composer require rizkussef/laravel-core-crud
```

If needed, manually register the provider in:

```php
config/app.php
```

```php
Rizkussef\LaravelCoreCrud\CoreCrudServiceProvider::class,
```

---

# ⚙️ Publish Configuration

```bash
php artisan vendor:publish --provider="Rizkussef\LaravelCoreCrud\CoreCrudServiceProvider" --tag=config
```

This will publish:

```php
config/core-crud.php
```

Example:

```php
return [
    'paginate' => 15,
];
```

---

# 🏗 Architecture

```
App
 ├── Models
 │     └── User.php
 ├── Services
 │     └── UserService.php
 ├── Http
 │     ├── Controllers
 │     │      └── UserController.php
 │     └── Resources
 │            └── UserResource.php
```

---

# 🚀 Quick Start

## 1️⃣ Create a Service

```php
namespace App\Services;

use Rizkussef\LaravelCoreCrud\Services\CoreCrudService;

class UserService extends CoreCrudService
{
    // Add business logic here if needed
}
```

### 🔎 Automatic Model & Resource Resolution

```
UserService → App\Http\Resources\UserResource
UserService → App\Models\User
```

No need to manually define the model or resource.

---

## 2️⃣ Create a Controller

```php
namespace App\Http\Controllers;

use App\Services\UserService;
use Rizkussef\LaravelCoreCrud\Http\Controllers\CoreCrudController;

class UserController extends CoreCrudController {}
```
If the resource does not exist, raw model data is returned.

---

# 🔁 Built-in CRUD Methods

The BaseCrudController provides:

* `index()` – List records
* `getPaginated($perPage)` - Paginate list of records
* `show($id)` – Show single record
* `store(Request $request)` – Create record
* `update(Request $request, $id)` – Update record
* `destroy($id)` – Delete record

All logic is handled inside **CoreCrudService**.

---

# 📄 Automatic Resource Handling

### Single Item

```php
return new UserResource($user);
```

### Collection

```php
return UserResource::collection($users);
```

Automatically handled by the base service.

---

# 📊 Example JSON Response

### GET /users

```json
{
  "data": [
    {
      "id": 1,
      "name": "John Doe"
    }
  ],
  "meta": {
    "current_page": 1,
    "per_page": 15
  }
}
```

---

# 🧠 Best Practices

✔ Keep business logic inside Model-specific services.<br>
✔ Keep controllers thin. <br>
✔ Extend CoreCrudService instead of modifying it.<br>
✔ Use Resources for API formatting.

Example:

```php
class UserService extends CoreCrudService
{
    public function activate($id)
    {
        $user = $this->find($id);
        $user->update(['active' => true]);
        return $user;
    }
}
```

---

# 🔌 Dependency Injection

CoreCrudService is bound in the container via the Service Provider, so it can be injected anywhere.

---

# 🔧 Extending

You can extend:

* BaseCrudController
* CoreCrudService
* API Response Trait
* Pagination configuration

---

# 🛣 Example Routes

```php
Route::apiResource('users', UserController::class);
```

# 📜 License

MIT License

---

# 👨‍💻 Author
Made with ❤️ by Rizk Ussef