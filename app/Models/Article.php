<?php

namespace App\Models;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'title',
        'body',
        'category_id',
        'published_at'
    ];

    // RELAZIONE CON MODELLO CATEGORY
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
