<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Code;
use App\Http\Resources\Code as CodeResource;
use App\User;
use App\UserCode;
use App\Http\Resources\CodeCollection;

class CodeController extends Controller
{
    /**
     * 列出所有识别码
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // dd(UserCode::all());
        return new CodeCollection(UserCode::all());
    }

    /**
     * 获取某个用户的识别码
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return new CodeResource($user->code);
    }

    /**
     * 为一个用户绑定识别码
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(User $user)
    {
        if($user->code == null){
            $random = null;
            do{
                $random = rand(111,999);
                // $random = 854;
                $flag = false;
                $result = UserCode::where('code',$random)->get()->isNotEmpty();
                // echo ($result);
            }while($result);
            $code = $user->code()->create(['code'=>$random]);
        }else{
            $code = $user->code;
        }
        // dd($user);
        return new CodeResource($code);

    }
}
