<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class MainController extends Controller
{
    public function getFetchSkills(Request $request)
    {
        $validator	=	\Validator::make($request->all(),	[
            'str'=>'required'
        ]);
        if	($validator->fails()) {
            return response()->json(['result'=>'fail','error'=>$validator->errors()]);
        }

        $string = $request['str'];

        $searchString = strtolower($request['string']);

        $results = \DB::table('skills')
            ->select('skill')
            ->whereRaw('lower(skill) like \'%'.$searchString.'%\'')
            ->get();

        return response()->json(['result'=>'success','records'=>$results]);

    }
}
