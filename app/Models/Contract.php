<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Contract extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'project_id',
        'user_id',
        'contract_number',
        'start_date',
        'end_date',
        'amount',
        'contract_status',
        'installments',
        'notes',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'amount' => 'decimal:2',
    ];

    /**
     * Get the project that owns the contract
     */
    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    /**
     * Get the user that owns the contract
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Payment relationships and methods removed

    /**
     * Generate a unique contract number
     */
    public static function generateContractNumber(): string
    {
        $prefix = 'CTR';
        $year = date('Y');
        $month = date('m');
        
        // Get the last contract for this month
        $lastContract = static::where('contract_number', 'like', "{$prefix}-{$year}{$month}%")
            ->orderBy('id', 'desc')
            ->first();
            
        if ($lastContract) {
            // Extract the sequence number and increment
            $parts = explode('-', $lastContract->contract_number);
            $sequence = (int) substr(end($parts), -4);
            $sequence++;
        } else {
            $sequence = 1;
        }
        
        // Format: CTR-YYYYMM-XXXX (XXXX is a sequential number)
        return sprintf('%s-%s%s-%04d', $prefix, $year, $month, $sequence);
    }
}
