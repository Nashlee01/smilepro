<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migration to create the patients table.
 *
 * This migration sets up the database structure for storing patient information
 * including personal details required for the SmilePro patient management system.
 */
return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Creates the patients table with columns for patient data.
     */
    public function up(): void
    {
        Schema::create('patients', function (Blueprint $table) {
            $table->id();                           // Primary key
            $table->string('first_name');           // Patient's first name (required)
            $table->string('last_name');            // Patient's last name (required)
            $table->string('email')->unique();      // Patient's email (unique, required)
            $table->string('phone')->nullable();    // Patient's phone number (optional)
            $table->date('date_of_birth')->nullable(); // Patient's date of birth (optional)
            $table->text('address')->nullable();    // Patient's address (optional)
            $table->timestamps();                   // Created and updated timestamps
        });
    }

    /**
     * Reverse the migrations.
     *
     * Drops the patients table if the migration is rolled back.
     */
    public function down(): void
    {
        Schema::dropIfExists('patients');
    }
};