
require('../layout/layout')
$(function () {
    // การกำหนดตั้งค่าให้กับ slide เพิ่มเติม
    $('#carouselLight').carousel({
        interval: 3000, // กำหนดให้ slide รายการทุก 3 วินาที
        pause: "hover" // ให้หยุด slide ชั่วคราวเมื่อวางเมาส์อยู่เหนือรายการ มีผลเฉพาะ desktop
        // และเลื่อนอีกครั้งเมื่อลเลื่อนเมาส์ออก กรณืมือถือจะมีผลเมื่อ แตะที่ slide
    });
});
