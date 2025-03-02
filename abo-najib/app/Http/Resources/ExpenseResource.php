<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ExpenseResource extends JsonResource
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
            'amount' => $this->amount,    // المبلغ
            'category' => $this->category, // الفئة
            'description' => $this->description, // الوصف
            'date' => $this->date,         // التاريخ
            'user_id' => $this->user_id,   // معرف المستخدم
            'created_at' => $this->created_at, // تاريخ الإنشاء
            'updated_at' => $this->updated_at, // تاريخ التحديث
        ];
    }
}
