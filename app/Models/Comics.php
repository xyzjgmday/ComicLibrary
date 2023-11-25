<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comics extends Model
{
    protected $table = 'comics';
    public $timestamps = true;
    protected $fillable = [
        'title',
        'author',
        'genre_id',
        'description',
        'release_date',
        'status',
        'reader_id',
    ];

    public function readers()
    {
        return $this->belongsTo(Reader::class, 'reader_id');
    }

    public function genres()
    {
        return $this->belongsTo(Genre::class, 'genre_id');
    }
}
