<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Personal extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = ['lup','apellido', 'nombre','catpersonal_id'];

    public function catpersonal()
    {
        return $this->belongsTo(Catpersonal::class);
    }


}
