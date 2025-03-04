<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GoalResource extends JsonResource
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
            'name' => $this->name,            // اسم الهدف
            'time' => $this->time,            // الوقت المحدد
            'price' => $this->price,          // المبلغ
            'category' => $this->category,    // الفئة
            'user_id' => $this->user_id,      // معرف المستخدم
            'created_at' => $this->created_at, // تاريخ الإنشاء
            'updated_at' => $this->updated_at, // تاريخ التحديث
        ];
    }
}
