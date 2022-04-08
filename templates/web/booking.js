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
    $("#cancelRoomNumber").text(obj.booking_no);
    $("#startDateShow").text(obj.date_in);
    $("#endDateShow").text(obj.date_out);
}

function approveBooking(event) {
    let item = event.currentTarget.name;
    console.log(item);
    var obj = JSON.parse(item);
    $("#bookingId").val(obj.id);
    $("#approveRoomNumber").text(obj.booking_no);
    var src = "upload/" + obj.image_deposit;
    console.log(src);
    // document.getElementById("imgPayment").src = src;
    document.getElementById("imgPayment").src = src;
}

$(document).on(
    "click",
    "#cencelBt,#approveBt",
    (event) => {
        let id = event.currentTarget.id;
        switch (id) {
            case "cencelBt":
                CencelBooking(event);
                break;
            case "approveBt":
                approveBooking(event);
                break;
            default:
                console.log("no any events click");
        }
    }
);