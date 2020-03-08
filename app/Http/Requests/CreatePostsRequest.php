<?php

namespace App\Http\Requests;

use App\Rules\Uppsercase;
use Illuminate\Foundation\Http\FormRequest;

class CreatePostsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'title' => ['required', 'max:50' ],
            'description' => 'required',
            'file'=>['required','max:1024','mimes:jpg,jpeg,png,bmp,JPG']

        ];
    }
    public function messages()
    {
        return [
            'title.required' => 'لطفا عنوان مورد نظر خود را وارد کنید',
            'title.max' => 'عنوان مورد نظر باید دو کارکتر باشد!',
            'description.required' => 'توضیحات مطلب را وارد کنید',
            'file.required'=>'انتخاب و آپلود عکس اجباری می باشد',
            'file.max'=>'حجکم عکس نباید بیشتر از 1 مگابایت باشد',
            'file.mimes'=>'فقط فایل های jpg و jpeg و png و bmp قابل قبول می باشد'
        ];
    }
}
