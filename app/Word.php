<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Word extends Model
{
    protected $primaryKey = 'id_word';
    protected $fillable = ['name'];
    public $timestamps = false;
    protected $table = 'words';


    public function users()
    {
        return $this->belongsToMany(User::class, 'word_user', 'fk_wordid_word', 'fk_userid_user');
    }

    public function userCount() {
        return $this->belongsToMany(User::class)
            ->selectRaw('count(word_user.fk_userid_user) as count')
            ->groupBy('fk_wordid_word');
    }
}
