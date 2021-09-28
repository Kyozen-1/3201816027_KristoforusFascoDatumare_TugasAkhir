@extends('backend.layouts.app')
@section('title', 'Admin | Tambah Data Covid-19 Kelurahan')
@section('subheader', 'Metode Menambah Data Satu Per Satu')
    
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
                    <form id="coba_form" class="form-horizontal" method="POST">
                        <span id="coba_form_result"></span>
                        <table class="table table-borderless" id="user_table">
                            <thead>
                                <tr class="text-center justify-content-center">
                                    <th>Nama Kelurahan</th>
                                    <th>Kontak Erat</th>
                                    <th>Suspek</th>
                                    <th>Positif</th>
                                    <th>Positif dirawat(isolasi)</th>
                                    <th>Meninggal</th>
                                    {{-- <th>Warna</th> --}}
                                    <th>Tanggal</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody id="add_tbody">
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="2">
                                        <label>Zona Ketetapan Pemerintah</label>
                                    </td>
                                    <td colspan="6">
                                        <select name="zona" id="zona" class="form-control" required>
                                            @foreach ($zonas as $zona)
                                                <option value="{{$zona->id}}">{{$zona->nama}}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="6" align="right">&nbsp;</td>
                                    <td class="text-right">
                                        @csrf
                                        <input type="submit" class="btn btn-primary font-weight-bold" name="coba_save" id="coba_save" value="Save">
                                    </td>
                                    <td class="text-right">
                                        <a class="btn btn-danger font-weight-bold" href="{{route('c19_klh.index')}}">Batal</a>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </form>
                </div>
            </div>            
        </div>
    </div>
@endsection

@section('js')
    <script>
        var myOptions = '@foreach($kelurahans as $kelurahan) <option value="{{$kelurahan->id}}">{{$kelurahan->nama}}</option> @endforeach';
        // var myColors = '@foreach($colors as $color) <option value="{{$color->color}}" style="style:{{$color->color}};">{{$color->nama}}</option> @endforeach';
        var count = 1;
        $('#coba_form_result').html('');
        dynamic_field(count);
        function dynamic_field(number){
            html = '<tr>';
            html += '<td><select class="form-control" name="coba_select[]" required>';
            html += '<option value="">Pilih Kelurahan</option>' + myOptions;
            html += '</select></td>';
            html += '<td><input type="number" class="form-control" name="kontak_erat[]" autocomplete="off" value="0" required/></td>';
            html += '<td><input type="number" class="form-control" name="suspek[]" autocomplete="off" value="0" required/></td>';
            html += '<td><input type="number" class="form-control" name="positif[]" autocomplete="off" value="0" required/></td>';
            html += '<td><input type="number" class="form-control" name="positif_isolasi[]" autocomplete="off" value="0" required/></td>';
            html += '<td><input type="number" class="form-control" name="meninggal[]" autocomplete="off" value="0" required/></td>';
            // html += '<td><select class="form-control" name="warna_select[]" required>';
            // html += '<option value="">Pilih Warna</option>'+myColors;
            // html += '</select></td>';
            html += '<td><input type="date" class="form-control" name="tanggal[]" autocomplete="off" required/></td>';
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
            dynamic_field(count);
            $("[name='selectbox']").val('#');
            $("[name='selectbox']").trigger('change');
        });

        $('#coba_form').on('submit', function(event){
            event.preventDefault();
            $.ajax({
                url: '{{ route("covid19-dynamic-field.insert") }}',
                method: 'post',
                data:$(this).serialize(),
                dataType: 'json',
                beforeSend: function(){
                    $('#coba_save').attr('disabled', 'disabled');
                },
                success:function(data)
                {
                    console.log(data);
                    if(data.error)
                    {
                        var error_html = '';
                        for (var count = 0; count < data.error.length; count++)
                        {
                            error_html += '<p>'+data.error[count]+'</p>';
                        }
                        $('#coba_form_result').html('<div class="alert alert-danger">'+error_html+'</div>');
                    } else {
                        window.location.href = "{{url('/admin/kelurahan/covid19')}}";
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