<?php

namespace Modules\CMS\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class Post extends Model
{
    use HasFactory, \Spatie\Activitylog\Models\Concerns\LogsActivity;

    protected $fillable = [
        'title',
        'slug',
        'category',
        'cat_color',
        'excerpt',
        'body',
        'thumbnail',
        'user_id',
        'read_time',
        'icon_path',
        'grad',
        'approval_status',
        'published_at',
    ];

    protected $casts = [
        'published_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();
        
        static::saving(function ($post) {
            if (empty($post->slug)) {
                $post->slug = Str::slug($post->title);
            }
        });
    }

    public function author()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }

    public function getActivitylogOptions(): \Spatie\Activitylog\Support\LogOptions
    {
        return \Spatie\Activitylog\Support\LogOptions::defaults()
            ->useLogName('posts')
            ->logOnly(['title', 'approval_status'])
            ->logOnlyDirty()
            ->dontLogEmptyChanges();
    }
}
