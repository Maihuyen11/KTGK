<?php

return [
    'required' => ':attribute không được để trống.',
    'email' => ':attribute phải là email hợp lệ.',
    'unique' => ':attribute đã tồn tại.',
    'min' => [
        'string' => ':attribute phải có ít nhất :min ký tự.',
    ],
    'max' => [
        'string' => ':attribute không được vượt quá :max ký tự.',
    ],
    'confirmed' => ':attribute không khớp.',

    'attributes' => [
        'name' => 'Họ và tên',
        'email' => 'Email',
        'password' => 'Mật khẩu',
        'password_confirmation' => 'Xác nhận mật khẩu',
    ],
];