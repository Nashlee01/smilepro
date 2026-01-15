<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Patient model representing a patient in the SmilePro system.
 *
 * This model handles patient data including personal information
 * and provides factory support for testing.
 */
class Patient extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',      // Patient's first name
        'last_name',       // Patient's last name
        'email',           // Patient's email address (unique)
        'phone',           // Patient's phone number (optional)
        'date_of_birth',   // Patient's date of birth (optional)
        'address',         // Patient's address (optional)
    ];
}