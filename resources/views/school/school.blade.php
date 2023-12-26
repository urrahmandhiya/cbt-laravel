@extends('layouts.app')

@section('content')
<style>
    #placeholder {
		width: 340px;
        height: 250px
	}
</style>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    Grafik
                </div>
                <div class="card-body">
                    <div id="placeholder"></div>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    {{ __('Daftar School Aplikasi') }}
                    @can('allow-edit-data')
                    <span class="float-end">
                        <a href="{{ route('school.form') }}" class="btn btn-sm btn-primary">Tambah Baru</a>
                        <a href="{{ route('school.export.xls') }}" class="btn btn-sm btn-secondary">Export XLS</a>
                    </span>
                    @endcan
                </div>

                <div class="card-body">
                    @can('allow-akses-data')
                    <table class="table">
                        <tr>
                            <th>ID</th>
                            <th>Nama Sekolah</th>
                            <th>Jenjang</th>
                            <th>Alamat</th>
                            <th>Jumlah Siswa</th>
                            @can('allow-edit-data')
                            <th class="text-center">Aksi</th>
                            @endcan
                        </tr>
                        @foreach($list as $row)
                        <tr>
                            <td>{{ $row->id }}</td>
                            <td>{{ $row->school_name }}</td>
                            <td>{{ $row->level }}</td>
                            <td>{{ $row->address }}</td>
                            <td>{{ $row->student_amount }}</td>
                            <td class="text-center">
                                @can('allow-edit-data')
                                {{ link_to_route('school.form.edit', 'Edit', [$row->id], ['class' => 'btn btn-warning']) }}
                                @endcan
                                @can('allow-delete-data')
                                {{ link_to_route('school.delete', 'Hapus', [$row->id], ['class' => 'btn btn-danger']) }}
                                @endcan
                                @can('allow-edit-data')
                                {{ link_to_route('school.export.docx', 'DOCX', [$row->id], ['class' => 'btn btn-secondary']) }}
                                @endcan
                                @can('allow-edit-data')
                                {{ link_to_route('school.export.pdf', 'PDF', [$row->id], ['class' => 'btn btn-secondary']) }}
                                @endcan
                            </td>
                        </tr>
                        @endforeach
                    </table>
                    @endcan
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
    <script language="javascript" type="text/javascript" src="js/jquery.flot.js"></script>
    <script language="javascript" type="text/javascript" src="js/jquery.flot.pie.js"></script>

    <?php
    $str = [];
        foreach ($rekap as $nama_jenjang => $num) 
        {
            $str[] = '{ label: "'.$nama_jenjang.'",  data: '.$num.'}';
        }
    ?>

    <script>
       $(function(){
        var data = [
            <?php echo implode(",", $str);?>
		];

            var placeholder = $("#placeholder");

            placeholder.unbind();

			$("#title").text("Default pie chart");
			$("#description").text("The default pie chart with no options set.");

			$.plot(placeholder, data, {
				series: {
					pie: { 
						show: true
					}
				}
			});
       });
    </script>
@endsection

