<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Policy;

class PolicyController extends Controller
{

    public function index($type)
    {
        $policy = Policy::where('name_en', $type)->first();
        return view('policies.index', compact('policy'));
    }

    //updates the policy pages
    public function store(Request $request){

        $this->validate(request() , [
            'name_ar' => 'required',
            'name_en' => 'required',
            'content_ar' => 'required',
            'content_en' => 'required',
        ]);

        $policy = Policy::where('name_en', $request->name_en)->first();
        $policy->name_ar = $request->name_ar;
        $policy->name_en = $request->name_en;
        $policy->content_ar = $request->content_ar;
        $policy->content_en = $request->content_en;
        $policy->save();

        flash($request->name_en.' updated successfully');
        return back();
    }
}
