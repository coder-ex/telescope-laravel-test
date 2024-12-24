export default {
    confirm: function (message, callback, callbackCanceled = null) {
        Swal.fire({
            icon: "question",
            title: message,
            text: 'Подтвердите действие',
            showDenyButton: true,
            showCancelButton: false,
            confirmButtonText: 'Подтвердить',
            denyButtonText: `Отмена`,
        }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                callback();
            } else {
                if (callbackCanceled !== null) {
                    callbackCanceled();
                }
            }
        })
    },
    success: function (message, text = null, callback = null) {
        Swal.fire({
                title: message,
                text: text,
                icon: "success",
            })
            .then(() => {
                if (callback instanceof Function) {
                    callback();
                }
            });
    },

    error: function (message, text = null) {
        Swal.fire({
            title: message,
            text: text,
            icon: "error",
        });
    },

    warning: function (message, text = null) {
        Swal.fire({
            title: message,
            text: text,
            icon: "warning",
        });
    },

    info: function (message, text = null) {
        Swal.fire({
            title: message,
            text: text,
            icon: "info",
        });
    },
}