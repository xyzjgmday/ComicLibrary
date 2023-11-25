namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comics extends Model
{
    protected $fillable = [
        'title', 'author', 'genre', 'description',
        'release_date', 'status', 'reader_id',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'release_date',
    ];

    public function reader()
    {
        return $this->belongsTo(Reader::class, 'reader_id', 'reader_id');
    }
}
