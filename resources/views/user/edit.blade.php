{{-- 

@empty($user)
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-danger">Kesalahan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger">
                    <h5><i class="icon fas fa-ban"></i> Data Tidak Ditemukan</h5>
                    Data user tidak tersedia.
                </div>
            </div>
        </div>
    </div>
@else
<form action="{{ url('/user/' . $user->id_user . '/update') }}" method="POST" id="form-edit">
    @csrf
    @method('PUT')
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Data User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <div class="form-group">
                    <label>Username (NIP)</label>
                    <input type="text" name="nip" class="form-control" value="{{ $user->nip }}" readonly>
                    <small id="error-nip" class="error-text form-text text-danger"></small>
                </div>

                <div class="form-group">
                    <label>Level</label>
                    <select name="level" class="form-control" required>
                        <option value="">-- Pilih --</option>
                        <option value="pegawai" {{ $user->level == 'pegawai' ? 'selected' : '' }}>Pegawai</option>
                        <option value="admin" {{ $user->level == 'admin' ? 'selected' : '' }}>Admin</option>
                        <option value="operator" {{ $user->level == 'operator' ? 'selected' : '' }}>Operator</option>
                    </select>
                    <small id="error-level" class="error-text form-text text-danger"></small>
                </div>

                <div class="form-group">
                    <label>Password Baru (Opsional)</label>
                    <input type="password" name="password" class="form-control" placeholder="Kosongkan jika tidak diubah"  autocomplete="new-password">
                    <small id="error-password" class="error-text form-text text-danger"></small>
                </div>

                <div class="form-group">
                    <label>Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" class="form-control" placeholder="Ulangi password baru">
                </div>

                <div class="form-group">
                    <label>Password Lama <small class="text-muted">(wajib jika mengubah password)</small></label>
                    <input type="password" name="current_password" class="form-control" placeholder="Masukkan password lama">
                    <small id="error-current_password" class="error-text form-text text-danger"></small>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-secondary btn-sm">Batal</button>
                <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
            </div>
        </div>
    </div>
</form>

<script>
    $(document).ready(function () {
        $('#form-edit').validate({
            rules: {
                level: { required: true },
                password: { minlength: 5 },
                password_confirmation: {
                    equalTo: "[name='password']"
                }
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
                            dataUser.ajax.reload();
                        } else {
                            $('.error-text').text('');
                            $.each(response.msgField, function (prefix, val) {
                                $('#error-' + prefix).text(val[0]);
                            });
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal',
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
</script>
@endempty --}}


@empty($user)
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-danger">Kesalahan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger">
                    <h5><i class="icon fas fa-ban"></i> Data Tidak Ditemukan</h5>
                    Data user tidak tersedia.
                </div>
            </div>
        </div>
    </div>
@else
<form action="{{ url('/user/' . $user->id_user . '/update') }}" method="POST" id="form-edit">
    @csrf
    @method('PUT')
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Data User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <div class="form-group">
                    <label>Username (NIP)</label>
                    <input type="text" name="nip" class="form-control" value="{{ $user->nip }}" readonly>
                    <small id="error-nip" class="error-text form-text text-danger"></small>
                </div>

                <div class="form-group">
                    <label>Level</label>
                    <select name="level" class="form-control" required>
                        <option value="">-- Pilih --</option>
                        <option value="pegawai" {{ $user->level == 'pegawai' ? 'selected' : '' }}>Pegawai</option>
                        <option value="admin" {{ $user->level == 'admin' ? 'selected' : '' }}>Admin</option>
                        <option value="operator" {{ $user->level == 'operator' ? 'selected' : '' }}>Operator</option>
                        <option value="pimpinan" {{ $user->level == 'pimpinan' ? 'selected' : '' }}>Pimpinan</option>
                    </select>
                    <small id="error-level" class="error-text form-text text-danger"></small>
                </div>

                <div class="form-group">
                    <label>Password Baru (Opsional)</label>
                    <div class="input-group">
                        <input type="password" id="password-field" name="password" class="form-control" placeholder="Kosongkan jika tidak diubah" autocomplete="new-password">
                        <div class="input-group-append">
                            <span class="input-group-text">
                                <i class="fa fa-eye toggle-password" data-target="password-field" style="cursor: pointer;"></i>
                            </span>
                        </div>
                    </div>
                    <small id="error-password" class="error-text form-text text-danger"></small>
                </div>

                <div class="form-group">
                    <label>Konfirmasi Password</label>
                    <div class="input-group">
                        <input type="password" id="password-confirmation-field" name="password_confirmation" class="form-control" placeholder="Ulangi password baru">
                        <div class="input-group-append">
                            <span class="input-group-text">
                                <i class="fa fa-eye toggle-password" data-target="password-confirmation-field" style="cursor: pointer;"></i>
                            </span>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label>Password Lama <small class="text-muted">(wajib jika mengubah password)</small></label>
                    <div class="input-group">
                        <input type="password" id="current-password-field" name="current_password" class="form-control" placeholder="Masukkan password lama">
                        <div class="input-group-append">
                            <span class="input-group-text">
                                <i class="fa fa-eye toggle-password" data-target="current-password-field" style="cursor: pointer;"></i>
                            </span>
                        </div>
                    </div>
                    <small id="error-current_password" class="error-text form-text text-danger"></small>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-secondary btn-sm">Batal</button>
                <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
            </div>
        </div>
    </div>
</form>

<script>
    // Handle multiple password toggle buttons
    document.querySelectorAll('.toggle-password').forEach(function(toggleBtn) {
        toggleBtn.addEventListener('click', function() {
            const targetId = this.getAttribute('data-target');
            const passwordField = document.getElementById(targetId);
            
            const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordField.setAttribute('type', type);
            
            this.classList.toggle('fa-eye');
            this.classList.toggle('fa-eye-slash');
        });
    });
</script>

<script>
    $(document).ready(function () {
        $('#form-edit').validate({
            rules: {
                level: { required: true },
                password: { minlength: 5 },
                password_confirmation: {
                    equalTo: "[name='password']"
                }
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
                            dataUser.ajax.reload();
                        } else {
                            $('.error-text').text('');
                            $.each(response.msgField, function (prefix, val) {
                                $('#error-' + prefix).text(val[0]);
                            });
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal',
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
</script>
@endempty