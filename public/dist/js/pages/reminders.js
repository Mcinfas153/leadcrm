function remindersStatusChange(reminderId, currentStatus) {
    Livewire.emit('remindersStatusChange', reminderId, currentStatus)
}

function deleteReminder(reminderId) {
    Swal.fire({
        title: "Delete Reminder",
        text: "Are you sure want delete this reminder?",
        width: '32em',
        heightAuto: false,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        confirmButtonText: 'Yes, delete it',
        cancelButtonColor: '#d33',
        cancelButtonText: 'No, don\'t',
    }).then((result) => {
        if (result.isConfirmed) {
            Livewire.emit('deleteReminder', reminderId)
        }
    })
}