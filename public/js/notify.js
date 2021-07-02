addEventListener('toastOK', event => {
    Swal.fire({
        position: 'top-end',
        icon: 'success',
        title: event.detail.name,
        showConfirmButton: false,
        timer: 1500
    })
});

addEventListener('error', event=>{
    Swal.fire(
        'Error',
        event.detail.name,
        'error'
    ) 
})