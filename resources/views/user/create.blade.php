{{-- <form action="{{ url('/user/store') }}" method="POST" id="form-tambah">
    @csrf
    <div id="modal-master" class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-primary">Tambah User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">

                <!-- Pilih Username -->
                <div class="form-group">
                    <label>Username</label>
                    <select name="nip" id="nip" class="form-control" required>
                        <option value="">-- Pilih Username --</option>
                        @foreach($pegawai as $item)
                            <option value="{{ $item->nip }}">{{ $item->nama }} ({{ $item->nip }})</option>
                        @endforeach
                    </select>
                    <small id="error-nip" class="error-text form-text text-danger"></small>
                </div>

                <!-- Pilih Level -->
                <div class="form-group">
                    <label>Level</label>
                    <select name="level" id="level" class="form-control" required>
                        <option value="">-- Pilih Status --</option>
                        <option value="admin">Admin</option>
                        <option value="pegawai">Pegawai</option>
                        <option value="operator">Operator</option>
                    </select>
                    <small id="error-level" class="error-text form-text text-danger"></small>
                </div>

                <!-- Input Password dengan toggle eye -->
                <div class="form-group">
                    <label>Password</label>
                    <div style="position: relative;">
                        <input type="password" name="password" id="password-field" class="form-control" placeholder="Masukkan Password" required>
                        <span style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); cursor: pointer;">
                            <i class="fa fa-eye" id="toggle-password"></i>
                        </span>
                    </div>
                    <small id="error-password" class="error-text form-text text-danger"></small>
                </div>

            </div>

            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-danger btn-sm">Batal</button>
                <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
            </div>
        </div>
    </div>
</form>

<!-- Toggle Password Visibility -->
<script>
    const passwordField = document.getElementById('password-field');
    const togglePassword = document.getElementById('toggle-password');

    togglePassword.addEventListener('click', function () {
        const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordField.setAttribute('type', type);
        this.classList.toggle('fa-eye');
        this.classList.toggle('fa-eye-slash');
    });
</script>

<!-- jQuery Form Validation & AJAX Submit -->
<script>
    $(document).ready(function () {
        $("#form-tambah").validate({
            rules: {
                nip: { required: true },
                level: { required: true },
                password: { required: true, minlength: 5 }
            },
            submitHandler: function (form) {
                $.ajax({
                    url: form.action,
                    type: form.method,
                    data: $(form).serialize(),
                    success: function (response) {
                        if (response.status) {
                            $('#myModal').modal('hide');
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: response.message
                            });
                            $('#table_user').DataTable().ajax.reload();
                        } else {
                            $('.error-text').text('');
                            $.each(response.msgField, function (prefix, val) {
                                $('#error-' + prefix).text(val[0]);
                            });
                            Swal.fire({
                                icon: 'error',
                                title: 'Terjadi Kesalahan',
                                text: response.message
                            });
                        }
                    }
                });
                return false;
            },
            errorElement: 'span',
            errorPlacement: function (error, element) {
                error.addClass('invalid-feedback');
                element.closest('.form-group').append(error);
            },
            highlight: function (element) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function (element) {
                $(element).removeClass('is-invalid');
            }
        });
    });
{{-- </script> --}}

<form action="{{ url('/user/store') }}" method="POST" id="form-tambah">
    @csrf
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Data User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Username</label>
                    <select name="nip" id="nip" class="form-control" required>
                        <option value="">-- Pilih Username --</option>
                        @foreach($pegawai as $item)
                            <option value="{{ $item->nip }}">{{ $item->nama }} ({{ $item->nip }})</option>
                        @endforeach
                    </select>
                    <small id="error-nip" class="error-text form-text text-danger"></small>
                </div>

                <div class="form-group">
                    <label>Level</label>
                    <select name="level" id="level" class="form-control" required>
                        <option value="">-- Pilih Level --</option>
                        <option value="admin">Admin</option>
                        <option value="operator">Operator</option>
                        <option value="pimpinan">Pimpinan</option>
                    </select>
                    <small id="error-level" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group">
                    <label>Bagian</label>
                    <select name="bagian" id="bagian" class="form-control" required>
                        <option value="">-- Pilih Bagian --</option>
                        <option value="PBJ">PBJ</option>
                        <option value="LPSE">LPSE</option>
                        <option value="PEMBINAAN">PEMBINAAN</option>
                        <option value="TU">TU</option>
                    </select>
                    <small id="error-bagian" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <div style="position: relative;">
                        <input type="password" name="password" id="password-field" class="form-control" placeholder="Masukkan Password" required>
                        <span style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); cursor: pointer;">
                            <i class="fa fa-eye" id="toggle-password"></i>
                        </span>
                    </div>
                    <small id="error-password" class="error-text form-text text-danger"></small>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-warning">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </div>
    </div>
</form>
<script>
    const passwordField = document.getElementById('password-field');
    const togglePassword = document.getElementById('toggle-password');

    togglePassword.addEventListener('click', function () {
        const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordField.setAttribute('type', type);
        this.classList.toggle('fa-eye');
        this.classList.toggle('fa-eye-slash');
    });
</script>

<script>
$(document).ready(function() {
    // Initialize Select2 for both dropdowns
    $('#nip').select2({
        placeholder: "-- Pilih Username --",
        allowClear: true,
        width: '100%',
        dropdownParent: $('#myModal') // Replace with your actual modal ID
    });
    
    $('#level').select2({
        placeholder: "-- Pilih Level --",
        allowClear: true,
        width: '100%',
        dropdownParent: $('#myModal') // Replace with your actual modal ID
    });
        $('#bagian').select2({
        placeholder: "-- Pilih Bagian --",
        allowClear: true,
        width: '100%',
        dropdownParent: $('#myModal') // Replace with your actual modal ID
    });

        // Disable "bagian" if level is admin or pimpinan
    $('#level').on('change', function() {
        const level = $(this).val();
        if(level === 'admin' || level === 'pimpinan') {
            $('#bagian').val(null).trigger('change'); // Clear selection
            $('#bagian').prop('disabled', true);
        } else {
            $('#bagian').prop('disabled', false);
        }
    });

    // Form validation and submission
    $("#form-tambah").validate({
        rules: {
            nip: { required: true },
            level: { required: true },
            bagian: { required: true },
            password: { required: true, minlength: 5 }
        },
            submitHandler: function(form) {
                $.ajax({
                    url: form.action,
                    type: form.method,
                    data: $(form).serialize(),
                    success: function(response) {
                        if (response.status) {
                            $('#myModal').modal('hide');
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: response.message
                            });
                            dataUser.ajax.reload()
                        } else {
                            $('.error-text').text('');
                            $.each(response.msgField, function(prefix, val) {
                                $('#error-' + prefix).text(val[0]);
                            });
                            Swal.fire({
                                icon: 'error',
                                title: 'Terjadi Kesalahan',
                                text: response.message
                            });
                        }
                    }
                });
                return false;
            },
            errorElement: 'span',
            errorPlacement: function(error, element) {
                error.addClass('invalid-feedback');
                element.closest('.form-group').append(error);
            },
            highlight: function(element, errorClass, validClass) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function(element, errorClass, validClass) {
                $(element).removeClass('is-invalid');
            }
    });
});
</script>