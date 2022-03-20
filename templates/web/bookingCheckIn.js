$(function () {
    $('#my-data-table').DataTable({
        "order": [[0, "desc"]],
        "scrollX": true
    });
    $('#searchCheckInDate').datepicker({
        format: 'yyyy-mm-dd'
    });
});

$(document).on(
    "click",
    "#",
    (event) => {
        let id = event.currentTarget.id;
        switch (id) {
            default:
                console.log("no any events click");
        }
    }
);