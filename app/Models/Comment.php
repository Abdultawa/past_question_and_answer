<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'pastQuestion_id',
        'body',
        ];
    public function pastQuestion()
    {
        return $this->belongsTo(PastQuestion::class);
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
