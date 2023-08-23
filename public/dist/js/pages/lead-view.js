const reminderModal = new bootstrap.Modal(document.getElementById('reminder-modal'))

function setReminder() {
    reminderModal.show()
}

$("#reminder-time").on("change", function () {
    let pickedDate = $("#reminder-time").val();
    Livewire.emit('setReminderTime', pickedDate);
});

window.addEventListener('modalClose', event => {
    reminderModal.hide()
});