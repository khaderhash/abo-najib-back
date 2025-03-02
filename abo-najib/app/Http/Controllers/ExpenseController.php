<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Http\Resources\ExpenseResource;
use App\Models\Expense;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class ExpenseController extends Controller
{
    use ApiResponseTrait;

    /**
     * عرض جميع المصاريف الخاصة بالمستخدم الحالي.
     */
    public function index()
    {
        // جلب المصاريف الخاصة بالمستخدم الحالي باستخدام الـ Auth
        $expenses = ExpenseResource::collection(Expense::where('user_id', Auth::id())->get());

        // إرجاع المصاريف كاستجابة JSON
        return $this->ApiResponseTrait($expenses, 'Expenses retrieved successfully', 200);
    }

    /**
     * عرض المصاريف الخاصة بمعرف محدد.
     */
    public function show($id)
    {
        $expense = Expense::where('id', $id)->where('user_id', Auth::id())->first();

        if ($expense) {
            return $this->ApiResponseTrait(new ExpenseResource($expense), 'Expense retrieved successfully', 200);
        }

        return $this->ApiResponseTrait(null, 'Expense not found', 404);
    }

    /**
     * إضافة مصروف جديد.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'amount' => 'required|numeric',
            'category' => 'required|string',
            'description' => 'nullable|string',
            'date' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->ApiResponseTrait(null, $validator->errors(), 400);
        }

        $expense = Expense::create([
            'amount' => $request->amount,
            'category' => $request->category,
            'description' => $request->description,
            'date' => $request->date,
            'user_id' => Auth::id(), // ربط المصروف بالمستخدم
        ]);

        if ($expense) {
            return $this->ApiResponseTrait(new ExpenseResource($expense), 'Expense created successfully', 201);
        }

        return $this->ApiResponseTrait(null, 'Failed to create expense', 400);
    }

    /**
     * حذف مصروف.
     */
    public function destroy($id)
    {
        $expense = Expense::where('id', $id)->where('user_id', Auth::id())->first();

        if (!$expense) {
            return $this->ApiResponseTrait(null, 'Expense not found', 404);
        }

        $expense->delete();

        return $this->ApiResponseTrait(null, 'Expense deleted successfully', 200);
    }
}
