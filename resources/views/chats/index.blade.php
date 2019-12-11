@extends('layouts.app')

@section('content')

<h2>Pokalbių sistema. Indrė Segalovičiūtė</h2>

<br/>


<div class="row">
<div class="column" style="width: 30%">
  <form class="submit_form" method="post" action="{{ route('chats.store') }}">
  @csrf 
    <div>
        <h5>Sukurti naują pokalbį ir priskirti kuratorių</h5>
        <input required type="text" name="name" placeholder="Pokalbio pavadinimas" />
        <select class="m-bot15" name="admin">
          @foreach($users as $user)
              <option value="{{ $user->id_user }}" {{ $selectedUser = $user->id_user ? 'selected="selected"' : '' }}>{{ $user->name }}</option>    
          @endforeach
        </select>
        <input type="submit" value="Sukurti" name="Sukurti" required/>

      </div>
  </form>
</div>

<div class="column" style="width: 5%"></div>
<div class="column" style="width: 30%">
    <h2>Pokalbiai</h2>
      @foreach ($chats as $chat)
      <h6><a href="{{ route('chats.show', [$chat->id_chat]) }}">{{ $chat->name }} ({{ $chat->userName }})</a> </h6>
      @endforeach
  </div>

  <div class="column" style="width: 5%x"></div>

  <div class="columnn" style=" width: 30%">
    <h2>Vartotojai</h2>
    @foreach ($users as $user)
    <h6>{{ $user->name . " " . $user->surname . " "}}
    @if($user->updated_at > \Carbon\Carbon::now()->subMinutes(15))
   <i class="fa fa-certificate" style="font-size:24;color:green"></i>
    @endif    
    </h6>
    @endforeach

  </div>
</div>




<script>
document.addEventListener('invalid', (function () {
    return function (e) {
        e.preventDefault();
        document.getElementById("name").focus();
    };
})(), true);

</script>

@endsection
