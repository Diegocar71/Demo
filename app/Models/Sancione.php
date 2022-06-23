<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sancione extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        'personal_id','numero_disp', 'numero_rrhh','lup', 'catpersonal_id','dest_gral','destino','fecha_sancion','tipo_sancion','susp_empleo','fecha_not','detalle','Impuesta_lup','cumplida','pri_recurso','seg_recurso','resolucion','notificacion','observaciones',
    ];

    public function catpersonal()
    {
        return $this->belongsTo(Catpersonal::class);
    }

}


