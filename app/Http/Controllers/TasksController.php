<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Task;    // 追加
use Auth;

class TasksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (\Auth::check()) { // 認証済みの場合
        //task一覧を取得
        // $tasks = Task::all();
        
        // 認証済みユーザを取得
        $user = \Auth::user();
        $tasks = $user->tasks()->orderBy('id', 'desc')->paginate(10);
        // $tasks = task::orderBy('id', 'desc')->paginate(10);
        
        // task一覧ビューでそれを表示
        return view('tasks.index', [
            'tasks' => $tasks,
            ]);
    }
    
    return view('welcome');
    
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // // idの値で投稿を検索して取得
        // $task = Task::findOrFail($id);
        // // 認証済みユーザ（閲覧者）がその投稿の所有者でない場合はトップページにリダイレクト
        // if (\Auth::id() !== $task->user_id) {
        //     return redirect('/');
        // }
        
        // if (\Auth::check()) { // 認証済みの場合
        $task = new Task;
        
        //task作成ビューを表示
        return view('tasks.create',[
            'task' => $task,
        ]);
        // }return view('welcome');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // // idの値で投稿を検索して取得
        // $taskid = Task::findOrFail($id);
        // // 認証済みユーザ（閲覧者）がその投稿の所有者でない場合はトップページにリダイレクト
        // if (\Auth::id() !== $taskid->user_id) {
        //     return redirect('/');
        // }      
        // if (\Auth::check()) { // 認証済みの場合
        // バリデーション
        $request->validate([
            'status' => 'required|max:10',// 追加
        ]);
        
        //taskを作成
        $task = new Task;
        $task->user_id = Auth::id();// 追加
        $task->status = $request->status;// 追加
        $task->content = $request->content;
        $task->save();
        
        //トップページへリダイレクトさせる
        return redirect('/');
    // }return view('welcome');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // idの値で投稿を検索して取得
        $task = Task::findOrFail($id);
        // 認証済みユーザ（閲覧者）がその投稿の所有者でない場合はトップページにリダイレクト
        if (\Auth::id() !== $task->user_id) {
            return redirect('/');
        }     
        // if (\Auth::check()) { // 認証済みの場合
        //idの値でtaskを検索して取得
        // $task = Task::findOrFail($id);
        
        // task詳細ビューでそれを表示
        return view('tasks.show',[
            'task' => $task,
        ]);
        // }return view('welcome');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // idの値で投稿を検索して取得
        $task = Task::findOrFail($id);
        // 認証済みユーザ（閲覧者）がその投稿の所有者でない場合はトップページにリダイレクト
        if (\Auth::id() !== $task->user_id) {
            return redirect('/');
        }        
        // if (\Auth::check()) { // 認証済みの場合
        //idの値でtaskを検索して取得
        // $task = Task::findOrFail($id);
        
        // task編集ビューでそれを表示
        return view('tasks.edit',[
            'task' => $task,
        ]);
        // }return view('welcome');
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
        // idの値で投稿を検索して取得
        $task = Task::findOrFail($id);
        // 認証済みユーザ（閲覧者）がその投稿の所有者でない場合はトップページにリダイレクト
        if (\Auth::id() !== $task->user_id) {
            return redirect('/');
        }     
        // if (\Auth::check()) { // 認証済みの場合
        // バリデーション
        $request->validate([
            'status' => 'required|max:10',// 追加
        ]);
        
        //idの値でtaskを検索して取得
        // $task = Task::findOrFail($id);
        // taskを更新
        $task->user_id = Auth::id();// 追加
        $task->status = $request->status;// 追加
        $task->content = $request->content;
        $task->save();
        
        // トップページへリダイレクトさせる
        return redirect('/');
        
        // }return view('welcome');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        // idの値でtaskを検索して取得
        $task = \App\Task::findOrFail($id);
        
        // 認証済みユーザ（閲覧者）がその投稿の所有者である場合は、投稿を削除
        if (\Auth::id() === $task->user_id) {
            $task->delete();
        }        
        
        // // taskを削除
        // $task->delete();
        
        // トップページへリダイレクトさせる
        return redirect('/');

    }
    
}
