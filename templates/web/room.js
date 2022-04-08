$(function () {
    $('#my-data-table').DataTable();
});
function editRoom(event) {
    let room = event.currentTarget.name;
    console.log(room);
    var obj = JSON.parse(room);
    $("#editRoomId").val(obj.id);
    $("#editRoomNumber").val(obj.room_number);
    $("#editPrice").val(obj.room_price);
    $("#editRoomType").val(obj.room_type);
    $("#editBadType").val(obj.bed_type);
}

function deleteRoom(event) {
    let room = event.currentTarget.name;
    console.log(room);
    var obj = JSON.parse(room);
    $("#roomId").val(obj.id);
    $("#deleteRoomNumber").text(obj.room_number);
}

$(document).on(
    "click",
    "#editBt, #deleteBt",
    (event) => {
        let id = event.currentTarget.id;
        switch (id) {
            case "editBt":
                editRoom(event);
                break;
            case "deleteBt":
                deleteRoom(event);
                break;
            default:
                console.log("no any events click");
        }
    }
);

// function uploadAdd(event) {
//     let files = event.currentTarget.files;
//     console.log(files[0]);

//     var output = document.getElementById('imgPayment');
//     output.src = URL.createObjectURL(files[0]);
//     output.onload = function () {
//         URL.revokeObjectURL(output.src) // free memory
//     }
//     document.getElementById("imgPayment").className += "display_image";
// }


// $(document).on(
//     'change',
//     '#imgUploadAdd',
//     (event) => {
//         let id = event.currentTarget.id;
//         console.log("run");
//         switch (id) {
//             case "imgUploadAdd":
//                 uploadAdd(event);
//                 break;
//             default:
//                 console.log("no any events click");
//         }
//     }
// );
