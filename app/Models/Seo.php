<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Seo extends Model
{
    use SoftDeletes;

    // Usamos nombre de tabla singular "seo"
    protected $table = 'seo';

    protected $fillable = [
        'pagina_id',
        'meta_title', 'meta_description', 'meta_keywords',
        'canonical_url', 'robots',
        'og_title', 'og_description', 'og_image', 'og_type', 'og_locale',
        'twitter_card', 'twitter_title', 'twitter_description', 'twitter_image',
        'json_ld',
    ];

    protected $casts = [
        'json_ld'    => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    public function pagina()
    {
        return $this->belongsTo(Pagina::class);
    }
}
