<?php

namespace App\Http\Controllers\API\Web;

use App\Branch;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BranchController extends Controller
{
    public function index(Request $request)
    {
        $branches = Branch::all();
        return response()->json(['status' => 200 , 'data' => $branches]);
    }
}
