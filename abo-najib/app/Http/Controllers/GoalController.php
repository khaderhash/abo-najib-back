<?php


namespace App\Http\Controllers;

use App\Http\Resources\GoalResource;
use App\Models\Goal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class GoalController extends Controller
{
    use ApiResponseTrait;

    /**
     * عرض جميع الأهداف الخاصة بالمستخدم الحالي.
     */
    public function index()
    {
        $goals = GoalResource::collection(Goal::where('user_id', Auth::id())->get());
        return $this->ApiResponseTrait($goals, 'Goals retrieved successfully', 200);
    }

    /**
     * عرض هدف معين
     */
    public function show($id)
    {
        $goal = Goal::where('id', $id)->where('user_id', Auth::id())->first();

        if ($goal) {
            return $this->ApiResponseTrait(new GoalResource($goal), 'Goal retrieved successfully', 200);
        }

        return $this->ApiResponseTrait(null, 'Goal not found', 404);
    }

    /**
     * إضافة هدف جديد
     */
    // public function store(Request $request)
    // {
    //     $validator = Validator::make($request->all(), [
    //         'name' => 'required|string|max:20',
    //         'time' => 'required|date',
    //         'price' => 'required|numeric',
    //         'category' => 'required|string',
    //     ]);

    //     if ($validator->fails()) {
    //         return $this->ApiResponseTrait(null, $validator->errors(), 400);
    //     }
    //     if (!$request->has('name')) {
    //         return $this->ApiResponseTrait(null, 'Name is missing', 400);
    //     }
    //     $goal = Goal::create([
    //         'name' => $request->name,
    //         'time' => $request->time,
    //         'price' => $request->price,
    //         'category' => $request->category,
    //         'user_id' => Auth::id(), // ربط الهدف بالمستخدم
    //         'date' => now()->toDateString(),
    //     ]);

    //     if ($goal) {
    //         return $this->ApiResponseTrait(new GoalResource($goal), 'Goal created successfully', 201);
    //     }

    //     return $this->ApiResponseTrait(null, 'Failed to create goal', 400);
    // }

    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:20',
                'time' => 'required|date',
                'price' => 'required|numeric',
                'category' => 'required|string',
            ]);

            if ($validator->fails()) {
                return $this->ApiResponseTrait(null, $validator->errors(), 400);
            }

            // \Log::info($request->all());  // لتسجيل كل البيانات في ملف log

            $goal = Goal::create([
                'name' => $request->name,
                'time' => $request->time,
                'price' => $request->price,
                'category' => $request->category,
                'user_id' => Auth::id(),
                // 'date' => now()->toDateString(),
            ]);

            if ($goal) {
                return $this->ApiResponseTrait(new GoalResource($goal), 'Goal created successfully', 201);
            }

            return $this->ApiResponseTrait(null, 'Failed to create goal', 400);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }


    public function destroy($id)
    {
        $goal = Goal::where('id', $id)->where('user_id', Auth::id())->first();

        if (!$goal) {
            return $this->ApiResponseTrait(null, 'Goal not found', 404);
        }

        $goal->delete();

        return $this->ApiResponseTrait(null, 'Goal deleted successfully', 200);
    }
}

// namespace App\Http\Controllers;

// use App\Http\Resources\GoalResource;
// use App\Models\Goal;
// use Illuminate\Http\Request;
// use App\Http\Controllers\ApiResponseTrait;
// use Illuminate\Support\Facades\Validator;

// use function Pest\Laravel\get;

// class GoalController extends Controller

// {

//     use ApiResponseTrait;
//     public function index(){


//         $goal = GoalResource::collection(Goal::get());
//         return $this->ApiResponseTrait($goal,'donee',200);
// }
// public function show($id){
//     $goal = Goal::find($id);
//     if ($goal){
//         return $this->ApiResponseTrait(new GoalResource($goal),'done',200);
//     }
//     return $this->ApiResponseTrait(null,'faield',404);
// }
// public function store(Request $request)
// {
//     $validator = Validator::make($request->all(), [
//         'name' => 'required|max:20',
//         'time' => 'required',
//         'price' => 'required',
//         'category' => 'required',
//     ]);

//     if ($validator->fails()) {
//         return $this->ApiResponseTrait(null, $validator->errors(), 400);
//     }

//     $goal = Goal::create($request->all());

//     if ($goal) {
//         return $this->ApiResponseTrait(new GoalResource($goal), 'The goal has been saved successfully.', 201);
//     }

//     return $this->ApiResponseTrait(null, 'The goal could not be saved.', 400);
// }
// // public function store(request $request){
// // $validator= Validator::make($request->all(),
// // [
// //     'name'=>'required|max:20',
// //     'time'=>'required',
// //     'price'=>'required',
// //     'category'=>'required',

// // ]);
// // if ($validator->fails()){
// //     return $this->ApiResponseTrait(null,$validator->errors(),400);
// // }

// //     $goal =Goal::create($request->all());

// //     if ($goal){
// //     return $this->ApiResponseTrait(new GoalResource($goal),'the goal save',201);

// //     }
// //     return $this->ApiResponseTrait(null,'the goal not save',400);

// // }
// public function update(request $request,$id){

//     $validator= Validator::make($request->all(),

//     [
//     'price'=>'required',]);
//     if ($validator->fails()){
//         return $this->ApiResponseTrait(null,$validator->errors(),400);
//     }
//     $goal= Goal::find($id);

//     if(!$goal){
//         return $this->ApiResponseTrait(null,'the goal not found',404);
//     }
//     $goal->update($request->all());

//     if ($goal){
//         return $this -> ApiResponseTrait(new GoalResource($goal),'the goal update',201);
//     }
// }
// public function destroy($id){
//     $goal= Goal::find($id);

//     if(!$goal){
//         return $this->ApiResponseTrait(null,'the goal not found',404);
//     }
//     $goal->delete($id);
//     if ($goal){
//         return $this -> ApiResponseTrait(new GoalResource($goal),'the goal deleted',200);
//     }

// }
// }
