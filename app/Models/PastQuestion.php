<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PastQuestion extends Model
{
    use HasFactory;
    protected $fillable = ['course_id', 'year', 'file_path', 'image'];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function bookmarks()
{
    return $this->hasMany(Bookmark::class);
}

}
