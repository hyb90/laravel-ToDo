<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Todo;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }
    public function fetchTodos(){
        return Todo::where('user_id' , '=' , Auth::user()->id )->orderBy('created_at','desc')->get();
    }
    public function fetchTodo($id){
        return Todo::findOrFail($id);
    }
    public function addTodo(Request $request){
        return Todo::create([
            'name'=>$request->input(['name']),
            'user_id'=> Auth::user()->id,
            'done'=>0
            ]);
    }
    public function updateTodo(Request $request,$id){
        return Todo::findOrFail($id)->update([
            'name'=>$request->input(['name']),
            ]);
        }
    public function deleteTodo($id){
            return Todo::destroy($id);
        }
    public function markAsDone($id){
            return Todo::findOrFail($id)->update([
                'done'=>1
                ]);
        }
}
