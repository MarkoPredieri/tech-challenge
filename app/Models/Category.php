<?php

namespace App\Models;
use App\Models\Article;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'name',
        'description'
    ];

    // RELAZIONE CON MODELLO ARTICLE
    public function articles()
    {
        return $this->hasMany(Article::class);
    }
}