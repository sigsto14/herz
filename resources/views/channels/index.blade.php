@extends('template')

@section('container')

<!DOCTYPE HTML>

<title>Users</title>

<body>



<div class="container">
<div class="col-md-12" id="container"><br><br>
<p class="titles">Kanaler:</p>
<table class="table">

<th>Kanalnamn</th>
<th>Information</th></tr>


<?php
 $channels = DB::table('channels')->join('users', 'users.userID', '=', 'channels.channelID')->get();
?>
			
			
			@foreach($channels as $channel)
			<tr>	
			<td><a href="http://localhost/Herz/public/channel/{{ $channel->channelID }}">{{ $channel->channelname }}</a></td>
			<td>{{ $channel->information }}</td>

		
				@endforeach
			
			
				
				</tr>
			
</table>

</div>			 
	</div>


</body>
@stop