const statusModal = new bootstrap.Modal(document.getElementById('status-change-modal'))
const agentModal = new bootstrap.Modal(document.getElementById('agent-change-modal'))
const bulkAssignModal = new bootstrap.Modal(document.getElementById('bulk-assign-modal'))

function changeStatus(leadId, statusId) {
    statusModal.show()
    Livewire.emit('leadIdSelect', leadId, statusId)
}

function changeAgent(leadId, agentId) {
    agentModal.show()
    Livewire.emit('leadAgentIdSelect', leadId, agentId)
}

function bulkAssign(leadId, agentId) {
    bulkAssignModal.show()
    Livewire.emit('leadAgentIdSelect', leadId, agentId)
}

function makeCall(phoneNumber) {
    Swal.fire({
        title: phoneNumber,
        text: "Are you sure want to call this number?",
        width: '32em',
        heightAuto: false,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        confirmButtonText: 'Yes, call it',
        cancelButtonColor: '#d33',
        cancelButtonText: 'No, don\'t',
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = `tel:${phoneNumber}`
        }
    })
}

function sentEmail(email) {
    Swal.fire({
        title: email,
        text: "Are you sure want to send email to this address?",
        width: '32em',
        heightAuto: false,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        confirmButtonText: 'Yes, sent it',
        cancelButtonColor: '#d33',
        cancelButtonText: 'No, don\'t',
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = `mailto:${email}`
        }
    })
}

function exportLeads(url) {
    Swal.fire({
        title: 'Export Leads',
        text: "Are you sure want export leads?",
        width: '32em',
        heightAuto: false,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        confirmButtonText: 'Yes, export it',
        cancelButtonColor: '#d33',
        cancelButtonText: 'No, don\'t',
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = url
        }
    })
}

function bulkDelete() {
    Swal.fire({
        title: 'Delete Leads',
        text: "Are you sure want delete selected leads?",
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
            Livewire.emit('bulkDelete')
        }
    })
}

window.addEventListener('modalClose', event => {
    statusModal.hide()
    agentModal.hide()
    bulkAssignModal.hide()
});

function deleteLead(id, name) {
    Swal.fire({
        title: 'Delete Leads',
        text: `Are you sure want delete ${name}?`,
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
            Livewire.emit('deleteLead', id)
        }
    })
}