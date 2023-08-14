$(document).ready(function () {
    $(".select2").select2();
    $('#user').on('change', function (e) {
        let userId = $('#user').select2("val");
        Livewire.emit('selectUser', userId);
    });
});