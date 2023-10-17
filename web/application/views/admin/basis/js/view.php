<script src="<?= assets_url() ?>admin/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?= assets_url() ?>admin/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
<script src="<?= assets_url() ?>admin/pages/data-table/js/jszip.min.js"></script>
<script src="<?= assets_url() ?>admin/pages/data-table/js/pdfmake.min.js"></script>
<script src="<?= assets_url() ?>admin/pages/data-table/js/vfs_fonts.js"></script>
<script src="<?= assets_url() ?>admin/pages/data-table/extensions/key-table/js/dataTables.keyTable.min.js"></script>
<script src="<?= assets_url() ?>admin/datatables.net-buttons/js/buttons.print.min.js"></script>
<script src="<?= assets_url() ?>admin/datatables.net-buttons/js/buttons.html5.min.js"></script>
<script src="<?= assets_url() ?>admin/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="<?= assets_url() ?>admin/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?= assets_url() ?>admin/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/parsley.js/2.9.2/parsley.min.js"></script>
<script src="https://cdn.ckeditor.com/4.14.0/standard/ckeditor.js"></script>

<script>
    let dataTable = null;

    // untuk datatable
    var untukTabelDt = function() {
        dataTable = $('#tabel-basis-dt').DataTable({
            responsive: true,
            processing: true,
            lengthMenu: [5, 10, 25, 50],
            pageLength: 10,
            ajax: '<?= admin_url() ?>basis/get_data_dt',
            columns: [{
                    title: 'No.',
                    data: null,
                    className: 'text-center',
                    render: function(data, type, full, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                {
                    title: 'Klasifikasi',
                    data: 'nama',
                    className: 'text-center',
                },
                {
                    title: 'Kriteria 1',
                    data: 'kriteria_1',
                    className: 'text-center',
                },
                {
                    title: 'Kriteria 2',
                    data: 'kriteria_2',
                    className: 'text-center',
                },
                {
                    title: 'Aksi',
                    responsivePriority: -1,
                    className: 'text-center',
                    orderable: false,
                    searchable: false,
                    render: function(data, type, full, meta) {
                        return `
                        <div class="button-icon-btn button-icon-btn-cl">
                            <button type="button" id="btn-upd" data-id="` + full.id_basis + `" class="btn btn-info btn-sm waves-effect" data-toggle="modal" data-target="#modal-add-upd"><i class="fa fa-pencil"></i>&nbsp;Ubah</button>&nbsp;
                            <button type="button" id="btn-del" data-id="` + full.id_basis + `" class="btn btn-warning btn-sm waves-effect"><i class="fa fa-trash"></i>&nbsp;Hapus</button>
                        </div>
                    `;
                    },
                },
            ],
        });
    }();

    // untuk ubah gambar
    var untukUbahGambar = function() {
        $(document).on('click', '#ubah_gambar', function() {
            var ini = $(this);
            if (ini.is(':checked')) {
                $("input[name*='image']").removeAttr('disabled');
                $("input[name*='image']").attr('id', 'image');
            } else {
                $("input[name*='image']").attr('disabled', 'disabled');
                $("input[name*='image']").removeAttr('id');
                $("input[name*='image']").removeAttr('required');
                ini.parent().parent().find('#error').empty();
            }
        });
    }();

    // untuk tambah & ubah data
    var untukTambahDanUbahData = function() {
        $(document).on('submit', '#form-add-upd', function(e) {
            e.preventDefault();

            $('#id_klasifikasi').attr('required', 'required');
            $('#image').attr('required', 'required');

            if ($('#form-add-upd').parsley().isValid() == true) {
                $.ajax({
                    method: $(this).attr('method'),
                    url: $(this).attr('action'),
                    data: new FormData(this),
                    contentType: false,
                    processData: false,
                    cache: false,
                    dataType: 'json',
                    beforeSend: function() {
                        $('#btn-save').attr('disabled', 'disabled');
                        $('#btn-save').html('<i class="fa fa-spinner"></i>&nbsp;Menunggu...');
                    },
                    success: function(response) {
                        swal({
                            title: response.title,
                            text: response.text,
                            icon: response.type,
                            button: response.button,
                        }).then((value) => {
                            $('#modal-add-upd').modal('hide');
                            csrf.val(response.csrf);
                            dataTable.ajax.reload();
                        });
                        $('#btn-save').removeAttr('disabled');
                        $('#btn-save').html('<i class="fa fa-save"></i>&nbsp;Simpan');
                    }
                })
            }
        });
    }();

    // untuk tambah data
    var untukTambahData = function() {
        $(document).on('click', '#btn-add', function() {
            $('#judul-add-upd').html('Tambah');

            $('#id_basis').removeAttr('value');

            $("input[name*='image']").removeAttr('disabled');
            $("input[name*='image']").attr('id', 'image');
            $('#image').val('');

            $('#lihat_gambar').empty();
            $('#lihat_gambar').removeAttr('style');
            $('#centang_gambar').empty();
            $('#centang_gambar').removeAttr('style');

            $('#form-add-upd').parsley().reset();
            $('#form-add-upd')[0].reset();
        });
    }();

    // untuk ubah data
    var untukUbahData = function() {
        $(document).on('click', '#btn-upd', function() {
            var ini = $(this);

            $.ajax({
                type: "POST",
                url: "<?= admin_url() ?>basis/get",
                dataType: 'json',
                data: {
                    id: ini.data('id'),
                    '<?= $this->security->get_csrf_token_name() ?>': csrf.val(),
                },
                beforeSend: function() {
                    $('#judul-add-upd').html('Ubah');

                    ini.attr('disabled', 'disabled');
                    ini.html('<i class="fa fa-spinner"></i>&nbsp;Menunggu...');
                },
                success: function(response) {
                    csrf.val(response.csrf);

                    $('#id_basis').val(response.id_basis);
                    $('#id_classification').val(response.id_classification).trigger('change');
                    $('#kriteria_1').val(response.kriteria_1);
                    $('#kriteria_2').val(response.kriteria_2);

                    ini.removeAttr('disabled');
                    ini.html('<i class="fa fa-pencil"></i>&nbsp;Ubah');
                }
            });
        });
    }();

    // untuk hapus data
    var untukHapusData = function() {
        $(document).on('click', '#btn-del', function() {
            var ini = $(this);

            swal({
                title: "Apakah Anda yakin ingin menghapusnya?",
                text: "Data yang telah dihapus tidak dapat dikembalikan!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            }).then((del) => {
                if (del) {
                    $.ajax({
                        type: "post",
                        url: "<?= admin_url() ?>basis/process_del",
                        dataType: 'json',
                        data: {
                            id: ini.data('id'),
                            '<?= $this->security->get_csrf_token_name() ?>': csrf.val(),
                        },
                        beforeSend: function() {
                            ini.attr('disabled', 'disabled');
                            ini.html('<i class="fa fa-spinner"></i>&nbsp;Menunggu...');
                        },
                        success: function(response) {
                            swal({
                                title: response.title,
                                text: response.text,
                                icon: response.type,
                                button: response.button,
                            }).then((value) => {
                                csrf.val(response.csrf);
                                dataTable.ajax.reload();
                            });
                        }
                    });
                } else {
                    return false;
                }
            });
        });
    }();
</script>