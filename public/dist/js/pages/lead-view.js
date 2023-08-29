const reminderModal = new bootstrap.Modal(document.getElementById('reminder-modal'))
const entryModal = new bootstrap.Modal(document.getElementById('entry-modal'))

function setReminder() {
    reminderModal.show()
}

function addEntry() {
    entryModal.show()
}

$("#reminder-time").on("change", function () {
    let pickedDate = $("#reminder-time").val();
    Livewire.emit('setReminderTime', pickedDate);

});

$("#entry-time").on("change", function () {
    let pickedDate = $("#entry-time").val();
    Livewire.emit('setEntryTime', pickedDate);
});

window.addEventListener('modalClose', event => {
    $("#entry-time").val('');
    $("#reminder-time").val('');
    reminderModal.hide()
    entryModal.hide()
});

function dealClose(id) {
    Swal.fire({
        title: 'Deal Close',
        text: "Are you sure want to convert this lead as closed deal?",
        width: '32em',
        heightAuto: false,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        confirmButtonText: 'Yes, do it',
        cancelButtonColor: '#d33',
        cancelButtonText: 'No, don\'t',
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = `${baseUrl}/close-lead/${id}`
        }
    })
}