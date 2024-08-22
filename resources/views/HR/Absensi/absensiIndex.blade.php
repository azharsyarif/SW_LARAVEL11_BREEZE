<h1>Absensi</h1>

<table>
    <thead>
        <tr>
            <th>NIP</th>
            <th>Tanggal</th>
            <th>Jam Masuk</th>
            <th>Jam Keluar</th>
        </tr>
    </thead>
    <tbody>
        @foreach($absensis as $absen)
            <tr>
                <td>{{ $absen->nip }}</td>
                <td>{{ $absen->tanggal }}</td>
                <td>{{ $absen->jam_masuk }}</td>
                <td>{{ $absen->jam_keluar }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

<a href="{{ route('absensi.create') }}">Buat Absensi Baru</a>
