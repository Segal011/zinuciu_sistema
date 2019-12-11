<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class History extends Model
{
    protected $primaryKey = 'id_history';
    protected $fillable = ['fk_userid_user'];
    public $timestamps = false;
    protected $table = 'history';

    public function user()
    {
        return $this->belongsTo(User::class);
    }    
    
}
