<?php

return [
    /*
    | قائمة أكواد الدول للهاتف مع قواعد التحقق (الرقم بدون كود الدولة)
    | مفتاح المصفوفة: كود الدولة بدون +
    | code: للعرض (+20)
    | name: الاسم المعروض
    | regex: نمط التحقق للرقم المحلي فقط
    | placeholder: مثال للدخول
    | min_length / max_length: طول الرقم المحلي
    */
    'list' => [
        '20' => [
            'code' => '+20',
            'name' => 'مصر 🇪🇬',
            'regex' => '/^01[0-2,5][0-9]{8}$/',
            'placeholder' => '01xxxxxxxx',
            'min_length' => 10,
            'max_length' => 11,
        ],
        '966' => [
            'code' => '+966',
            'name' => 'السعودية 🇸🇦',
            'regex' => '/^5[0-9]{8}$/',
            'placeholder' => '5xxxxxxxx',
            'min_length' => 9,
            'max_length' => 9,
        ],
        '971' => [
            'code' => '+971',
            'name' => 'الإمارات 🇦🇪',
            'regex' => '/^5[0-9]{8}$/',
            'placeholder' => '5xxxxxxxx',
            'min_length' => 9,
            'max_length' => 9,
        ],
        '962' => [
            'code' => '+962',
            'name' => 'الأردن 🇯🇴',
            'regex' => '/^7[5-9][0-9]{7}$/',
            'placeholder' => '7xxxxxxxx',
            'min_length' => 9,
            'max_length' => 9,
        ],
        '965' => [
            'code' => '+965',
            'name' => 'الكويت 🇰🇼',
            'regex' => '/^[569][0-9]{7}$/',
            'placeholder' => '5xxxxxxx',
            'min_length' => 8,
            'max_length' => 8,
        ],
        '974' => [
            'code' => '+974',
            'name' => 'قطر 🇶🇦',
            'regex' => '/^[3-7][0-9]{7}$/',
            'placeholder' => '3xxxxxxx',
            'min_length' => 8,
            'max_length' => 8,
        ],
        '973' => [
            'code' => '+973',
            'name' => 'البحرين 🇧🇭',
            'regex' => '/^[36][0-9]{7}$/',
            'placeholder' => '3xxxxxxx',
            'min_length' => 8,
            'max_length' => 8,
        ],
        '968' => [
            'code' => '+968',
            'name' => 'عُمان 🇴🇲',
            'regex' => '/^9[0-9]{8}$/',
            'placeholder' => '9xxxxxxxx',
            'min_length' => 9,
            'max_length' => 9,
        ],
        '961' => [
            'code' => '+961',
            'name' => 'لبنان 🇱🇧',
            'regex' => '/^[0-9]{7,8}$/',
            'placeholder' => 'xxxxxxxx',
            'min_length' => 7,
            'max_length' => 8,
        ],
        '963' => [
            'code' => '+963',
            'name' => 'سوريا 🇸🇾',
            'regex' => '/^9[0-9]{8}$/',
            'placeholder' => '9xxxxxxxx',
            'min_length' => 9,
            'max_length' => 9,
        ],
        '964' => [
            'code' => '+964',
            'name' => 'العراق 🇮🇶',
            'regex' => '/^7[3-9][0-9]{8}$/',
            'placeholder' => '7xxxxxxxxx',
            'min_length' => 10,
            'max_length' => 10,
        ],
        '213' => [
            'code' => '+213',
            'name' => 'الجزائر 🇩🇿',
            'regex' => '/^[5-7][0-9]{8}$/',
            'placeholder' => '5xxxxxxxx',
            'min_length' => 9,
            'max_length' => 9,
        ],
        '212' => [
            'code' => '+212',
            'name' => 'المغرب 🇲🇦',
            'regex' => '/^[5-7][0-9]{8}$/',
            'placeholder' => '6xxxxxxxx',
            'min_length' => 9,
            'max_length' => 9,
        ],
        '216' => [
            'code' => '+216',
            'name' => 'تونس 🇹🇳',
            'regex' => '/^[2-9][0-9]{7}$/',
            'placeholder' => '2xxxxxxx',
            'min_length' => 8,
            'max_length' => 8,
        ],
        '218' => [
            'code' => '+218',
            'name' => 'ليبيا 🇱🇾',
            'regex' => '/^9[1-2][0-9]{7}$/',
            'placeholder' => '91xxxxxxx',
            'min_length' => 9,
            'max_length' => 9,
        ],
        '249' => [
            'code' => '+249',
            'name' => 'السودان 🇸🇩',
            'regex' => '/^9[0-9]{8}$/',
            'placeholder' => '9xxxxxxxx',
            'min_length' => 9,
            'max_length' => 9,
        ],
        '967' => [
            'code' => '+967',
            'name' => 'اليمن 🇾🇪',
            'regex' => '/^7[0-9]{8}$/',
            'placeholder' => '7xxxxxxxx',
            'min_length' => 9,
            'max_length' => 9,
        ],
        '970' => [
            'code' => '+970',
            'name' => 'فلسطين 🇵🇸',
            'regex' => '/^5[0-9]{8}$/',
            'placeholder' => '5xxxxxxxx',
            'min_length' => 9,
            'max_length' => 9,
        ],
    ],
];
