$(function () {
    $('#my-data-table').DataTable({
        "order": [[0, "desc"]],
        "scrollX": true
    });
    $('#searchCheckOutDate').datepicker({
        format: 'yyyy-mm-dd'
    });
});

function ConfrimChekOut(event) {
    let item = event.currentTarget.name;
    console.log(item);
    var obj = JSON.parse(item);
    $("#bookingId").val(obj.id);
    $("#bookingDetailId").val(obj.book_detail_id);
    $("#roomNumber").text(obj.room_number);
}

$(document).on(
    "click",
    "#confirmBt",
    (event) => {
        let id = event.currentTarget.id;
        switch (id) {
            case "confirmBt":
                ConfrimChekOut(event);
                break;
            default:
                console.log("no any events click");
        }
    }
);