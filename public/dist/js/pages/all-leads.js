const statusModal = new bootstrap.Modal(document.getElementById('status-change-modal'))
const agentModal = new bootstrap.Modal(document.getElementById('agent-change-modal'))
const bulkAssignModal = new bootstrap.Modal(document.getElementById('bulk-assign-modal'))

// A $( document ).ready() block.
$(document).ready(function () {
    $('#date-range').hide()
    $('#date-range').datepicker({
        format: 'yyyy/mm/dd',
    });
})

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

$("#selectAllCheckBox").click(function () {
    if ($("#selectAllCheckBox").prop('checked')) {

        let x = 1;
        while (x < currentPageLeadCount + 1) {
            $('.leadCheckBox' + x).prop("checked", true);
            let leadId = $('.leadCheckBox' + x).val()
            Livewire.emit('selectOnlyLeadID', leadId)
            x++;
        }

    } else {

        let x = 1;
        while (x < currentPageLeadCount + 1) {
            $('.leadCheckBox' + x).prop("checked", false);
            let leadId = $('.leadCheckBox' + x).val()
            Livewire.emit('unSelectOnlyLeadID')
            x++;
        }
    }
});

function toggleFilter() {
    $('#date-range').toggle()
}

function filterDate() {
    let startDate = $('#startDate').val()
    let endDate = $('#endDate').val()
    Livewire.emit('setFilterDate', startDate, endDate)
}