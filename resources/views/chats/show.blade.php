@extends('layouts.app')

@section('content')

<h2>{{ $chat->name }}</h2>

<div class="row">
<div id=“streamTitle” class="column" style="width: 70%">
  @foreach ($messages as $message)
      @if ($message->fk_userid_user == Auth::user()->id_user)
      <div class="container_m">
        <!-- <img src="/w3images/bandmember.jpg" alt="Avatar" style="width:100%;"> -->
        <p class="text-right"><strong>{{$message->user}}</strong></p>
        <p class="text-right">{{$message->text}}</p>
        <span class="time-right">{{$message->created_at}}</span></br>
         @if(Auth::user()->admin == 1 || Auth::user()->id_user == $chat->admin)
          <p class="text-right">
              @if($message->blocked_till < \Carbon\Carbon::now())
                <a href="{{ url('/block/'.$message->id_user) }}">Blokuoti</a>
              @else
                Blokuotas iki {{ $message->blocked_till }}
              @endif
          </p>
          @endif
      </div>
      @else   
      <div class="container_m darker">
        <!-- <img src="/w3images/avatar_g2.jpg" alt="Avatar" class="right" style="width:100%;"> -->
        <p><strong>{{$message->user}}</strong></p>
        <p>{{$message->text}}</p>
        <span class="time-left">{{$message->created_at}}</span></br>
        @if(Auth::user()->admin == 1 || Auth::user()->id_user == $chat->admin)
          <p>
              @if($message->blocked_till < \Carbon\Carbon::now())
                <a href="{{ url('/block/'.$message->id_user) }}">Blokuoti</a>
              @else
                Blokuotas iki {{ $message->blocked_till }}
              @endif
          </p>
          @endif
      </div>
      @endif
  @endforeach
    @if(Auth::user()->blocked_till < \Carbon\Carbon::now())
      <form class="submit_form" method="post" action="{{route('chats.sent') }}">
      @csrf 
        <div>
          <input  type="text"  name="text"/>
          <input type="hidden" name="fk_chatid_chat" value= {{ $chat->id_chat }} />
          <input type="hidden" name="fk_userid_user" value= {{ \Auth::user()->id_user }} />
          <input type="submit" value="message_submit" name="message_submit" />
        </div>
      </form>
     @else
      <p> Blokuoti vartotojai rašyti negali. Jūs esate užblokuotas iki {{ Auth::user()->blocked_till }}</p>
     @endif
</div>
<div class="column" style="width: 10%"></div>
  <div class="column" style="width: 20%">
      <h2>Vartotojai</h2>

    @foreach ($users as $user)
    <h6>{{ $user->name }}
    @if($user->updated_at > \Carbon\Carbon::now()->subMinutes(15))
   <i class="fa fa-certificate" style="font-size:24;color:green"></i>
    @endif    
    </h6>
    @endforeach

  </div>
</div>





<script>

function autoRefresh_div() {
    $("#div").load("load.html", function() {
        setTimeout(autoRefresh_div, 5000);
    });
}

autoRefresh_div();

document.addEventListener('invalid', (function () {
    return function (e) {
        e.preventDefault();
        document.getElementById("text").focus();
    };
})(), true);

</script>



@endsection


