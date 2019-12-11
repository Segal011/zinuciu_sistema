<?php

namespace App;

use App\Chat;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $primaryKey = 'id_user';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'blocked_till',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getId()
    {
        return $this->id_user;
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }  
    
    public function hystories()
    {
        return $this->hasMany(History::class);
    }  

    public function chats()
    {
        return $this->belongsToMany(Chat::class, 'chat_user', 'fk_userid_user', 'fk_chatid_chat');
    }

    public function words()
    {
        return $this->belongsToMany(Word::class, 'word_user', 'fk_userid_user', 'fk_wordid_word');
    }
}
