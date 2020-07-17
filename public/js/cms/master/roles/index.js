dataTables("#datatables", `${this.location.pathname}/datatables`, [
    { name: "id", data: "DT_RowIndex" },
    { name: "name", data: "name" },
    { email: "action", data: "action" },
]);
