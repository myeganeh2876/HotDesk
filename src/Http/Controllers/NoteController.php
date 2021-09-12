<?php

namespace TCG\Voyager\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use TCG\Voyager\Models\Note;

class NoteController extends Controller{

    public function set(Request $request){

        $request->validate([
            'content' => 'required|string',
            'status' => 'required|in:red,green,yellow',
        ]);
        $forall = false;
        if(auth()->user()->hasRole('admin')){
            $forall = true;
        }

        $note = auth()->user()->note()->create([
            'content' => $request->get('content'),
            'status' => $request->status,
            'forall' => $forall,
        ]);
        return ['success' => true, 'data' => $note];
    }

    public function delete(Request $request){
        $request->validate([
            'id' => 'exists:notes',
        ]);
        $note = Note::find($request->id);
        if($note->user_id == auth()->user()->id){
            $note->delete();
            return ['success' => true];
        } else {
            return ['success' => false, 'error' => 'cannot_access_this_note'];
        }
    }

}
