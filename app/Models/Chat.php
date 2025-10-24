<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    use HasFactory;

    protected $fillable = [
    'customer_id',
    'admin_id',
    'message',
    'is_from_admin',
    'is_read',
    'file_url',
    'file_name',
    'file_type',
    'file_size'
    ];

    protected $casts = [
        'is_from_admin' => 'boolean',
        'is_read' => 'boolean',
    ];

    /**
     * Get the customer that owns the chat.
     */
    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    /**
     * Get the admin that owns the chat.
     */
    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }
}
