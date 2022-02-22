$(function() {
    $('#my-data-table').DataTable();
});
function editRoom(event){
    let room = event.currentTarget.name;
    console.log(room);
    var obj = JSON.parse(room);
    $("#editRoomID").val(obj.id);
    $("#editRoomCode").val(obj.room_code);
    $("#editRoomName").val(obj.room_name);
}

  function deleteRoom(event){
    let room = event.currentTarget.name;
    console.log(room);
    var obj = JSON.parse(room);
    $("#deleteRoomID").val(obj.id);
    $("#deleteRoomCode").text(obj.room_code);
    $("#deleteRoomName").text(obj.room_name);
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