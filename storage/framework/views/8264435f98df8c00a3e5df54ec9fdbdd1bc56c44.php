<!-- Modal -->
<div class="modal fade" id="modal-create" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Obat</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <div class="form-group">
                    <label for="kode" class="control-label">Kode</label>
                    <input type="text" class="form-control" id="kode">
                    <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-kode"></div>
                </div>

                <div class="form-group">
                    <label for="nama" class="control-label">Nama</label>
                    <input type="text" class="form-control" id="nama">
                    <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-nama"></div>
                </div>

                <div class="form-group">
                    <label for="deskripsi" class="control-label">Deskripsi</label>
                    <input type="text" class="form-control" id="deskripsi">
                    <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-deskripsi"></div>
                </div>

                <div class="form-group">
                    <label for="tipe" class="control-label">Tipe</label>
                    <input type="text" class="form-control" id="tipe">
                    <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-tipe"></div>
                </div>

                <div class="form-group">
                    <label for="jumlah" class="control-label">Jumlah</label>
                    <input type="number" class="form-control" id="jumlah">
                    <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-jumlah"></div>
                </div>

                <div class="form-group">
                    <label for="harga_satuan" class="control-label">Harga Satuan</label>
                    <input type="number" class="form-control" id="harga_satuan">
                    <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-harga_satuan"></div>
                </div>
                

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">tutup</button>
                <button type="button" class="btn btn-primary" id="store">simpan</button>
            </div>
        </div>
    </div>
</div>

<script>
    //button create post event
    $('body').on('click', '#btn-create-post', function () {

        //open modal
        $('#modal-create').modal('show');
    });

    //action create post
    $('#store').click(function(e) {
        e.preventDefault();

        //define variable
        let kode   = $('#kode').val();
        let nama = $('#nama').val();
        let deskripsi = $('#deskripsi').val();
        let tipe = $('#tipe').val();
        let jumlah = $('#jumlah').val();
        let harga_satuan = $('#harga_satuan').val();

        let token   = $("meta[name='csrf-token']").attr("content");
        
        //ajax
        $.ajax({

            url: `/posts`,
            type: "POST",
            cache: false,
            data: {
                "kode": kode,
                "nama": nama,
                "deskripsi": deskripsi,
                "tipe": tipe,
                "jumlah": jumlah,
                "harga_satuan" : harga_satuan,
                "_token": token
            },
            success:function(response){

                //show success message
                Swal.fire({
                    type: 'success',
                    icon: 'success',
                    title: `${response.message}`,
                    showConfirmButton: false,
                    timer: 3000
                });

                //data post
                let post = `
                    <tr id="index_${response.data.id}">
                        <td>${response.data.kode}</td>
                        <td>${response.data.nama}</td>
                        <td>${response.data.deskripsi}</td>
                        <td>${response.data.tipe}</td>
                        <td>${response.data.jumlah}</td>
                        <td>${response.data.harga_satuan}</td>
                        <td class="text-center">
                            <a href="javascript:void(0)" id="btn-edit-post" data-id="${response.data.id}" class="btn btn-primary btn-sm">Ubah</a>
                            <a href="javascript:void(0)" id="btn-delete-post" data-id="${response.data.id}" class="btn btn-danger btn-sm">Hapus</a>
                        </td>
                    </tr>
                `;
                
                //append to table
                $('#table-posts').prepend(post);
                
                //clear form
                $('#kode').val('');
                $('#nama').val('');
                $('#deskripsi').val('');
                $('#tipe').val('');
                $('#jumlah').val('');
                $('#harga_satuan').val('');

                //close modal
                $('#modal-create').modal('hide');
                

            },
            error:function(error){
                
                if(error.responseJSON.kode[0]) {

                    //show alert
                    $('#alert-kode').removeClass('d-none');
                    $('#alert-kode').addClass('d-block');

                    //add message to alert
                    $('#alert-kode').html(error.responseJSON.kode[0]);
                } 

                if(error.responseJSON.nama[0]) {

                    //show alert
                    $('#alert-nama').removeClass('d-none');
                    $('#alert-nama').addClass('d-block');

                    //add message to alert
                    $('#alert-nama').html(error.responseJSON.nama[0]);
                }

                if(error.responseJSON.deskripsi[0]) {

                    //show alert
                    $('#alert-deskripsi').removeClass('d-none');
                    $('#alert-deskripsi').addClass('d-block');

                    //add message to alert
                    $('#alert-deskripsi').html(error.responseJSON.deskripsi[0]);
                }
                
                if(error.responseJSON.tipe[0]) {

                    //show alert
                    $('#alert-tipe').removeClass('d-none');
                    $('#alert-tipe').addClass('d-block');

                    //add message to alert
                    $('#alert-tipe').html(error.responseJSON.tipe[0]);
                }

                if(error.responseJSON.jumlah[0]) {

                    //show alert
                    $('#alert-jumlah').removeClass('d-none');
                    $('#alert-jumlah').addClass('d-block');

                    //add message to alert
                    $('#alert-jumlah').html(error.responseJSON.jumlah[0]);
                }

                if(error.responseJSON.harga_satuan[0]) {

                    //show alert
                    $('#alert-harga_satuan').removeClass('d-none');
                    $('#alert-harga_satuan').addClass('d-block');

                    //add message to alert
                    $('#alert-harga_satuan').html(error.responseJSON.harga_satuan[0]);
                }

            }

        });

    });

</script><?php /**PATH C:\xampp2\htdocs\obat\resources\views/components/modal-create.blade.php ENDPATH**/ ?>