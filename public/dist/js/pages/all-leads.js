const myModal = new bootstrap.Modal(document.getElementById('status-change-modal'))
$(function () {
    var table = $('.data-table').DataTable({
        order: [[1, 'desc']],
        fixedColumns: true,
        processing: true,
        serverSide: true,
        ajax: getAllLeadsRoute,
        columns: [
            { data: 'fullname', name: 'fullname' },
            { data: 'created_at', name: 'created_at' },
            { data: 'phone', name: 'phone' },
            { data: 'email', name: 'email' },
            { data: 'lead_status', name: 'lead_status' },
            { data: 'campaign_name', name: 'campaign_name' },
            { data: 'assign_user', name: 'assign_user' },
            { data: 'action', name: 'action' },
        ]
    });
});

window.addEventListener('tableReload', event => {
    $(function () {
        var table = $('.data-table').DataTable({
            order: [[1, 'desc']],
            fixedColumns: true,
            processing: true,
            serverSide: true,
            ajax: getAllLeadsRoute,
            columns: [
                { data: 'fullname', name: 'fullname' },
                { data: 'created_at', name: 'created_at' },
                { data: 'phone', name: 'phone' },
                { data: 'email', name: 'email' },
                { data: 'lead_status', name: 'lead_status' },
                { data: 'campaign_name', name: 'campaign_name' },
                { data: 'assign_user', name: 'assign_user' },
                { data: 'action', name: 'action' },
            ]
        });
    });
})

function changeStatus(leadId) {
    myModal.show()
    Livewire.emit('leadIdSelect', leadId)
}

window.addEventListener('modalClose', event => {
    myModal.hide()
});