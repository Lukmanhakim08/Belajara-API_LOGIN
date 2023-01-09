<div class="card">
    <div class="card-body">
        <div class="row align-items-center g-3">
            <div class="col-4 col-lg-4">
                <h5>Data Barang</h5>
            </div>
            <div class="col-8 col-lg-8 text-md-end">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#template"><i
                        class="lni lni-circle-plus"></i> Tambah</button>
            </div>
        </div>
        <br>
        <div class="table-responsive">
            <table id="example" class="table align-middle table-striped  table-bordered">
                <thead class="table-secondary">
                    <tr>
                        <th style="width: 20px" class="text-center">No</th>
                        <th style="width: 250px">Nama Barang</th>
                        <th style="width: 30px">Harga</th>
                        <th style="width: 30px">Stok</th>
                        <th style="width: 50px" class="text-center">Foto</th>
                        <th style="width: 30px" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $no = 0;
                    @endphp
                    @foreach ($barang as $item)
                        @php
                            $no++;
                        @endphp
                        <tr>
                            <td style="width: 20px" class="text-center">{{ $no }}</td>
                            <td style="width: 250px">{{ $item['nama_barang'] }}</td>
                            <td style="width: 250px">{{ $item['harga_barang'] }}</td>
                            <td style="width: 250px">{{ $item['stok_barang'] }}</td>
                            <img src="{{ $item['stok_barang'] }}" alt="">
                            <td style="width: 250px">{{$item['foto_barang']}}</td>
                            {{-- <td style="width: 30px" class="text-center">
                            <a href="{{ 'templatesurat/' . $item['template'] }}"><i
                                    class="lni lni-wordpress"></i> Dokumen</a>
                        </td> --}}
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <br>
        </div>
    </div>

</div>
