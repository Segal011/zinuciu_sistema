<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    protected $primaryKey = 'id_chat';
    protected $fillable = ['name', 'admin'];
    public $timestamps = false;
    protected $table = 'chats';

    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'chat_user', 'fk_chatid_chat', 'fk_userid_user');
    }
}
