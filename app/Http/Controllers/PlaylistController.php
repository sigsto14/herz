<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Sound;
use App\Playlist;
use App\Favorite;
use Auth;
use Fetch;
use mysqli;
use App\Channel;
use Validator;
use DB;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Symfony\Component\HttpFoundation\File;
use Eloquent;
use Storage;

class PlaylistController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       return view('playlist.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
  
    }
        

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(Auth::check()){
$playlists = DB::table('playlists')->where('userID', '=', Auth::user()->userID)->count();
}
if($playlists < 5){
   $validator = Validator::make($request->all(), [
                'listTitle' => 'required|max:255|',
            'listDescription' => 'required|',
            'userID' => 'required|',

            ]);
       if ($validator->fails()) {
            return back()
                        ->withErrors($validator)
                        ->withInput();

          }

       $playlist = new Playlist();
       
       $playlist->listTitle = $request->get('listTitle');
       $playlist->listDescription = $request->get('listDescription');
       $playlist->userID = $request->get('userID');
       $playlist->save();
       return back();

   }
   else {
return back()->
withError('Du har redan fem spellistor! Radera spellistor och försök igen.');

   }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
$playlist = Playlist::find($id);
return view('playlist.show', compact('playlist'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
       
   $playlist = Playlist::find($id);
       
  return view('playlist.index', compact('playlist'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $userID = Auth::user()->userID;
        $listID = $request->get('listID');
     
$addSounds = Playlist::find($listID);

if(!is_null($addSounds)){
if(is_null($addSounds->soundIDs)){
   
$addSounds->soundIDs = $request->get('soundID');
}
else if (!is_null($addSounds->soundIDs)){
   
   $addSounds->soundIDs = $addSounds->soundIDs . ',' . $request->get('soundID'); 
}
}
$addSounds->save();

return back();


            }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $playlist = Playlist::find($id);
        $playlist->delete();
        return back();
    }

        public function taBort(Request $request)
    {
        /* funktion för att radera bara ett värde ur arrayen soundIDs i playlists */
        $listID = $request->listID;
        $soundID = $request->soundID;

        $playlist = Playlist::where('listID', '=', $listID)->first();

        $array = array_values(explode(',',$playlist->soundIDs,13));
if (in_array($soundID, $array)) 
{
    unset($array[array_search($soundID ,$array)]);
}

$array2 = implode(',', $array);
$playlist->soundIDs = $array2;
$playlist->save();
     return back()->
     withMessage('Klipp borttaget från spellista');
          }


        public function redigera(Request $request){
            /* funktion för att redigera titel och beskrivning */
        $listID = $request->listID;
/* gör variabel av listan som stämmer överens med det inmatade listID't */
        $playlist = Playlist::where('listID', '=', $listID)->first();
        /* ändrar värdena i tabellen till de inmatade och sparar */
        $playlist->listTitle = $request->listTitle;
        $playlist->listDescription = $request->listDescription;
        $playlist->save();

        /* skickar tillbaka med meddelande */
         return back()->
     withMessage('Ändringar sparade');
        }
}
