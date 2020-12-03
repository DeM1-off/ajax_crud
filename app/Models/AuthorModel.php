<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class AuthorModel extends Model
{


    /**
     * @var string
     */
    protected $table = 'authors';

    /**
     * @var string
     */
    public $primaryKey = 'author_id';

    /**
     * @var string[]
     */
    protected $fillable = ['name', 'surname'];

    public function addBook()
    {

        return $this->belongsToMany(BookModel::class,'books_to_autor');

    }

}
