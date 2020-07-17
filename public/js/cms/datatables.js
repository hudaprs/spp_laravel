/**
 * @desc    Init Datatable
 * @note    This function using Jquery
 * @param   {DOMString} element
 * @param   {string} url
 * @param   {array of object} columns
 * @param   {array} disableOrdering
 * @param   {array} order
 */
const dataTables = (
    element,
    url,
    columns,
    disableOrdering = null,
    order = null
) => {
    return $(element).DataTable({
        processing: true,
        responsive: true,
        serverSide: true,
        ajax: url,
        columns,
        columnDefs: [
            {
                targets: disableOrdering ? disableOrdering : [0, -1],
                sortable: false,
            },
            {
                targets: "_all",
                createdCell: function (td) {
                    $(td).css("white-space", "nowrap");
                },
            },
        ],
        order: [order ? order : [1, "asc"]],
    });
};
