<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use App\RepairType;
use Faker\Generator as Faker;

$factory->define(RepairType::class, function (Faker $faker) {
    return [
        'aptId'=> 1,
        'userId'=>53,
        // 'lang'=>'en' ,
        // 'repair_type'=>'[{"value":1,"label":"repair","object":[{"value":1,"label":"windows","title":[{"value":1,"label":"It was broken"},{"value":2,"label":"The window is cracked."},{"value":3,"label":"Helps in the window."}]},{"value":2,"label":"Kitchen door","title":[{"value":1,"label":"The kitchen door is distorted."},{"value":2,"label":"The kitchen door has fallen."},{"value":3,"label":"Helping."}]},{"value":3,"label":"sink","title":[{"value":1,"label":"There is no water in the sink."},{"value":2,"label":"The sink is broken"},{"value":3,"label":"The sink is bent"}]}]},{"value":2,"label":"Check","object":[{"value":1,"label":"window","title":[{"value":1,"label":"The window frame is stiff."},{"value":2,"label":"The window is cracked."},{"value":3,"label":"Helping"}]},{"value":2,"label":"washroom","title":[{"value":1,"label":"The washroom water is running dry."},{"value":2,"label":"The bathroom faucet has run out."},{"value":3,"label":"Washroom sewage is not well."}]},{"value":3,"label":"lamp","title":[{"value":1,"label":"The light is light.."},{"value":2,"label":"The lights are flickering."},{"value":3,"label":"The light does not turn on at all."}]}]}]'
        // 'lang'=>'kr' ,
        // 'repair_type'=>'[{"value":1,"label":"수리","object":[{"value":1,"label":"창문","title":[{"value":1,"label":"창문이 깨졌습니다."},{"value":2,"label":"창문에 금이 갔습니다."},{"value":3,"label":"창문이 거들거립니다."}]},{"value":2,"label":"부엌문","title":[{"value":1,"label":"부엌문이 찌그러졌습니다."},{"value":2,"label":"부엌문이 떨어졌습니다."},{"value":3,"label":"부엌문이 거들거립니다."}]},{"value":3,"label":"싱크대","title":[{"value":1,"label":"싱크대물이 안나옵니다."},{"value":2,"label":"싱크대가 고장났습니다."},{"value":3,"label":"싱크대가 구부러졌습니다."}]}]},{"value":2,"label":"점검","object":[{"value":1,"label":"창문","title":[{"value":1,"label":"창문틀이 거들거립니다."},{"value":2,"label":"창문에 금이 갔습니다."},{"value":3,"label":"창문이 거들거립니다."}]},{"value":2,"label":"세면장","title":[{"value":1,"label":"세면장물이 졸졸 흐릅니다."},{"value":2,"label":"세면장수도꼭지가 떨어졌습니다."},{"value":3,"label":"세면장하수가 잘 안됩니다."}]},{"value":3,"label":"전등","title":[{"value":1,"label":"전등이 연하게 옵니다."},{"value":2,"label":"전등이 껌벅거립니다."},{"value":3,"label":"전등이 전혀 켜지지 않습니다."}]}]}]'
        'lang'=>'vn' ,
        'repair_type'=>'[{"value":1,"label":"asửa","object":[{"value":1,"label":"cửa sổ","title":[{"value":1,"label":"Cửa sổ bị phá vỡ."},{"value":2,"label":"Cửa sổ bị nứt."},{"value":3,"label":"Các cửa sổ đang giúp đỡ."}]},{"value":2,"label":"Cửa bếp","title":[{"value":1,"label":"Cửa bếp móp méo."},{"value":2,"label":"Cửa bếp đã đổ."},{"value":3,"label":"Cửa bếp đang trợ giúp."}]},{"value":3,"label":"bồn rửa","title":[{"value":1,"label":"Không có nước chìm."},{"value":2,"label":"Chậu rửa chén bị hỏng."},{"value":3,"label":"Bồn rửa mặt bị cong."}]}]},{"value":2,"label":"kiểm tra","object":[{"value":1,"label":"cửa sổ","title":[{"value":1,"label":"Khung cửa sổ đang trợ giúp."},{"value":2,"label":"Cửa sổ bị nứt."},{"value":3,"label":"Các cửa sổ đang giúp đỡ."}]},{"value":2,"label":"Phòng vệ sinh","title":[{"value":1,"label":"Phòng vệ sinh đang chạy khô."},{"value":2,"label":"Vòi nhà tắm đã hết."},{"value":3,"label":"Nước thải phòng vệ sinh không tốt."}]},{"value":3,"label":"ánh sáng","title":[{"value":1,"label":"Đèn đến sáng."},{"value":2,"label":"Đèn le lói."},{"value":3,"label":"Đèn hoàn toàn không bật."}]}]}]'
    ];
});
