$(document).ready(function () {
    $("#date-range-start").datepicker({
        toggleActive: true,
        format: 'yyyy-mm-dd',
    });

    $("#date-range-end").datepicker({
        toggleActive: true,
        format: 'yyyy-mm-dd',
    });
});


function setStartDate() {
    let startDate = $("#date-range-start").val()
    Livewire.emit('setStartDate', startDate)
}

function setEndDate() {
    let endDate = $("#date-range-end").val()
    Livewire.emit('setEndDate', endDate)
}