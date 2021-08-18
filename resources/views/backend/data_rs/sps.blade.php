@extends('backend.layouts.app')
@section('title', 'Admin | Tambah Data Rumah Sakit')
@section('subheader', 'Metode Tambah Data Satu Persatu')

@section('content')
    <div class="d-flex flex-column-fluid">
        <div class="container">
            <div class="card card-custom">
                <div class="card-header">
                    <div class="card-title">
                        <span class="card-icon">
                            <i class="flaticon2-delivery-package text-primary"></i>
                        </span>
                        <h3 class="card-label">Tambah Data</h3>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <form id="coba_form" class="form-horizontal" method="POST">
                            <span id="coba_form_result"></span>
                            <table class="table table-borderless" id="user_table">
                                <thead>
                                    <tr class="text-center">
                                        <th style="vertical-align: middle;" width="20%">Nama Rumah Sakit</th>
                                        <th style="vertical-align: middle;">Ketersediaan tempat tidur ICU</th>
                                        <th style="vertical-align: middle;">Jumlah tempat tidur ICU</th>
                                        <th style="vertical-align: middle;">Ketersediaan tempat tidur Isolasi</th>
                                        <th style="vertical-align: middle;">Jumlah tempat tidur terisi positif</th>
                                        <th style="vertical-align: middle;">Jumlah kamar tidur terisi suspek</th>
                                        <th style="vertical-align: middle;">Tanggal</th>
                                        <th style="vertical-align: middle;">Actions</th>
                                    </tr>
                                </thead>
                                <tbody id="add_tbody"></tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="6" align="right">&nbsp;</td>
                                        <td class="text-right">
                                            <a class="btn btn-danger font-weight-bold" href="{{route('rs_data.index')}}">Batal</a>
                                        </td>
                                        <td>
                                            @csrf
                                            <input type="submit" name="coba_save" id="coba_save" class="btn btn-primary font-weight-bold" value="Save">
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
<script>
    var myOptions = '@foreach($rss as $rs) <option value="{{$rs->id}}">{{$rs->nama}}</option> @endforeach';
    var count = 1;
    $('#coba_form_result').html('');
    dynamic_field(count);
    function dynamic_field(number)
    {
        html = '<tr>';
        html += '<td><select class="form-control" name="coba_select[]" required>';
        html += '<option value="">Pilih Rumah Sakit</option>' + myOptions;
        html += '</select></td>';
        html += '<td><input type="number" name="k_icu[]" class="form-control" autocomplete="off" value="0" required/></td>';
        html += '<td><input type="number" name="jlh_tmpt_icu[]" class="form-control" autocomplete="off" value="0" required/></td>';
        html += '<td><input type="number" name="k_isolasi[]" class="form-control" autocomplete="off" value="0" required/></td>';
        html += '<td><input type="number" name="jlh_tmpt_positif[]" class="form-control" autocomplete="off" value="0" required/></td>';
        html += '<td><input type="number" name="jlh_tmpt_suspek[]" class="form-control" autocomplete="off" value="0" required/></td>';
        html += '<td><input type="date" name="tgl[]" class="form-control" autocomplete="off" required/></td>';
        if(number > 1)
        {
            html += '<td><button type="button" name="remove" class="btn btn-danger remove">Remove</button></td></tr>';
            $('#add_tbody').append(html);
        } else
        {
            html += '<td><button type="button" name="add" id="add" class="btn btn-success">Add</button></td></tr>';
            $('#add_tbody').html(html);
        }
    }
    $(document).on('click', '#add', function(){
        count++;
        dynamic_field(count);                  
    });

    $(document).on('click', '.remove', function(){
        count--;
        $(this).closest("tr").remove();
    });

    $('#close_metode_sps').on('click', function(){
        count = 0;
        count--;
        $(this).closest("tr").remove();
        $("[name='selectBox']").val('#');
        $("[name='selectBox']").trigger('change');
    });

    $('#coba_form').on('submit', function(event){
        event.preventDefault();
        $.ajax({
            url: '{{ route("rs-data-dynamic-field.insert") }}',
            method: 'post',
            data:$(this).serialize(),
            dataType: 'json',
            beforeSend: function(){
                $('#coba_save').attr('disabled', 'disabled');
            },
            success:function(data)
            {
                if(data.error)
                {
                    var error_html = '';
                    for (var count = 0; count < data.error.length; count++)
                    {
                        error_html += '<p>'+data.error[count]+'</p>';
                    }
                    $('#coba_form_result').html('<div class="alert alert-danger">'+error_html+'</div>');
                }
                else
                {
                    window.location.href = "{{url('/admin/rumah-sakit/data')}}";
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil di simpan',
                        showConfirmButton: true
                    });
                }
                $('#coba_save').attr('disabled', false);
            }
        });
    });
</script>
@endsection