<?php

namespace App\Http\Controllers;

use App\Chat;
use App\Message;
use App\User;
use App\Word;
use Illuminate\Http\Request;
use DB;
use Auth;


class ChatController extends Controller
{
    protected $chats;
    protected $messages;
    protected $users;
    protected $words;

    public function __construct(Chat $chats, Message $messages, User $users, Word $words)
    {        
        $this->middleware('auth');
        $this->chats = $chats;
        $this->messages = $messages;
        $this->users = $users;
        $this->words = $words;
    }

    private function updateLastAccess()
    {
        if(Auth::check()){
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
        $chats = \DB::table('chats')
        ->leftJoin('users', 'users.id_user', '=', 'chats.admin') 
        ->select('chats.*', 'users.name as userName')
        ->get();

       // $chats = $this->chats->all();
        $users = $this->users->all();
 
        return view('chats.index', compact('chats', 'users'));
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

        $chat = $this->chats->create($request->all());
        
        $chat->users()->attach(Auth::user()->id_user);
        $id = $chat->id_chat;
        $messages = $this->messages->where("fk_chatid_chat", $chat->id)->get();
       //return view('chats.show', compact('messages', 'id')); 

        return self::show($chat->id_chat);
    }

    public function storeMessage(Request $request)
    {
        self::updateLastAccess();
        
        $message = $this->messages->create($request->all());
        self::searchWords($message->text);
        return self::show($message->fk_chatid_chat);
    }

    private function searchWords(string $text)
    {
        self::updateLastAccess();

        $words = $this->words->all();
        foreach($words as $word){
            if (strpos($text, $word->name) !== false) {
                $match = \DB::table('word_user')->where([
                    ['fk_userid_user', Auth::user()->id_user], 
                    ['fk_wordid_word', $word->id_word]
                 ] )->first();
                if(isset($match)){
                    $count = $match->count + 1;
                    $match = \DB::table('word_user')->where([
                        ['fk_userid_user', Auth::user()->id_user], 
                        ['fk_wordid_word', $word->id_word]
                     ] )->update(['count' => $count]);
                } else {
                    Auth::user()->words()->attach($word);
                }
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Chat  $chat
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        self::updateLastAccess();

        // $chat = DB::table('chat_user')->
        // where(
        //     ['fk_chatid_chat', Auth::user()->id_user],
        //     ['fk_userid_user', $id]
        // )->first();

        $user_chats = Auth::user()->chats()->where('fk_chatid_chat', $id)->first();
        $chat = $this->chats->find($id);
        if(!isset($user_chats)){

            $chat->users()->attach(Auth::user()->id_user);
        }
        $messages = \DB::table('messages')
            ->leftJoin('users', 'users.id_user', '=', 'messages.fk_userid_user') 
            ->select('messages.*', 'users.blocked_till as blocked_till', 'users.id_user as id_user', 'users.name as user')
            ->where("fk_chatid_chat", $id)
            ->get();

        $users = \DB::table('messages')
            ->leftJoin('users', 'users.id_user', '=', 'messages.fk_userid_user') 
            ->select('users.*')
            ->where("fk_chatid_chat", $id)
            ->groupBy('users.name')
            ->get()
           ->toArray();
        return view('chats.show', compact('messages','chat', 'users')); 
    }
}
