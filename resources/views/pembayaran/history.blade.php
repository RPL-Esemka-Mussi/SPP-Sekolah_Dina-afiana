@extends('main.bootstrap')
@section('content')
    <div class="text-center py-5 bg-dark text-white">
        <h3>History Pembayaran</h3>
    </div>
    <div class="container mt-4">
        <div class="d-flex justify-content-center text-center">
            <div class="card text-bg-success ms-5 me-5 w-100">
                <div class="card-header">
                    <b>Total Dibayar:</b>
                </div>
                <div class="card-body">
                    <h3>Rp.{{ $total['total_dibayar'] }}</h3>
                </div>
            </div>

            <div class="card text-bg-danger me-5 ms-5 w-100">
                <div class="card-header">
                    <b>Total Belum Dibayar:</b>
                </div>
                <div class="card-body">
                    <h3>Rp.{{ $total['total_belumdibayar'] }}</h3>
                </div>
            </div>
        </div>
        <hr>

        <div class="d-flex justify-content-between mb-3">
            <div>
                <h4>History Pembayaran</h4>
            </div>
            <div class="d-flex justify-content-center align-items-center">
                <div class="me-2"><b>NIS: {{ $siswa->nis }}</b></div>
                <div class="me-2"><b>Nama: {{ $siswa->user->name }}</b></div>
                <div class="me-2"><b>Kelas: {{ $siswa->kelas->kelas }}</b></div>
            </div>
            <div>
                <a href="{{ url('pembayaran') }}" class="btn btn-warning">Kembali</a>
            </div>
        </div>
        <table class="table table-striped ">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Petugas</th>
                    <th>Tanggal</th>
                    <th>SPP</th>
                    <th>Jumlah Bayar</th>
                </tr>
            </thead>
            <tbody>
                @if ($pembayaran->count() == 0)
                    <tr class="text-center">
                        <td colspan="6">Belum ada transaksi.</td>
                    </tr>
                @else
                    @foreach ($pembayaran as $data)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $data->user->name }}</td>
                            <td>{{ $data->tanggal_bayar }}</td>
                            <td>{{ $data->spp->tahun }}</td>
                            <td>{{ 'Rp.' . $data->jumlah_bayar }}</td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>

    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <form action="{{ url('pembayaran/simpan') }}" method="post">
            <div class="modal-body">
                @csrf
                <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                <input type="hidden" name="siswa_id" value="{{ $siswa->id }}">
                <div class="form-group">
                    <label for="petugas">Petugas</label>
                    <input type="text" name="petugas" id="petugas" readonly value="{{ auth()->user()->name }}"
                        class="form-control">
                </div>
                <div class="form-group">
                    <label for="siswa">Siswa</label>
                    <input type="text" name="siswa" id="siswa" readonly value="{{ $siswa->user->name }}"
                        class="form-control">
                </div>
                <div class="form-group mt-2">
                    <label for="spp_id">SPP</label>
                    <select name="spp_id" id="spp_id" class="form-select" required>
                        <option value="" disabled selected>-Pilih SPP-</option>
                        @foreach ($spp as $data)
                            @php
                                $kurang = $data->nominal - $pembayaranSPP[$loop->iteration - 1];
                                $kurangnya = "(Rp. $kurang)";
                            @endphp;
                            <option value=" {{ $data->id }}"
                                {{ $pembayaranSPP[$loop->iteration - 1] >= $data->nominal ? 'disabled' : '' }}>
                                {{ $data->tahun . ' - Rp. ' . $data->nominal }}
                                {{ $pembayaranSPP[$loop->iteration - 1] >= $data->nominal ? '(LUNAS)' : $kurangnya }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group mt-2">
                    <label for="tanggal_bayar">Tanggal</label>
                    <input type="date" name="tanggal_bayar" id="tanggal_bayar" class="form-control" required>
                </div>
                <div class="form-group mt-2">
                    <label for="jumlah_bayar">Jumlah Bayar</label>
                    <input type="number" name="jumlah_bayar" id="jumlah_bayar" class="form-control" required>
                </div>
            </div>
        </form>
    </div>
    </div>
    </div>
@endsection