# Panduan Pengembangan - Aplikasi Ardfya v2

## 1. Development Environment Setup

### 1.1 Prerequisites

**Required Software:**
- PHP 8.2+
- Composer 2.x
- Node.js 18.x+
- NPM 9.x+
- Git
- MySQL/PostgreSQL (optional, SQLite included)

**Recommended Tools:**
- VS Code dengan extensions:
  - PHP Intelephense
  - Laravel Extension Pack
  - Tailwind CSS IntelliSense
  - Alpine.js IntelliSense
- TablePlus/phpMyAdmin untuk database management
- Postman untuk API testing

### 1.2 Local Development Setup

```bash
# Clone repository
git clone https://github.com/your-repo/ardfya_v2.git
cd ardfya_v2

# Install dependencies
composer install
npm install

# Environment setup
cp .env.example .env
php artisan key:generate

# Database setup
touch database/database.sqlite
php artisan migrate --seed

# Start development
composer run dev
```

**Development Command:**
```bash
# Runs server, queue worker, and Vite dev server concurrently
composer run dev

# Individual commands:
php artisan serve              # Laravel development server
php artisan queue:listen       # Queue worker
npm run dev                   # Vite development server
```

## 2. Code Standards dan Conventions

### 2.1 PHP Coding Standards

**PSR Standards:**
- PSR-1: Basic Coding Standard
- PSR-4: Autoloader Standard
- PSR-12: Extended Coding Style

**Laravel Conventions:**
```php
// Class naming (PascalCase)
class ProjectController extends Controller

// Method naming (camelCase)
public function createProject()

// Variable naming (camelCase)
$projectData = [];

// Constants (UPPER_SNAKE_CASE)
const MAX_FILE_SIZE = 1024;

// Database tables (snake_case, plural)
projects, contract_payments

// Model properties (snake_case)
protected $fillable = ['user_id', 'project_name'];
```

### 2.2 JavaScript/CSS Standards

**JavaScript:**
```javascript
// Use camelCase for variables and functions
const projectData = {};
function handleSubmit() {}

// Use PascalCase for classes
class ProjectManager {}

// Use UPPER_SNAKE_CASE for constants
const MAX_RETRY_ATTEMPTS = 3;
```

**CSS/TailwindCSS:**
```css
/* Use kebab-case for custom classes */
.project-card {}
.btn-primary {}

/* Follow BEM methodology for complex components */
.project-card__header {}
.project-card__header--featured {}
```

### 2.3 Database Conventions

**Migration Naming:**
```php
// Create table
2024_01_01_000000_create_projects_table.php

// Add column
2024_01_02_000000_add_status_to_projects_table.php

// Modify column
2024_01_03_000000_modify_budget_in_projects_table.php
```

**Model Relationships:**
```php
// hasMany (plural)
public function projects(): HasMany

// belongsTo (singular)
public function user(): BelongsTo

// hasOne (singular)
public function contract(): HasOne
```

## 3. Development Workflow

### 3.1 Git Workflow

**Branch Strategy:**
```bash
main                    # Production branch
├── develop            # Development branch
├── feature/inquiry-system
├── feature/chat-integration
├── hotfix/security-patch
└── release/v2.1.0
```

**Commit Message Convention:**
```bash
# Format: type(scope): description

feat(inquiry): add file upload to inquiry form
fix(auth): resolve admin login redirect issue
docs(api): update API documentation
style(ui): improve mobile responsive design
refactor(database): optimize query performance
test(unit): add tests for project controller
chore(deps): update Laravel to v12.1
```

### 3.2 Feature Development Process

1. **Create Feature Branch:**
```bash
git checkout develop
git pull origin develop
git checkout -b feature/new-feature-name
```

2. **Development:**
```bash
# Make changes
# Write tests
# Update documentation

# Commit changes
git add .
git commit -m "feat(scope): description"
```

3. **Testing:**
```bash
# Run tests
php artisan test

# Check code style
./vendor/bin/pint

# Run static analysis
./vendor/bin/phpstan analyse
```

4. **Pull Request:**
```bash
git push origin feature/new-feature-name
# Create PR to develop branch
```

### 3.3 Code Review Guidelines

