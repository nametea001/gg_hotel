$(function () {
    $('#searchIssueStartDate, #searchIssueEndDate').datepicker({
        format: 'yyyy-mm-dd'
    });
});

function setSelect(event) {
    let item = event.currentTarget.name;
    console.log(item);
    var obj = JSON.parse(item);
    $("#roomType").val(obj.room_type);
}


