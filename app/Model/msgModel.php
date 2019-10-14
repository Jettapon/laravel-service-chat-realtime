<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class msgModel extends Model
{
    protected $table = 'message';

    protected $fillable = ['msg' , 'user_id'];
    
    public function user(){
        return $this->belongsTo('App\User');
    }
}
