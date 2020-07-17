dataTables(
    "#datatables",
    `/cms/master/users/datatables`,
    [
        { name: "id", data: "DT_RowIndex" },
        { name: "name", data: "name" },
        { name: "created_at", data: "created_at" },
    ],
    [0],
    [2, "desc"]
);
