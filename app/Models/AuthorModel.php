<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuthorModel extends Model
{


    /**
     * @var string
     */
    protected $table = 'authorS';

    /**
     * @var string
     */
    public $primaryKey = 'author_id';

    /**
     * @var string[]
     */
    protected $fillable = [
        'name', 'surname'
    ];
}
