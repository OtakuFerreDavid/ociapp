<?php

namespace App\Models;

use \DateTimeInterface;
use App\Support\HasAdvancedFilter;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Album extends Model
{
    use HasAdvancedFilter;
    use SoftDeletes;
    use HasFactory;

    public $table = 'albums';

    protected $dates = [
        'data',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $orderable = [
        'id',
        'titol',
        'valoracio',
        'data',
        'tipus',
        'format',
        'artista.nom',
    ];

    protected $filterable = [
        'id',
        'titol',
        'valoracio',
        'data',
        'tipus',
        'format',
        'artista.nom',
    ];

    protected $fillable = [
        'titol',
        'valoracio',
        'data',
        'tipus',
        'format',
        'artista_id',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function getDataAttribute($value)
    {
        return $value ? Carbon::createFromFormat('Y-m-d H:i:s', $value)->format(config('project.date_format')) : null;
    }

    public function setDataAttribute($value)
    {
        $this->attributes['data'] = $value ? Carbon::createFromFormat(config('project.date_format'), $value)->format('Y-m-d') : null;
    }

    public function artista()
    {
        return $this->belongsTo(Artistum::class);
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
