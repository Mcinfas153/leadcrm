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