$('.custom-file-input').on('change', function () {
    let fileName = $(this).val().split('\\').pop();
    $(this).next('.custom-file-label').addClass('selected').html(fileName);
});

$(function () {
    $('#tambahBarang').on('click', function (e) {
        e.preventDefault();
        $('.gambar_barang img').remove();
        $('.modal-header h3').html("Tambah data barang");
        $('#formBarang').attr('action', '');
        $('#formBarang')[0].reset();
    });
    $('.editBarang').on('click', function (e) {
        $('.modal-header h3').html("Update data barang");
        $('.gambar_barang img').remove();

        const id_barang = $(this).data('id');
        e.preventDefault();

        $.ajax({
            url: 'views/barang_edit.php',
            data: {
                id_barang: id_barang
            },
            method: 'POST',
            dataType: 'json',
            success: function (result) {
                if (id_barang != 2) {
                    console.log("Coba wei");
                }
                $('#id_barang').val(id_barang);
                $('#nama_barang').val(result.nama_barang);
                $('#harga_barang').val(result.harga_barang);
                $('#stok_barang').val(result.stok_barang);
                $('#gambar_barang').val(result.gambar_barang);

                $('#formBarang').attr('action', '?page=barang_update');
                $('.gambar_barang').append(`<img class='mb-3' width='150' src='assets/img/barang/${result.gambar_barang}' alt='${result.nama_barang}'/>`)
                console.log(result);
            },
            error: function (jqxhr, status, exception) {
                alert("Error showing!: ", exception);
            }
        });
    });
});