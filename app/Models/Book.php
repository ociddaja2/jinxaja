<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    //
    protected $fillable = [
        'title',
        'isbn',
        'stock',
        'category_id',
        'author_id',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function author()
    {
        return $this->belongsTo(Author::class);
    }

    public function pinjamans()
    {
        return $this->hasMany(Pinjaman::class);
    }
}
