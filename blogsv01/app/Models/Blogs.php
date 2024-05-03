<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blogs extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'description',
        'author_id',
    ];

    // Define the table associated with the model
    protected $table = 'blogs';

    // Define the relationships
    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }
}
