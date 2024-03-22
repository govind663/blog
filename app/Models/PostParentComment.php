<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostParentComment extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'id',
        'post_comment',
        'created_by',
        'created_at',
        'updated_by',
        'updated_at',
        'deleted_by',
        'deleted_at',
    ];

    protected $dates = ['deleted_at', 'inserted_at', 'modified_at'];

    // relation  to user model (one-to-many)
    public function user() {
        return $this->belongsTo(User::class);
    }

    // relation  to user model (one-to-many)
    public function blog() {
        return $this->belongsTo(Blog::class);
    }
}
