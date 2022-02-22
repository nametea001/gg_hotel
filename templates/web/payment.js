$(function() {
    $('#my-data-table').DataTable();
});

$(document).on(
    "click",
    "#editBt, #deleteBt",
    (event) => {
        let id = event.currentTarget.id;
        switch (id) {
            case "editBt":
                editProduct(event);
                break;
            case "deleteBt":
                deleteProduct(event);
                break;
            default:
                console.log("no any events click");
        }
    }
);