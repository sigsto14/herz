
@extends('template')
@section('container')
@section('footer')
<!DOCTYPE HTML>

<title>{{ $user->username }}</title>
@yield('content')
<!-- Kanal innehåll --> 
    <div class="container">
    <!-- Kanal header --> 
    
     <div class="col-md-12" id="container">
     <div class="channel_header">
        <img src="http://localhost/Herz/public/images/channel/default.png">
        </div>
        <!-- Första låda, här finns profil --> 
        <div class="col-lg-4">
          <div class="row">
            <h2>{{ $user->username }}</h2>
            <img src="{{ $user->profilePicture }}" style="width:145px;height:159px;"/>    
          </div>
          <div class="row">
          </div>
          <div class="row">
          </div>
          <hr>
          <div class="row"> 
          <!-- kollar om user inloggad -->
          @if(Auth::user())
          <!-- kolla om user inloggad stämmer överens om det id man är på (show-funktion från controller -->
            @if(Auth::user()->userID == $user->userID)
            <a href="{{URL::route('user.edit', array('id' => $user->userID)) }}">Ändra kontouppgifter</a><br>
            <?php
            /* kod för att kolla om användaren har kanal */
            $channelCheck = DB::table('channels')->where('channelID', '=', $user->userID)->first();
            ?>
            
            @if(is_null($channelCheck))
            <!-- om användaren ej har kanal -->
<a href="{{URL::route('channel.create', array('id' => $user->userID)) }}">Skapa kanal</a><br>
            @endif
            @endif
            @endif
             @if(Auth::user())
            <!-- sätter variabler att senare testa mot i loopar för att skapa rekommendationer -->
            <?php
$userID = Auth::user()->userID;
            $favoriteIDs = DB::table('favorites')->join('sounds', 'sounds.soundID', '=', 'favorites.soundID')->join('channels', 'channels.channelID', '=', 'sounds.channelID')->get();
                 $favoriteCheck = DB::table('favorites')->first();
            /* vilka channels subbar användaren på, group by så det bara blir en av var */
            $channels = DB::table('subscribe')->join('channels', 'subscribe.channelID', '=', 'channels.channelID')->join('sounds', 'sounds.channelID', '=', 'channels.channelID')->groupBy('channels.channelID')->get();
            ?>


            @endif
          </div>
        </div>
        <div class="col-lg-8"  id="tabus">        
          <ul class="nav nav-tabs" role="tablist" >
            @if(Auth::check())
            @if(Auth::user()->userID == $user->userID)

            <li role="presentation" class="active"><a href="#chome" role="tab" data-toggle="tab">Rekommendationer</a></li>


 @endif
                 @endif 
                         <li class="dropdown"> 
            <!-- php för att hämta ut spellistor så vi kan presentera dessa i meny -->
                <?php
              /* behöver fylla en array senare */
              $array = '';
              /* hämtar playlists*/
              $playlists = DB::table('playlists')->where('userID', '=', $user->userID)->orderBy('created_at', 'ASC')->take(5)->get();
              /*kollar hur många resultat som går att ta ut så att vi kan använda detta i if-satser senare */
              $count = DB::table('playlists')->where('userID', '=', $user->userID)->orderBy('created_at', 'ASC')->take(5)->count();
              /* en variabel för o kolla om det är tomt */
              $playlistsCheck = DB::table('playlists')->where('userID', '=', $user->userID)->first();
              /* en foreach loop för att sätta in värden i vår array */
              foreach($playlists as $playlist){
              if($playlist->listID == $playlistsCheck->listID){
              /* det första värdet ska ej ha , */
              $array .= $playlist->listID;
              }
              else{
              /* de andra värdena ska skiljas med , */
              $array .= ',' . $playlist->listID;
              }
              }
              /* gör en array av värdena vi satt in i variabeln för arrayen */
              $lists = array_values(explode(',',$array,10));
              $li = '';
              /* med hjälp av att kolla hur många resultat vi fick gör vi variabler av värdena i arrayen */
              /* variabler för var resultat (max 5) */
              /* detta för att javascript och ny xml ej fungerar med foreach loop och id'n */
              if($count > 0){
              $listID1 = $lists[0]; 
              $list1 = DB::table('playlists')->where('listID', '=', $listID1)->first();
              $li .= '<li role="presentation"><a href="#list1" role="tab" data-toggle="tab">' . $list1->listTitle . '</a></li>';
              }
              if($count > 1){
              $listID2 = $lists[1];
              $list2 = DB::table('playlists')->where('listID', '=', $listID2)->first();
              $li .= '<li role="presentation"><a href="#list2" role="tab" data-toggle="tab">' . $list2->listTitle . '</a></li>';
              }
              if($count > 2){
              $listID3 = $lists[2];
              $list3 = DB::table('playlists')->where('listID', '=', $listID3)->first();
              $li .= '<li role="presentation"><a href="#list3" role="tab" data-toggle="tab">' . $list3->listTitle . '</a></li>';
              }
              if($count > 3){
              $listID4 = $lists[3];
              $list4 = DB::table('playlists')->where('listID', '=', $listID4)->first();
              $li .= '<li role="presentation"><a href="#list4" role="tab" data-toggle="tab">' . $list4->listTitle . '</a></li>';
              }
              if($count > 4){
              $listID5 = $lists[4];
              $list5 = DB::table('playlists')->where('listID', '=', $listID5)->first();
              $li .= '<li role="presentation"><a href="#list5" role="tab" data-toggle="tab">' . $list5->listTitle . '</a></li>';
              }
              $lo = html_entity_decode($li, ENT_QUOTES);
              ?>
             @if($count >0)
            <a href="#" data-toggle="dropdown" id="pil">Spellista<span class="caret"></span></a>
                                <ul class="dropdown-menu" role="menu">
                                    <?php echo $lo ?>
                                </ul>
                                @endif
                                           <li role="presentation"><a href="#fav" role="tab" data-toggle="tab">Favoriter</a></li>
                                     <li role="presentation"><a href="#fav" role="add" data-toggle="tab">+</a></li>
            <li class="dropdown">
   
 
           
          </ul>
          <script>
$('#btnReview').click(function(){
  $(".tab-content").removeClass("active");
  $(".tab-content:first-child").addClass("active");
});


</script>
          <br>
            <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8" id="container2">
            <div class="tab-content">
            <div role="tabpanel" class="tab-pane active" id="chome">
             <!-- kollar om user inloggad -->
           @if(Auth::check())
               <!-- kolla om user inloggad stämmer överens om det id man är på (show-funktion från controller -->
            @if(Auth::user()->userID == $user->userID)
            <h1> Ljudklipp för dig:</h1>
            <!-- gör loopar av tidigare variabler -->
           @if(is_null($favoriteCheck))
           <p>Inga rekommendationer</p>
           @else
          @foreach($favoriteIDs as $favoriteID)
          <?php
/* fixar lite variabler så vi kan testa mot dem */
        
          $userID = Auth::user()->userID;
          $soundID = $favoriteID->soundID;
          $tag = $favoriteID->tag;
/* hämtar ut från channels och sounds som INTE finns i favorites redan för användaren */
/* gör en query för att "or where" inte ska krocka med where */
/* variablen hämtar ut ljudklipp där titel eller tagg liknar de som användaren har i sina favoriter */
         $results = DB::table('channels')->join('sounds', 'sounds.channelID', '=', 'channels.channelID')->where('sounds.soundID', '!=', $soundID)
         ->where(function($query) use($tag) {
             $query ->where('sounds.tag', 'LIKE', '%' . $tag . '%')
         ->orWhere('sounds.title', 'LIKE', '%' . $tag . '%');
         })->orderBy('sounds.created_at', 'ASC')->paginate(2);
         ?>
         @endforeach
         <!-- kör en loop för alla resultat -->
             @foreach($results as $result)
@if($result->channelID != $userID)
  <div class="row">
              <h3><a href="http://localhost/Herz/public/sound/{{$result->soundID}}">{{ $result->title }}</a></h3><br></div>
               <img src="{{ $result->podpicture }}" style="width:145px;height:159px;"/><br>
               
                <audio controls>
  <source src="{{ $result->URL }}" type="audio/ogg">
  <source src="{{ $result->URL }}" type="audio/mpeg">
Your browser does not support the audio element.
</audio>    <br><br><br><br>

            <p>Kanal <a href="http://localhost/Herz/public/channel/{{ $result->channelID }}">{{$result->channelname}}</a></p>
              
              @endif
             
             
             @endforeach
@endif
<!-- slut på ljudklipprekommendationer -->
<!-- rekommenderade kanaler -->

            
             
            
              @endif
              @endif

</div>


                <div role="tabpanel" class="tab-pane" id="fav">
  <h1>Favoriter</h1>
  <!-- Innehåll här (Favoriter) -->
  </div>
   <div role="tabpanel" class="tab-pane" id="add">


  <h1>Namnlös</h1>
  
</div>
<!-- kollar om resultaten finns o kör dom -->
@if($count > 0)
   <div role="tabpanel" class="tab-pane" id="list1">


  <h1>{{ $list1->listTitle}}</h1>
 <h6>{{ $list1->listDescription }}</h6>
  
                 
                    <form action="" method="put" name="play1" id="play">
                      <input type="hidden" name="listID" value="{{ $list1->listID }}" id="listID">
                      <button type="submit" class="btn btn-default btn-lg" id="play">
                        <span class="glyphicon glyphicon-expand" aria-hidden="true"></span>
                      </button>
                    </form> 
                                          <!-- en box som vi ska ladda in värden i senare -->
                    <div id="box1"></div>
                     @if(Auth::check())
                    @if(Auth::user()->userID == $user->userID )
                    {!!   Form::open(array('method' => 'DELETE', 'route' => array('playlist.destroy', $listID1))) !!}
                    {!! csrf_field() !!}
                    {!! Form::submit('X', array('class' => 'btn btn-danger', 'onclick' => 'return confirm("Säker på att du vill ta bort spellistan?");' )) !!}
                    {!! Form::close() !!}
                    @endif
                    @endif
</div>
   <script>

                      $('#play').submit(function(e){
                      e.preventDefault();
                      $("#box1").load( "http://localhost/Herz/public/player.html" );
     
                      var listID = $('#listID').val();
                      var listID = $.trim(listID);
                      var userID = $('#userID').val();
                      var userID = $.trim(userID); 
                      $.ajax({
                      url: 'http://localhost/Herz/public/list.php',
                      data: { listID: listID, userID: userID},
                      dataType: 'json',
                      success: function(data){            
                      }
                      });
                      });
                    </script>
@endif

@if($count > 1)
   <div role="tabpanel" class="tab-pane" id="list2">


  <h1>{{ $list2->listTitle}}</h1>
     <h6>{{ $list2->listDescription }}</h6>
  <form action="" method="put" name="play2" id="play2">
                      <input type="hidden" name="listID2" value="{{ $list2->listID }}" id="listID2">
                      <button type="submit" class="btn btn-default btn-lg" id="play2">
                        <span class="glyphicon glyphicon-expand" aria-hidden="true"></span>
                      </button>
                    </form>  
                    <div id="box2"></div>
                    <!-- om man äger spellistan kan man radera den -->
                    @if(Auth::check())
                    @if(Auth::user()->userID == $user->userID )
                    {!!   Form::open(array('method' => 'DELETE', 'route' => array('playlist.destroy', $listID2))) !!}
                    {!! csrf_field() !!}
                    {!! Form::submit('X', array('class' => 'btn btn-danger', 'onclick' => 'return confirm("Säker på att du vill ta bort spellistan?");' )) !!}
                    {!! Form::close() !!}
                    @endif
                    @endif
                    <script>
                      $('#play2').submit(function(e){
                      e.preventDefault();
                      $("#box2").load( "http://localhost/Herz/public/player.html" );
                      var listID2 = $('#listID2').val();
                      var listID2 = $.trim(listID2);
                      var userID2 = $('#userID2').val();
                      var userID2 = $.trim(userID2); 
                      $.ajax({
                      url: 'http://localhost/Herz/public/list2.php',
                      data: { listID2: listID2, userID2: userID2},
                      dataType: 'json',
                      success: function(data){            
                      }
                      });
                      });
                    </script>                    
</div>
@endif
@if($count > 2)
   <div role="tabpanel" class="tab-pane" id="list3">

  
  <h1>{{ $list3->listTitle}}</h1>
    <h6>{{ $list3->listDescription }}</h6>
    <form action="" method="put" name="play3" id="play3">
                      <input type="hidden" name="listID3" value="{{ $list3->listID }}" id="listID3">
                      <button type="submit" class="btn btn-default btn-lg" id="play3">
                        <span class="glyphicon glyphicon-expand" aria-hidden="true"></span>
                      </button>
                    </form>  
                    <div id="box3"></div>
                    <!-- om man äger spellistan kan man radera den -->
                    @if(Auth::check())
                    @if(Auth::user()->userID == $user->userID )
                    {!!   Form::open(array('method' => 'DELETE', 'route' => array('playlist.destroy', $listID3))) !!}
                    {!! csrf_field() !!}
                    {!! Form::submit('X', array('class' => 'btn btn-danger', 'onclick' => 'return confirm("Säker på att du vill ta bort spellistan?");' )) !!}
                    {!! Form::close() !!}
                    @endif
                    @endif
                    <script>
                      $('#play3').submit(function(e){
                      e.preventDefault();
                      $("#box3").load( "http://localhost/Herz/public/player.html" );
                      var listID3 = $('#listID3').val();
                      var listID3 = $.trim(listID3);
                      var userID3 = $('#userID3').val();
                      var userID3 = $.trim(userID3); 
                      $.ajax({
                      url: 'http://localhost/Herz/public/list3.php',
                      data: { listID3: listID3, userID3: userID3},
                      dataType: 'json',
                      success: function(data){            
                      }
                      });
                      });
                    </script>                    
</div>
@endif
@if($count > 3)
   <div role="tabpanel" class="tab-pane" id="list4">

 
  <h1>{{$list4->listTitle}}</h1>
   <h6>{{ $list4->listDescription }}</h6>
   <form action="" method="put" name="play4" id="play4">
                      <input type="hidden" name="listID4" value="{{ $list4->listID }}" id="listID4">
                      <button type="submit" class="btn btn-default btn-lg" id="play4">
                        <span class="glyphicon glyphicon-expand" aria-hidden="true"></span>
                      </button>
                    </form>  
                    <div id="box4"></div>
                    <!-- om man äger spellistan kan man radera den -->
                    @if(Auth::check())
                    @if(Auth::user()->userID == $user->userID )
                    {!!   Form::open(array('method' => 'DELETE', 'route' => array('playlist.destroy', $listID4))) !!}
                    {!! csrf_field() !!}
                    {!! Form::submit('X', array('class' => 'btn btn-danger', 'onclick' => 'return confirm("Säker på att du vill ta bort spellistan?");' )) !!}
                    {!! Form::close() !!}
                    @endif
                    @endif
                    <script>
                      $('#play4').submit(function(e){
                      e.preventDefault();
                      $("#box4").load( "http://localhost/Herz/public/player.html" );
                      var listID4 = $('#listID4').val();
                      var listID4 = $.trim(listID4);
                      var userID4 = $('#userID4').val();
                      var userID4 = $.trim(userID4); 
                      $.ajax({
                      url: 'http://localhost/Herz/public/list4.php',
                      data: { listID4: listID4, userID4: userID4},
                      dataType: 'json',
                      success: function(data){            
                      }
                      });
                      });
                    </script>                    
</div>
@endif
@if($count > 4)
   <div role="tabpanel" class="tab-pane" id="list5">


  <h1> {{ $list5->listTitle }}</h1>

   <h6>{{ $list5->listDescription }}</h6>
   <form action="" method="put" name="play5" id="play5">
                      <input type="hidden" name="listID5" value="{{ $list5->listID }}" id="listID5">
                      <button type="submit" class="btn btn-default btn-lg" id="play5">
                        <span class="glyphicon glyphicon-expand" aria-hidden="true"></span>
                      </button>
                    </form>  
                    <div id="box5"></div>
                    <!-- om man äger spellistan kan man radera den -->
                    @if(Auth::check())
                    @if(Auth::user()->userID == $user->userID )
                    {!!   Form::open(array('method' => 'DELETE', 'route' => array('playlist.destroy', $listID5))) !!}
                    {!! csrf_field() !!}
                    {!! Form::submit('X', array('class' => 'btn btn-danger', 'onclick' => 'return confirm("Säker på att du vill ta bort spellistan?");' )) !!}
                    {!! Form::close() !!}
                    @endif
                    @endif
                    <script>
                      $('#play5').submit(function(e){
                      e.preventDefault();
                      $("#box5").load( "http://localhost/Herz/public/player.html" );
                      var listID5 = $('#listID5').val();
                      var listID5 = $.trim(listID5);
                      var userID5 = $('#userID5').val();
                      var userID5 = $.trim(userID5); 
                      $.ajax({
                      url: 'http://localhost/Herz/public/list5.php',
                      data: { listID5: listID5, userID5: userID5},
                      dataType: 'json',
                      success: function(data){            
                      }
                      });
                      });
                    </script>                    
</div>
@endif

  </div>
</div>

  </div>
</div>
<!-- slut på rekommendationer -->
   
          </div>
        </div>

      </div>

      </div>
      </div>
      </div>


@stop
