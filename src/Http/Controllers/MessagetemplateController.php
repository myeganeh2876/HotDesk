<?php

namespace TCG\Voyager\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Messagetemplate;
use Illuminate\Http\Request;

class MessagetemplateController extends Controller{

    public function set(Request $request){
        $request->validate([
            'content' => 'required|string',
        ]);
        $messagetemplate = auth()->user()->messagetemplate()->create([
            'content' => $request->get('content'),
        ]);
        return ['success' => true, 'data' => $messagetemplate];
    }

    public function delete(Request $request){
        $request->validate([
            'id' => 'exists:messagetemplates',
        ]);
        $messagetemplate = Messagetemplate::find($request->id);
        if($messagetemplate->user_id == auth()->user()->id){
            $messagetemplate->delete();
            return ['success' => true];
        } else {
            return ['success' => false, 'error' => 'cannot_access_this_note'];
        }
    }

}
