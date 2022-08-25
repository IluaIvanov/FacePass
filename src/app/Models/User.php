<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class User extends Model implements HasMedia
{
    use InteractsWithMedia;

    /**
     * @var array
     */

    protected $fillable = ['name', 'email', 'photo', 'created_at', 'updated_at'];
}
