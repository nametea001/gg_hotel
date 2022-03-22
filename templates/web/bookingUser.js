$(function () {
    $('#my-data-table').DataTable({ "order": [[0, "desc"]] });
    $('#searchIssueStartDate, #searchIssueEndDate').datepicker({
        format: 'yyyy-mm-dd'
    });
});

function bookingRoom(event) {
    let item = event.currentTarget.name;
    console.log(item);
    var obj = JSON.parse(item);
    $("#roomId").val(obj.id);
    $("#roomType").val(obj.room_type);
    $("#roomTypeShow").val(obj.room_type);
    $("#roomNumber").text(obj.room_number);
}

function searchRoom(event) {
    let item = event.currentTarget.name;
    console.log(item);
    var obj = JSON.parse(item);
    $("#searchIssueStartDate").val(obj.startDate);
    $("#searchIssueEndDate").val(obj.endDate);
    $("#roomTypeShow").val(obj.room_type);
}

$(document).on(
    "click",
    "#bookingBt, #searchRoomBt",
    (event) => {
        let id = event.currentTarget.id;
        switch (id) {
            case "bookingBt":
                bookingRoom(event);
                break;
            case "searchRoomBt":
                searchRoom(event);
                break;
            default:
                console.log("no any events click");
        }
    }
);