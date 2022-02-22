$(function () {
    $('#my-data-table').DataTable({ "order": [[0, "desc"]] });
    $('#searchIssueStartDate, #searchIssueEndDate').datepicker({
        format: 'yyyy-mm-dd'
    });
});
function editBooking(event){
    let booking = event.currentTarget.name;
    console.log(booking);
    var obj = JSON.parse(booking);
    $("#editBookingID").val(obj.id);
    $("#editBookingCode").val(obj.booking_code);
    $("#editBookingName").val(obj.booking_name);
}

  function deleteBooking(event){
    let booking = event.currentTarget.name;
    console.log(booking);
    var obj = JSON.parse(booking);
    $("#deleteBookingID").val(obj.id);
    $("#deleteBookingCode").text(obj.booking_code);
    $("#deleteBookingName").text(obj.booking_name);
}
$(document).on(
    "click",
    "#editBt, #deleteBt",
    (event) => {
        let id = event.currentTarget.id;
        switch (id) {
            case "editBt":
                editBooking(event);
                break;
            case "deleteBt":
                deleteBooking(event);
                break;
            default:
                console.log("no any events click");
        }
    }
);