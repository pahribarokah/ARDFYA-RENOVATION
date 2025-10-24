<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Inquiry extends Model
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
        'name',
        'email',
        'phone',
        'property_type',
        'address',
        'area_size',
        'budget',
        'description',
        'status',
        'admin_notes',
        'start_date',
        'schedule_flexibility',
        'current_condition',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'area_size' => 'integer',
        'budget' => 'decimal:2',
        'start_date' => 'date',
    ];

    /**
     * Get the user associated with the inquiry.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the service associated with the inquiry.
     */
    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }

    /**
     * Get the project for the inquiry.
     */
    public function project(): HasOne
    {
        return $this->hasOne(Project::class);
    }

    /**
     * Get the messages for the inquiry
     */
    public function messages(): HasMany
    {
        return $this->hasMany(Message::class);
    }
}
