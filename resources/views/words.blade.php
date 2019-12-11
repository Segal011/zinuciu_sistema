@extends('layouts.app')

@section('content')
<style>
body {
  margin: 0 auto;
  max-width: 800px;
  padding: 0 20px;
}

.container {
  border: 2px solid #dedede;
  background-color: #f1f1f1;
  border-radius: 5px;
  padding: 10px;
  margin: 10px 0;
}

.darker {
  border-color: #ccc;
  background-color: #ddd;
}

.container::after {
  content: "";
  clear: both;
  display: table;
}

.container img {
  float: left;
  max-width: 60px;
  width: 100%;
  margin-right: 20px;
  border-radius: 50%;
}

.container img.right {
  float: right;
  margin-left: 20px;
  margin-right:0;
}

.time-right {
  float: right;
  color: #aaa;
}

.time-left {
  float: left;
  color: #999;
}

.columnn {
  float: center;
  width: 100%;
  padding: 100px;
} 

/* Clear floats after the columns */
.row:after {
  content: "";
  display: table;
  clear: both;
} 
</style>
</head>
<body>





<h2>Neleistinų žodžių vartojimas</h2>



<br/>
<div class="row" style="">
<div class="column" style="width: 25%">
<h3>Žodžių sąrašas</h3>

<form class="submit_form" method="post" action="{{route('words.store') }}">
  @csrf 
  <div>
    <input required type="text" name="name" placeholder="Naujas žodis"/>
    <input type="submit" value="Įrašyti" name="message_submit" />
  </div>
</form>

<br/>
    
    <table class="table table-striped table-bordered">
        <tr>
            <th><strong>ŽODIS</strong></th>
        </tr>

        @foreach ($simpleWords as $simpleWord)
            <tr>
                <td>{{ $simpleWord->name }}</td>
            </tr>
        @endforeach
    </table>
  </div>
  <div class="column" style="width: 10%">
   
  </div>
  <div class="columnn" style="width: 45%">
    <h3>Žodžių vartojimas</h3>
    <table class="table table-striped table-bordered">
      <tr>
          <th><strong>VARTOTOJAS</strong></th>
          <th><strong>ŽODIS</strong></th>
          <th><strong>KIEKIS</strong></th>
          <th><strong>BLOKUOTI</strong></th>
      </tr>

      @foreach ($words as $word)
          <tr>
              <td>{{ $word->user }}</td>
              <td>{{ $word->name }}</td>
              <td>{{ $word->count }}</td>
              <td>
                @if($word->blocked_till < \Carbon\Carbon::now())
                    <a href="{{ url('/block/'.$word->id_user) }}">Blokuoti</a>
                @else
                  Blokuotas iki {{ $word->blocked_till }}
                @endif
              </td>
          </tr>
      @endforeach
  </table>

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
