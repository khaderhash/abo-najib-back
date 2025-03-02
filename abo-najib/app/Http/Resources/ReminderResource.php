<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReminderResource extends JsonResource
{
    /**
     * تحويل المورد إلى مصفوفة.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,         // العنوان
            'description' => $this->description, // الوصف
            'reminder_date' => $this->reminder_date, // تاريخ التذكير
            'user_id' => $this->user_id,     // معرف المستخدم
            'created_at' => $this->created_at, // تاريخ الإنشاء
            'updated_at' => $this->updated_at, // تاريخ التحديث
        ];
    }
}
