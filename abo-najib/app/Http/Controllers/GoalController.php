<?php

namespace App\Http\Controllers;

use App\Http\Resources\GoalResource;
use App\Models\Goal;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiResponseTrait;
use Illuminate\Support\Facades\Validator;

use function Pest\Laravel\get;

class GoalController extends Controller

{

    use ApiResponseTrait;
    public function index(){


        $goal = GoalResource::collection(Goal::get());
        return $this->ApiResponseTrait($goal,'donee',200);
}
public function show($id){
    $goal = Goal::find($id);
    if ($goal){
        return $this->ApiResponseTrait(new GoalResource($goal),'done',200);
    }
    return $this->ApiResponseTrait(null,'faield',404);
}
public function store(Request $request)
{
    $validator = Validator::make($request->all(), [
        'name' => 'required|max:20',
        'time' => 'required',
        'price' => 'required',
        'category' => 'required',
    ]);

    if ($validator->fails()) {
        return $this->ApiResponseTrait(null, $validator->errors(), 400);
    }

    $goal = Goal::create($request->all());

    if ($goal) {
        return $this->ApiResponseTrait(new GoalResource($goal), 'The goal has been saved successfully.', 201);
    }

    return $this->ApiResponseTrait(null, 'The goal could not be saved.', 400);
}
// public function store(request $request){
// $validator= Validator::make($request->all(),
// [
//     'name'=>'required|max:20',
//     'time'=>'required',
//     'price'=>'required',
//     'category'=>'required',

// ]);
// if ($validator->fails()){
//     return $this->ApiResponseTrait(null,$validator->errors(),400);
// }

//     $goal =Goal::create($request->all());

//     if ($goal){
//     return $this->ApiResponseTrait(new GoalResource($goal),'the goal save',201);

//     }
//     return $this->ApiResponseTrait(null,'the goal not save',400);

// }
public function update(request $request,$id){

    $validator= Validator::make($request->all(),

    [
    'price'=>'required',]);
    if ($validator->fails()){
        return $this->ApiResponseTrait(null,$validator->errors(),400);
    }
    $goal= Goal::find($id);

    if(!$goal){
        return $this->ApiResponseTrait(null,'the goal not found',404);
    }
    $goal->update($request->all());

    if ($goal){
        return $this -> ApiResponseTrait(new GoalResource($goal),'the goal update',201);
    }
}
}
