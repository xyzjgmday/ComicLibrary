namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reader extends Model
{
    protected $fillable = [
        'username', 'email', 'password', 'last_login', 'favorite_comics',
    ];

    protected $casts = [
        'favorite_comics' => 'json',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'last_login',
    ];

    public function comics()
    {
        return $this->hasMany(Comic::class, 'reader_id', 'reader_id');
    }
}
