import swal from 'sweetalert2';

const toastSuccess = (title: string) =>
  swal({
    title,
    type: 'success',
    toast: true,
    position: 'top-right',
    showConfirmButton: false,
    timer: 5000,
  });

const toastLoading = async (callback: () => void) => {
  swal({
    title: 'Loading',
    toast: true,
    position: 'top-right',
    showConfirmButton: false,
    onOpen: () => swal.showLoading(),
  });
  await callback();
  swal.close();
};

export { toastSuccess, toastLoading };
