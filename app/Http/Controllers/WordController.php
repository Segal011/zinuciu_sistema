<?php

namespace App\Http\Controllers;

use App\Word;
use App\User;
use Illuminate\Http\Request;

class WordController extends Controller
{
    protected $words;
    protected $users;

    public function __construct(Word $words, User $users)
    {        
        $this->middleware('auth');
        $this->words = $words;
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

        $simpleWords = $this->words->all();
        $words = \DB::table('word_user')
            ->leftJoin('users', 'users.id_user', '=', 'word_user.fk_userid_user') 
            ->leftJoin('words', 'words.id_word', '=', 'word_user.fk_wordid_word')
            ->select('word_user.count', 'users.name as user', 'users.id_user as id_user', 'users.blocked_till as blocked_till', 'words.name')
            ->get();
        return view('words', compact('words', 'simpleWords'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function block(int $id)
    {
        self::updateLastAccess();

        $date = \Carbon\Carbon::now()->addDays(7);
        $this->users->find($id)->update(['blocked_till' => $date]);
        return \redirect()->back();
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        self::updateLastAccess();

        $this->words->create($request->all());
        return \redirect()->back();
    }
}
