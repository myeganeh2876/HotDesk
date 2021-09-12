<?php

namespace TCG\Voyager\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class personalizemenus extends Controller{

    public function set(Request $request){
        $request->validate([
            'title' => 'required|string',
            'link' => 'required|string',
            'target' => 'required|string',
            'position' => 'required|integer',
        ]);
        if(!auth()->user()->personalizemenu()->exists()){
            auth()->user()->personalizemenu()->create([
                'data' => [
                    ['title' => $request->title, 'link' => $request->link, 'target' => $request->target],
                ],
            ]);
            return ['success' => true, 'data' => auth()->user()->personalizemenu()->get()];
        } else {
            $personalizemenu = auth()->user()->personalizemenu()->first();
            $data = $personalizemenu->data;
            array_splice($data, $request->position, 0, [
                [
                    'title' => $request->title,
                    'link' => $request->link,
                    'target' => $request->target,
                ],
            ]);
            $personalizemenu->data = $data;
            $personalizemenu->save();
            return ['success' => true, 'data' => auth()->user()->personalizemenu()->get()];
        }
    }

    public function delete(Request $request){
        $request->validate([
            'index' => 'required|integer',
        ]);
        if(auth()->user()->personalizemenu()->exists()){
            $personalizemenu = auth()->user()->personalizemenu()->first();
            $data = $personalizemenu->data;
            array_splice($data, ($request->index - 1), 1);
            $personalizemenu->data = $data;
            $personalizemenu->save();
            return ['success' => true, 'data' => auth()->user()->personalizemenu()->get()];
        } else {
            return ['success' => false, 'error' => 'menu_is_empty'];
        }
    }

    public function update(Request $request){
        $request->validate([
            'startposition' => 'required|integer',
            'newposition' => 'required|integer',
        ]);
        if(auth()->user()->personalizemenu()->exists()){
            $personalizemenu = auth()->user()->personalizemenu()->first();
            $data = $personalizemenu->data;
            $keys = array_keys($data);
            if(isset($keys[$request->startposition]) && $request->newposition != -1){
                $menu = $data[$keys[$request->startposition]];
                array_splice($data, $request->startposition, 1);
                array_splice($data, $request->newposition, 0, [$menu]);
            }
            $personalizemenu->data = $data;
            $personalizemenu->save();
            return ['success' => true, 'data' => auth()->user()->personalizemenu()->get()];
        } else {
            return ['success' => false, 'error' => 'menu_is_empty'];
        }
    }
}
