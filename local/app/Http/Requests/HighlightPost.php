<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use User;

class HighlightPost extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    function __construct(){
      $this->max = User::videoSize();
    }

    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
          'head' => 'required',
          'zone_id' => 'required',
          'cover' => 'image|dimensions:width=640,height=360',
          'clip' => 'required|mimes:mp4|max:'.$this->max
        ];
    }

    public function messages()
    {
      return [
        'cover.image' => "ต้องเป็นไฟล์รูปภาพ เท่านั้นค่ะ",
        'cover.dimensions' => "ขนาดภาพไม่ตรง กับที่เรากำหนดค่ะ",
        'clip.required' => "กรุณาเลือกไฟล์วิดีโอ ด้วยค่ะ",
        'clip.mimes' => "ต้องเป็นไฟล์ MP4 เท่่านั้นค่ะ",
        'clip.max' => "ขนาดไฟล์ใหญ่กว่าที่กำหนดไว้ค่ะ"
        // 'cover.max' => "ขนาดไฟล์ใหญ่กว่าที่กำหนดไว้ค่ะ"
      ];
    }
}
