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
        'name', 'image'
    ];


    public function addAuthor()
    {
        return $this->belongsToMany(AuthorModel::class,'books_to_autor');
    }
}
