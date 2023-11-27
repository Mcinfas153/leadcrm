$(document).ready(function () {
    $("#date-range-start").datepicker({
        toggleActive: true,
        format: 'yyyy-mm-dd',
    });

    $("#date-range-end").datepicker({
        toggleActive: true,
        format: 'yyyy-mm-dd',
    });

    $('.agents').select2();

});


function setStartDate() {
    let startDate = $("#date-range-start").val()
    console.log(startDate);
    Livewire.emit('setStartDate', startDate)
}

function setEndDate() {
    let endDate = $("#date-range-end").val()
    Livewire.emit('setEndDate', endDate)
}

function selectAgent() {
    let agents = $('.agents').val();
    Livewire.emit('setAgents', agents)
}