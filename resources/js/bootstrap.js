import axios from 'axios';
window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

import 'https://code.jquery.com/jquery-3.7.1.js';
import 'https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js';
import 'https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js';
import 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js';
import 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js';
import 'https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js';
import 'https://cdn.jsdelivr.net/npm/admin-lte@3.1/dist/js/adminlte.min.js';
import 'https://cdn.datatables.net/2.1.8/js/dataTables.js';
import 'https://cdn.datatables.net/2.0.0/js/dataTables.bootstrap5.js';
import 'https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.js';
import 'https://cdn.datatables.net/buttons/3.1.2/js/dataTables.buttons.js';
import 'https://cdn.datatables.net/buttons/3.1.2/js/buttons.dataTables.js';
import 'https://cdn.datatables.net/buttons/3.1.2/js/dataTables.buttons.js';
import 'https://cdn.jsdelivr.net/npm/bootstrap-datepicker@1.9.0/dist/js/bootstrap-datepicker.min.js';

import Swal from 'sweetalert2'
window.Swal = Swal;

const Toast = Swal.mixin({
    toast: true,
    position: "top-end",
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
})

window.Toast = Toast;