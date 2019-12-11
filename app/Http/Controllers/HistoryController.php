<?php

namespace App\Http\Controllers;

use App\Chat;
use App\Message;
use App\User;
use App\History;
use Illuminate\Http\Request;

class HistoryController extends Controller
{
    protected $histories;
    protected $users;

    public function __construct(History $histories, User $users)
    {        
        $this->middleware('auth');
        $this->histories = $histories;
        $this->users = $users;
    }

    private function updateLastAccess()
    {
        if(\Auth::check()){
            $id = \Auth::user()->getId();
            \DB::table('users')->where('id_user', $id)
            ->update(['updated_at' => \Carbon\Carbon::now()]);
        }
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        self::updateLastAccess();
        $histories = $this->histories->
            leftJoin('users', 'users.id_user', '=', 'history.fk_userid_user')
            ->select('users.name', 'history.time')
            ->get();

        $users = $this->histories->
            leftJoin('users', 'users.id_user', '=', 'history.fk_userid_user')
            ->select('users.name', \DB::raw('count(*) as count'))
            ->groupBy('users.name')
            ->get();
        return view('history', compact('histories', 'users'));
    }
}
