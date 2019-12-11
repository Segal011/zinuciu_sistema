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



<div class="row">
<div class="column" style="width: 40%">
    <h2>Prisijungimų istorija</h2>
    
    <table class="table table-striped table-bordered">
        <tr>
            <th><strong>VARDAS</strong></th>
            <th><strong>PRISIJUNGIMO LAIKAS</strong></th>
        </tr>

        @foreach ($histories as $history)
            <tr>
                <td>{{ $history->name }}</td>
                <td>{{ $history->time }}</td>
            </tr>
        @endforeach
    </table>
  </div>
  <div class="column" style="width: 10%">
   
  </div>
  <div class="columnn" style="width: 40%">
    <h2>Prisijungimų dažnumas</h2>
    <table class="table table-striped table-bordered">
        <tr>
            <th><strong>VARDAS</strong></th>
            <th><strong>PRISIJUNGIMŲ KIEKIAI</strong></th>
        </tr>

        @foreach ($users as $user)
            <tr>
                <td>{{ $user->name }}</td>
                <td>{{ $user->count }}</td>
            </tr>
        @endforeach
    </table>

  </div>
</div>







</body>
</html>
@endsection
