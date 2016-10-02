function submitLinkByForm(id) {
    event.preventDefault();
    document.getElementById(id).submit();
}

function deleteAlert(text, message) {
    swal({
        title: "Are you sure?",
        text: text,
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Yes, delete it!",
        closeOnConfirm: false },
        function() {
            swal("Deleted!", message, "success");
        });
    return false;
}