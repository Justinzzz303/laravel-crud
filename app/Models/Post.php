<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    // Define fillable fields to allow mass assignment
    protected $fillable = [
        'title',
        'content', 
        'user_id'];
}
