$(function () {
    $('#my-data-table').DataTable({
        "order": [[0, "desc"]],
        "scrollX": true
    });
    $('#searchIssueStartDate, #searchIssueEndDate').datepicker({
        format: 'yyyy-mm-dd'
    });
});

function CencelBooking(event) {
    let item = event.currentTarget.name;
    console.log(item);
    var obj = JSON.parse(item);
    $("#bookingId").val(obj.id);
    $("#roomNumber").text(obj.room_number);
    $("#startDateShow").text(obj.date_in);
    $("#endDateShow").text(obj.date_out);
}

$(document).on(
    "click",
    "#cencelBt",
    (event) => {
        let id = event.currentTarget.id;
        switch (id) {
            case "cencelBt":
                CencelBooking(event);
                break;
            default:
                console.log("no any events click");
        }
    }
);