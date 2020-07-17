const Toast = Swal.mixin({
    toast: true,
    position: "top-end",
    showConfirmButton: false,
    timer: 3000,
});

const initToast = (type, title) => {
    return Toast.fire({
        type,
        title,
    });
};
