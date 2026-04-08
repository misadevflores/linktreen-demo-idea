# Linktree SaaS TODO - Laravel 11 + Filament v5 Multi-Tenancy

## Approved Plan Steps (progress tracked)

### Phase 1: Database & Models
- [x] 1. Create migrations: stores_table, store_user pivot, links_table, products_table
- [x] 2. Create models: Store.php, Link.php, Product.php
- [x] 3. Update User.php (add stores relation)

### Phase 2: Filament Config
- [x] 4. Edit AdminPanelProvider.php (add tenant(Store::class, slug:'slug'))
- [x] 5. Edit config/filesystems.php (add stores disks)

### Phase 3: Resources
- [x] 6. Create LinkResource.php (conditional schema for tipo)
- [x] 7. Create ProductResource.php (standard with images)

### Phase 4: Migrations & Test
- [x] 8. Run `php artisan migrate`
- [x] 9. Create test tenant/verify tenancy in /admin - Instructions: php artisan make:filament-user (create superadmin), login /admin, create Store(slug), attach to user via pivot or tenancy login, verify Links/Products scoped.

### Phase 5: Frontend
- [ ] 10. Routes, Controller, Blade view /{slug}

**Current Progress: Starting Phase 1**

*Updated after each step completion.*
