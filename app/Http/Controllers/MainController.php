<?php

namespace App\Http\Controllers;

use App\Skill;
use App\User_Skill;
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

        $searchString = strtolower($string);

        $results = \DB::table('skills')
            ->select('skill')
            ->whereRaw('lower(skill) like \'%'.$searchString.'%\'')
            ->get();

        return response()->json(['result'=>'success','matches'=>$results]);

    }

    public function postSaveSkills(Request $request)
    {
        //print_r("JSON received is : " . $request['json']);
        $validator	=	\Validator::make($request->all(),	[
            'json'=>'required'
        ]);
        if	($validator->fails()) {
            return response()->json(['result'=>'fail','error'=>$validator->errors()]);
        }

        $user_id = 1;
        if($request->has('user_id'))
                $user_id=$request['user_id'];

        //print_r("JSON received is : " . $request['json']);
        $skills = json_decode($request['json']);

        foreach ($skills as $skill)
        {
            /* Check if skill is already present in database */
            $result = \DB::table('skills')
                ->where('skill' ,'=', $skill)
                ->first();

            if($result == null) //Skill is already present in database
            {
                $result = new Skill();
                $result->skill = $skill;
                $result->save();
            }

            /* Check if relationship is already present in database */
            $resultRelationship = \DB::table('user_skills')
                ->where('skill_id' ,'=', $result->id)
                ->where('user_id' ,'=', $user_id)
                ->get();

            if($resultRelationship == null) /* Saves only if this relationship does not already exist */
            {
                $relationship = new User_Skill();
                $relationship->skill_id = $result->id;
                $relationship->user_id = $user_id;

                $relationship->save();
            }
        }

        return redirect()->route('chips.home');

    }
}
