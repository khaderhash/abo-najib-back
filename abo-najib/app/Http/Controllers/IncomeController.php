<?php

namespace App\Http\Controllers;

use App\Http\Resources\IncomeResource;
use App\Models\Income;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class IncomeController extends Controller
{
    use ApiResponseTrait;

    /**
     * عرض جميع المداخيل الخاصة بالمستخدم الحالي.
     */
    public function index()
    {
        $incomes = IncomeResource::collection(Income::where('user_id', Auth::id())->get());
        return $this->ApiResponseTrait($incomes, 'Incomes retrieved successfully', 200);
    }

    /**
     * عرض دخل معين.
     */
    public function show($id)
    {
        $income = Income::where('id', $id)->where('user_id', Auth::id())->first();

        if ($income) {
            return $this->ApiResponseTrait(new IncomeResource($income), 'Income retrieved successfully', 200);
        }

        return $this->ApiResponseTrait(null, 'Income not found', 404);
    }

    /**
     * إضافة دخل جديد.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'amount' => 'required|numeric', // المبلغ
            'source' => 'required|string|max:255', // مصدر الدخل
        ]);

        if ($validator->fails()) {
            return $this->ApiResponseTrait(null, $validator->errors(), 400);
        }

        $income = Income::create([
            'amount' => $request->amount,
            'source' => $request->source,
            'user_id' => Auth::id(), // ربط الدخل بالمستخدم
        ]);

        if ($income) {
            return $this->ApiResponseTrait(new IncomeResource($income), 'Income created successfully', 201);
        }

        return $this->ApiResponseTrait(null, 'Failed to create income', 400);
    }

    /**
     * حذف دخل.
     */
    public function destroy($id)
    {
        $income = Income::where('id', $id)->where('user_id', Auth::id())->first();

        if (!$income) {
            return $this->ApiResponseTrait(null, 'Income not found', 404);
        }

        $income->delete();

        return $this->ApiResponseTrait(null, 'Income deleted successfully', 200);
    }
}