**Review Checklist:**
- [ ] Code follows project conventions
- [ ] Tests are included and passing
- [ ] Documentation is updated
- [ ] No security vulnerabilities
- [ ] Performance considerations addressed
- [ ] Database migrations are reversible
- [ ] Error handling is implemented

## 4. Testing Strategy

### 4.1 Testing Structure

```
tests/
├── Feature/           # Integration tests
│   ├── InquiryTest.php
│   ├── ProjectTest.php
│   └── AdminDashboardTest.php
├── Unit/              # Unit tests
│   ├── Models/
│   ├── Services/
│   └── Helpers/
└── TestCase.php       # Base test class
```

### 4.2 Writing Tests

**Feature Test Example:**
```php
<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Service;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class InquiryTest extends TestCase
{
    use RefreshDatabase;

    public function test_customer_can_submit_inquiry()
    {
        $service = Service::factory()->create();
        
        $response = $this->post('/inquiries', [
            'service_id' => $service->id,
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'phone' => '08123456789',
            'address' => 'Test Address',
            'property_type' => 'House',
            'area_size' => 100,
            'budget' => 50000000,
            'description' => 'Test description',
        ]);

        $response->assertRedirect(route('home'));
        $this->assertDatabaseHas('inquiries', [
            'email' => 'john@example.com',
            'service_id' => $service->id,
        ]);
    }
}
```

**Unit Test Example:**
```php
<?php

namespace Tests\Unit\Models;

use App\Models\Contract;
use Tests\TestCase;

class ContractTest extends TestCase
{
    public function test_contract_number_generation()
    {
        $contractNumber = Contract::generateContractNumber();
        
        $this->assertMatchesRegularExpression(
            '/^CTR-\d{6}-\d{4}$/',
            $contractNumber
        );
    }

    public function test_remaining_amount_calculation()
    {
        $contract = new Contract([
            'amount' => 100000,
            'paid_amount' => 30000,
        ]);

        $this->assertEquals(70000, $contract->remaining_amount);
    }
}
```

### 4.3 Running Tests

```bash
# Run all tests
php artisan test

# Run specific test file
php artisan test tests/Feature/InquiryTest.php

# Run with coverage
php artisan test --coverage

# Run tests in parallel
php artisan test --parallel
```

## 5. Database Development

### 5.1 Migration Best Practices

**Creating Migrations:**
```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('service_id')->constrained();
            $table->string('name');
            $table->text('description');
            $table->enum('status', ['planning', 'in_progress', 'completed', 'cancelled'])
                  ->default('planning');
            $table->decimal('budget', 15, 2)->nullable();
            $table->timestamps();
            
            // Indexes
            $table->index(['status', 'created_at']);
            $table->index('user_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
```

### 5.2 Seeder Development

**Creating Seeders:**
```php
<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;

class ServicesSeeder extends Seeder
{
    public function run(): void
    {
        $services = [
            [
                'name' => 'Renovasi Rumah',
                'slug' => 'renovasi-rumah',
                'description' => 'Layanan renovasi rumah lengkap',
                'icon' => 'fas fa-home',
                'is_active' => true,
                'ordering' => 1,
            ],
            // More services...
        ];

        foreach ($services as $service) {
            Service::create($service);
        }
    }
}
```

### 5.3 Factory Development

**Model Factories:**
```php
<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Service;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProjectFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'service_id' => Service::factory(),
            'name' => $this->faker->sentence(3),
            'description' => $this->faker->paragraph(),
            'status' => $this->faker->randomElement(['planning', 'in_progress', 'completed']),
            'budget' => $this->faker->numberBetween(10000000, 100000000),
            'start_date' => $this->faker->dateTimeBetween('-1 month', '+1 month'),
        ];
    }
}
```

## 6. Frontend Development

### 6.1 Asset Development

**CSS Development:**
```bash
# Watch for changes
npm run dev

# Build for production
npm run build

# Analyze bundle size
npm run build -- --analyze
```

