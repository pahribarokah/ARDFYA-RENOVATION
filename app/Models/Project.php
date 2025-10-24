<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Project extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'service_id',
        'inquiry_id',
        'name',
        'description',
        'status',
        'start_date',
        'expected_end_date',
        'actual_end_date',
        'end_date',
        'address',
        'total_cost',
        'budget',
        'budget_used',
        'thumbnail',
        'category',
        'is_featured',
        'progress_percentage',
        'notes',
        'team_assigned',
        'project_photos',
        'timeline_details',
        'customer_last_viewed',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'expected_end_date' => 'date',
        'actual_end_date' => 'date',
        'total_cost' => 'decimal:2',
        'budget' => 'decimal:2',
        'budget_used' => 'decimal:2',
        'is_featured' => 'boolean',
        'progress_percentage' => 'integer',
        'team_assigned' => 'array',
        'project_photos' => 'array',
        'customer_last_viewed' => 'datetime',
    ];

    /**
     * Get the user that owns the project
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the service that the project belongs to
     */
    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }

    /**
     * Get the inquiry that initiated the project
     */
    public function inquiry(): BelongsTo
    {
        return $this->belongsTo(Inquiry::class);
    }

    /**
     * Get the contract for the project
     */
    public function contract(): HasOne
    {
        return $this->hasOne(Contract::class);
    }

    /**
     * Get the images for the project
     */
    public function projectImages(): HasMany
    {
        return $this->hasMany(ProjectImage::class);
    }

    /**
     * Get the messages for the project
     */
    public function messages(): HasMany
    {
        return $this->hasMany(Message::class);
    }
}
