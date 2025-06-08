<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RoomRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'district' => 'required|string|max:255',
            'area' => 'required|integer|min:1',
            'max_people' => 'required|integer|min:1',
            'image' => 'nullable|image|max:2048'
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'Vui lòng nhập tiêu đề phòng trọ',
            'description.required' => 'Vui lòng nhập mô tả phòng trọ',
            'price.required' => 'Vui lòng nhập giá phòng trọ',
            'price.numeric' => 'Giá phòng trọ phải là số',
            'price.min' => 'Giá phòng trọ phải lớn hơn 0',
            'address.required' => 'Vui lòng nhập địa chỉ phòng trọ',
            'city.required' => 'Vui lòng chọn thành phố',
            'district.required' => 'Vui lòng chọn quận/huyện',
            'area.required' => 'Vui lòng nhập diện tích phòng trọ',
            'area.integer' => 'Diện tích phòng trọ phải là số nguyên',
            'area.min' => 'Diện tích phòng trọ phải lớn hơn 0',
            'max_people.required' => 'Vui lòng nhập số người tối đa',
            'max_people.integer' => 'Số người tối đa phải là số nguyên',
            'max_people.min' => 'Số người tối đa phải lớn hơn 0',
            'image.image' => 'File phải là hình ảnh',
            'image.max' => 'Kích thước hình ảnh không được vượt quá 2MB'
        ];
    }
} 