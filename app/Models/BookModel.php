<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookModel extends Model
{

    /**
     * @var string
     */
    protected $table = 'books';

    /**
     * @var string
     */
    public $primaryKey = 'book_id';

    /**
     * @var string[]
     */
    protected $fillable = [
        'name', 'image','author_id'
    ];
}