**TailwindCSS Custom Classes:**
```css
/* resources/css/app.css */
@layer components {
  .btn-primary {
    @apply bg-brand-green text-white px-6 py-2 rounded-full 
           hover:bg-brand-green-dark transition duration-300;
  }
  
  .card {
    @apply bg-white rounded-xl shadow-lg p-6 transition-all duration-300;
  }
}
```

### 6.2 JavaScript Development

**Alpine.js Components:**
```html
<!-- Modal Component -->
<div x-data="{ open: false }">
    <button @click="open = true" class="btn-primary">
        Open Modal
    </button>
    
    <div x-show="open" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 transform scale-90"
         x-transition:enter-end="opacity-100 transform scale-100"
         class="fixed inset-0 z-50 flex items-center justify-center">
        <!-- Modal content -->
    </div>
</div>
```

## 7. API Development

### 7.1 API Routes

```php
// routes/api.php
Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('projects', ProjectController::class);
    Route::apiResource('inquiries', InquiryController::class);
    
    Route::post('projects/{project}/upload-images', [ProjectController::class, 'uploadImages']);
    Route::get('dashboard/stats', [DashboardController::class, 'getStats']);
});
```

### 7.2 API Resources

```php
<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProjectResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'status' => $this->status,
            'progress_percentage' => $this->progress_percentage,
            'budget' => $this->budget,
            'start_date' => $this->start_date?->format('Y-m-d'),
            'service' => new ServiceResource($this->whenLoaded('service')),
            'customer' => new UserResource($this->whenLoaded('user')),
            'created_at' => $this->created_at->toISOString(),
        ];
    }
}
```

## 8. Performance Optimization

### 8.1 Database Optimization

```php
// Eager loading
$projects = Project::with(['service', 'user', 'contract'])
    ->where('status', 'active')
    ->get();

// Query optimization
$projects = Project::select(['id', 'name', 'status', 'user_id'])
    ->where('status', 'active')
    ->paginate(10);

// Caching
$services = Cache::remember('active_services', 3600, function () {
    return Service::where('is_active', true)->get();
});
```

### 8.2 Frontend Optimization

```javascript
// Lazy loading images
<img src="placeholder.jpg" 
     data-src="actual-image.jpg" 
     loading="lazy" 
     class="lazy-load">

// Code splitting
const ProjectManager = () => import('./components/ProjectManager.vue');
```

## 9. Debugging dan Troubleshooting

### 9.1 Debug Tools

```php
// Laravel Debugbar (development only)
composer require barryvdh/laravel-debugbar --dev

// Telescope (development only)
composer require laravel/telescope --dev
php artisan telescope:install

// Log debugging
Log::debug('Debug info', ['data' => $data]);
Log::info('Info message', ['context' => $context]);
Log::error('Error occurred', ['exception' => $e]);
```

### 9.2 Common Issues

**Database Connection Issues:**
```bash
# Check database connection
php artisan tinker
>>> DB::connection()->getPdo();

# Clear config cache
php artisan config:clear
```

**Permission Issues:**
```bash
# Fix storage permissions
sudo chown -R www-data:www-data storage/
sudo chmod -R 775 storage/
```

**Asset Issues:**
```bash
# Clear view cache
php artisan view:clear

# Rebuild assets
npm run build
```

## 10. Documentation Standards

### 10.1 Code Documentation

```php
/**
 * Create a new project from an inquiry
 *
 * @param  \App\Models\Inquiry  $inquiry
 * @param  array  $projectData
 * @return \App\Models\Project
 * @throws \InvalidArgumentException
 */
public function createProjectFromInquiry(Inquiry $inquiry, array $projectData): Project
{
    // Implementation
}
```

### 10.2 API Documentation

```php
/**
 * @OA\Post(
 *     path="/api/projects",
 *     summary="Create a new project",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"name","user_id","service_id"},
 *             @OA\Property(property="name", type="string"),
 *             @OA\Property(property="user_id", type="integer"),
 *             @OA\Property(property="service_id", type="integer")
 *         )
 *     ),
 *     @OA\Response(response=201, description="Project created successfully")
 * )
 */
```

---

*Panduan pengembangan ini memberikan framework yang komprehensif untuk developer dalam mengembangkan, testing, dan maintain aplikasi Ardfya v2 dengan standar kualitas yang tinggi.*
