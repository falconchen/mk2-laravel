<?php



namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ebook extends Model
{
    use HasFactory;

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'body',
        'user_id',
        'uploaded_time',
        'kindle_email',
        'file_path'
    ];



    public function getCreatedAtColumn() {
      return 'uploaded_time';
    }

    public function getUpdatedAtColumn() {
      return 'sent_time';
    }



    /**
     * Set relationship to User.
     *
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
