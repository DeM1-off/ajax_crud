<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuthorToBookModel extends Model
{
    protected $table = 'books_to_autors';

    /**
     * @var string
     */
    public $primaryKey = 'id';

    /**
     * @var string[]
     */
    protected $fillable = ['book_id', 'author_id'];}
