<script src="https://cdnjs.cloudflare.com/ajax/libs/parsley.js/2.9.2/parsley.min.js"></script>

<script>
    // untuk tambah & ubah data
    var untukTambahDanUbahData = function() {
        $(document).on('submit', '#form-konsultasi', function(e) {
            e.preventDefault();

            $('#kriteria_1').attr('required', 'required');
            $('#kriteria_1').attr('required', 'required');

            if ($('#form-konsultasi').parsley().isValid() == true) {
                $.ajax({
                    method: $(this).attr('method'),
                    url: $(this).attr('action'),
                    data: new FormData(this),
                    contentType: false,
                    processData: false,
                    cache: false,
                    dataType: 'json',
                    beforeSend: function() {
                        $('#btn-process').attr('disabled', 'disabled');
                        $('#btn-process').html('<i class="fa fa-spinner"></i>&nbsp;Menunggu...');
                    },
                    success: function(response) {
                        swal({
                            title: response.title,
                            text: response.text,
                            icon: response.type,
                            button: response.button,
                        }).then((value) => {
                            window.location.href = '<?= admin_url() ?>konsultasi/results/' + response.id;
                        });

                        $('#btn-process').removeAttr('disabled');
                        $('#btn-process').html('<i class="fa fa-save"></i>&nbsp;Simpan');
                    }
                })
            }
        });
    }();
</script>