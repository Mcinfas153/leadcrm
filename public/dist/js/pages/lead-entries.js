function deleteAllReminders(leadId) {
    Swal.fire({
        title: 'Delete All Reminders',
        text: "Are you sure want delete all reminders?",
        width: '32em',
        heightAuto: false,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        confirmButtonText: 'Yes, delete all',
        cancelButtonColor: '#d33',
        cancelButtonText: 'No, don\'t',
    }).then((result) => {
        if (result.isConfirmed) {
            Livewire.emit('deleteAllReminders', leadId)
        }
    })
}

function deleteAllEntries(leadId) {
    Swal.fire({
        title: 'Delete All Entries',
        text: "Are you sure want delete all entries?",
        width: '32em',
        heightAuto: false,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        confirmButtonText: 'Yes, delete all',
        cancelButtonColor: '#d33',
        cancelButtonText: 'No, don\'t',
    }).then((result) => {
        if (result.isConfirmed) {
            Livewire.emit('deleteAllEntries', leadId)
        }
    })
}

function deleteReminder(id) {
    Swal.fire({
        title: 'Delete Reminder',
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
            Livewire.emit('deleteReminder', id)
        }
    })
}

function deleteEntry(id) {
    Swal.fire({
        title: 'Delete Entry',
        text: "Are you sure want delete this entry?",
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
            Livewire.emit('deleteEntry', id)
        }
    })
}