<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Filament\PanelProvider;

class Store extends Model implements FilamentUser
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'logo',
        'color_tema',
        'whatsapp',
        'qr_pago_simple',
    ];

    protected $casts = [
        'color_tema' => 'string',
    ];

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }

    public function links()
    {
        return $this->hasMany(Link::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function canAccessPanel(Panel $panel): bool
    {
        return $this->users()->where('user_id', auth()->id())->exists();
    }
}

