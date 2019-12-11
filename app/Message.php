<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = ['text', 'created_at', 'fk_userid_user', 'fk_chatid_chat'];
    protected $primaryKey = 'id_message';

    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo(User::class);
    }    
    
    public function chat()
    {
        return $this->belongsTo(Chat::class);
    }
}
