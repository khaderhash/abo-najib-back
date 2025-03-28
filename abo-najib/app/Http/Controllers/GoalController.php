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


    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:20',
                'time' => 'required|date',
                'price' =>'required|numeric',
                'category' => 'required|string',
                'collectedmoney'=>'required|numeric',
            ]);

            if ($validator->fails()) {
                return $this->ApiResponseTrait(null, $validator->errors(), 400);
            }


            $goal = Goal::create([
                'name' => $request->name,
                'time' => $request->time,
                'price' => $request->price,
                'category' => $request->category,
                'collectedmoney'=> $request->collectedmoney,
                'user_id' => Auth::id(),

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
    public function update(Request $request, $id)
{
    try {
        $goal = Goal::where('id', $id)->where('user_id', Auth::id())->first();

        if (!$goal) {
            return $this->ApiResponseTrait(null, 'Goal not found', 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|string|max:20',
            'time' => 'sometimes|date',
            'price' => 'sometimes|numeric',
            'category' => 'sometimes|string',
            'collectedmoney' => 'sometimes|numeric',
        ]);

        if ($validator->fails()) {
            return $this->ApiResponseTrait(null, $validator->errors(), 400);
        }

        // تحديث البيانات فقط إذا تم إرسالها في الطلب
        $goal->update($request->only(['name', 'time', 'price', 'category', 'collectedmoney']));

        return $this->ApiResponseTrait(new GoalResource($goal), 'Goal updated successfully', 200);

    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
}

}
