<?php

namespace App\Models;

use \DateTimeInterface;
use App\Support\HasAdvancedFilter;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Peliculess extends Model
{
    use HasAdvancedFilter;
    use SoftDeletes;
    use HasFactory;

    public $table = 'peliculesses';

    protected $dates = [
        'data',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $orderable = [
        'id',
        'titol',
        'director.nom',
        'data',
        'valoracio',
        'tipus',
        'format',
    ];

    protected $filterable = [
        'id',
        'titol',
        'director.nom',
        'data',
        'valoracio',
        'tipus',
        'format',
    ];

    protected $fillable = [
        'titol',
        'director_id',
        'data',
        'valoracio',
        'tipus',
        'format',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function director()
    {
        return $this->belongsTo(Director::class);
    }

    public function getDataAttribute($value)
    {
        return $value ? Carbon::createFromFormat('Y-m-d H:i:s', $value)->format(config('project.date_format')) : null;
    }

    public function setDataAttribute($value)
    {
        $this->attributes['data'] = $value ? Carbon::createFromFormat(config('project.date_format'), $value)->format('Y-m-d') : null;
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
