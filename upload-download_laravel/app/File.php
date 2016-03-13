<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    /**
    * Relationships
    * Relacionamentos
    */
    public function user(){
    	//Pertence a usuários
    	return $this->belongsTo('App\User', 'user_id');
    }
}
