$("#leads").DataTable({
  order: [[1, 'desc']],
  fixedColumns: true,
  dom: "Bfrtip",
  buttons: ["copy", "csv", "excel", "pdf", "print"],
});
$(
  ".buttons-copy, .buttons-csv, .buttons-print, .buttons-pdf, .buttons-excel"
).addClass("btn btn-primary mr-1");


