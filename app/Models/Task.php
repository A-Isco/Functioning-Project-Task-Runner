<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $primaryKey = 'task_id';
    public $incrementing = false ;
    protected $keyType = 'string' ;

    protected $fillable =  [
        'project_id' , 'task_type' , 'task_id'
    ] ;
}

