<!-- Modal -->
<div class="modal fade" id="modal-edit" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Obat</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <input type="hidden" id="post_id">

                <div class="form-group">
                    <label for="kode-edit" class="control-label">Kode</label>
                    <input type="text" class="form-control" id="kode-edit">
                    <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-kode-edit"></div>
                </div>

                <div class="form-group">
                    <label for="nama-edit" class="control-label">Nama</label>
                    <input type="text" class="form-control" id="nama-edit">
                    <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-nama-edit"></div>
                </div>

                <div class="form-group">
                    <label for="deskripsi-edit" class="control-label">Deskripsi</label>
                    <input type="text" class="form-control" id="deskripsi-edit">
                    <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-deskripsi-edit"></div>
                </div>

                <div class="form-group">
                    <label for="tipe-edit" class="control-label">Tipe</label>
                    <input type="text" class="form-control" id="tipe-edit">
                    <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-tipe-edit"></div>
                </div>

                <div class="form-group">
                    <label for="jumlah-edit" class="control-label">Jumlah</label>
                    <input type="number" class="form-control" id="jumlah-edit">
                    <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-jumlah-edit"></div>
                </div>

                <div class="form-group">
                    <label for="harga_satuan-edit" class="control-label">Harga Satuan</label>
                    <input type="number" class="form-control" id="harga_satuan-edit">
                    <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-harga_satuan-edit"></div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary" id="update">Update</button>
            </div>
        </div>
    </div>
</div>

<script>
    //button create post event
    $('body').on('click', '#btn-edit-post', function () {

        let post_id = $(this).data('id');

        //fetch detail post with ajax
        $.ajax({
            url: `/posts/${post_id}`,
            type: "GET",
            cache: false,
            success:function(response){

                //fill data to form
                $('#post_id').val(response.data.id);
                $('#kode-edit').val(response.data.kode);
                $('#nama-edit').val(response.data.nama);
                $('#nama-deskripsi').val(response.data.deskripsi);
                $('#nama-tipe').val(response.data.tipe);
                $('#nama-jumlah').val(response.data.jumlah);
                $('#nama-harga_satuan').val(response.data.harga_satuan);

                //open modal
                $('#modal-edit').modal('show');
            }
        });
    });

    //action update post
    $('#update').click(function(e) {
        e.preventDefault();

        //define variable
        let post_id = $('#post_id').val();
        let kode   = $('#kode-edit').val();
        let nama = $('#nama-edit').val();
        let deskripsi = $('#deskripsi-edit').val();
        let tipe = $('#tipe-edit').val();
        let jumlah = $('#jumlah-edit').val();
        let harga_satuan = $('#harga_satuan-edit').val();
        let token   = $("meta[name='csrf-token']").attr("content");
        
        //ajax
        $.ajax({

            url: `/posts/${post_id}`,
            type: "PUT",
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
                            <a href="javascript:void(0)" id="btn-edit-post" data-id="${response.data.id}" 
                            class="btn btn-primary btn-sm">Ubah</a>
                            <a href="javascript:void(0)" id="btn-delete-post" data-id="${response.data.id}" class="btn btn-danger btn-sm">Hapus</a>
                        </td>
                    </tr>
                `;
                
                //append to post data
                $(`#index_${response.data.id}`).replaceWith(post);

                //close modal
                $('#modal-edit').modal('hide');
                

            },
            error:function(error){
                
                if(error.responseJSON.kode[0]) {

                    //show alert
                    $('#alert-kode-edit').removeClass('d-none');
                    $('#alert-kode-edit').addClass('d-block');

                    //add message to alert
                    $('#alert-kode-edit').html(error.responseJSON.kode[0]);
                }
                
                if(error.responseJSON.nama[0]) {

                    //show alert
                    $('#alert-nama-edit').removeClass('d-none');
                    $('#alert-nama-edit').addClass('d-block');

                    //add message to alert
                    $('#alert-nama-edit').html(error.responseJSON.nama[0]);
                }

                if(error.responseJSON.deskripsi[0]) {

                    //show alert
                    $('#alert-deskripsi-edit').removeClass('d-none');
                    $('#alert-deskripsi-edit').addClass('d-block');

                    //add message to alert
                    $('#alert-deskripsi-edit').html(error.responseJSON.deskripsi[0]);
                }

                if(error.responseJSON.tipe[0]) {

                    //show alert
                    $('#alert-tipe-edit').removeClass('d-none');
                    $('#alert-tipe-edit').addClass('d-block');

                    //add message to alert
                    $('#alert-tipe-edit').html(error.responseJSON.tipe[0]);
                }

                if(error.responseJSON.jumlah[0]) {

                    //show alert
                    $('#alert-jumlah-edit').removeClass('d-none');
                    $('#alert-jumlah-edit').addClass('d-block');

                    //add message to alert
                    $('#alert-jumlah-edit').html(error.responseJSON.jumlah[0]);
                }

                if(error.responseJSON.harga_satuan[0]) {

                    //show alert
                    $('#alert-harga_satuan-edit').removeClass('d-none');
                    $('#alert-harga_satuan-edit').addClass('d-block');

                    //add message to alert
                    $('#alert-harga_satuan-edit').html(error.responseJSON.harga_satuan[0]);
                }


            }

        });

    });

</script>