<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Portfolio extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'category',
        'image_path',
        'client_name',
        'location',
        'completion_date',
        'project_value',
        'is_featured',
        'is_active',
        'ordering'
    ];

    protected $casts = [
        'completion_date' => 'date',
        'project_value' => 'decimal:2',
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
    ];

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('ordering', 'asc')->orderBy('created_at', 'desc');
    }

    // Accessors
    public function getFormattedProjectValueAttribute()
    {
        if ($this->project_value) {
            return 'Rp ' . number_format($this->project_value, 0, ',', '.');
        }
        return null;
    }

    public function getImageUrlAttribute()
    {
        if ($this->image_path) {
            return asset('storage/' . $this->image_path);
        }
        return asset('images/portfolio-placeholder.jpg');
    }

    public function getCategoryNameAttribute()
    {
        $categories = self::getCategories();
        return $categories[$this->category] ?? ucfirst($this->category);
    }

    // Static methods
    public static function getCategories()
    {
        return [
            'renovasi' => 'Renovasi',
            'pembangunan' => 'Pembangunan Baru',
            'interior' => 'Desain Interior',
            'eksterior' => 'Desain Eksterior',
            'landscape' => 'Landscape',
            'komersial' => 'Komersial',
            'residensial' => 'Residensial'
        ];
    }
}
