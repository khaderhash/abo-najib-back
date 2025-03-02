<?php

namespace App\Http\Controllers;

use App\Http\Resources\ReminderResource;
use App\Models\Reminder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ReminderController extends Controller
{
    use ApiResponseTrait;

    /**
     * عرض جميع التذكيرات الخاصة بالمستخدم الحالي.
     */
    public function index()
    {
        $reminders = ReminderResource::collection(Reminder::where('user_id', Auth::id())->get());
        return $this->ApiResponseTrait($reminders, 'Reminders retrieved successfully', 200);
    }

    /**
     * عرض تذكير معين.
     */
    public function show($id)
    {
        $reminder = Reminder::where('id', $id)->where('user_id', Auth::id())->first();

        if ($reminder) {
            return $this->ApiResponseTrait(new ReminderResource($reminder), 'Reminder retrieved successfully', 200);
        }

        return $this->ApiResponseTrait(null, 'Reminder not found', 404);
    }

    /**
     * إضافة تذكير جديد.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'content' => 'required|string|max:255', // محتوى التذكير
            'date' => 'required|date', // تاريخ التذكير
        ]);

        if ($validator->fails()) {
            return $this->ApiResponseTrait(null, $validator->errors(), 400);
        }

        $reminder = Reminder::create([
            'content' => $request->content,
            'date' => $request->date,
            'user_id' => Auth::id(), // ربط التذكير بالمستخدم
        ]);

        if ($reminder) {
            return $this->ApiResponseTrait(new ReminderResource($reminder), 'Reminder created successfully', 201);
        }

        return $this->ApiResponseTrait(null, 'Failed to create reminder', 400);
    }

    /**
     * حذف تذكير.
     */
    public function destroy($id)
    {
        $reminder = Reminder::where('id', $id)->where('user_id', Auth::id())->first();

        if (!$reminder) {
            return $this->ApiResponseTrait(null, 'Reminder not found', 404);
        }

        $reminder->delete();

        return $this->ApiResponseTrait(null, 'Reminder deleted successfully', 200);
    }
}
