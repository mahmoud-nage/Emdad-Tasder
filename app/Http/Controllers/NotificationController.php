<?php

namespace App\Http\Controllers;

use App\BlogDepartment;
use App\Notification;
use App\Seller;
use App\User;
use Illuminate\Http\Request;

class NotificationController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //dd(BlogDepartment::select("*")->get()->toArray());
        $notifications = Notification::orderBy('created_at', 'desc')->get();
        return view('notifications.index', compact('notifications'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('notifications.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate(request() , [
            'title' => 'required',
            'body' => 'required',
          ]);

        $notification = Notification::create([
            'title' => $request->input('title'),
            'body' => $request->input('body'),
        ]);
//        $notification->users()->attach($user);
//        dd(User::where('user_type','customer')->pluck('id')->toArray());
        notify_users($request->input('title'), $request->input('body'),
            User::where('user_type', 'customer')->pluck('id')->toArray(), $notification);
        flash(__('notification has been sent successfully'))->success();
        return redirect()->route('notification.index');

        flash(__('Something went wrong'))->error();
        return back();
    }


    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $seller = Seller::findOrFail(decrypt($id));
        return view('blogDepartments.edit', compact('seller'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        flash(__('Something went wrong'))->error();
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $seller = BlogDepartment::findOrFail($id);
        if (Seller::destroy($id)) {
            flash(__('Department has been deleted successfully'))->success();
            return redirect()->route('blogDepartments.index');
        }

        flash(__('Something went wrong'))->error();
        return back();
    }
}
