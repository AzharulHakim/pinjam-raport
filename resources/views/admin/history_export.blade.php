<!DOCTYPE html>
<html>

<head>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>

<body>
    <h3>Riwayat Peminjaman Raport</h3>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>NIS</th>
                <th>Nama Siswa</th>
                <th>Kelas</th>
                <th>Tanggal Peminjaman</th>
                <th>Waktu</th>
                <th>Status</th>
                <th>Diwakilkan Oleh (NIS - Nama - Kelas)</th>
                <th>Alasan</th>
            </tr>
        </thead>
        <tbody>
            @foreach($loans as $index => $loan)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $loan->student->nis }}</td>
                    <td>{{ $loan->student->name }}</td>
                    <td>{{ $loan->class_level }} {{ $loan->major }} {{ $loan->class_letter }}</td>
                    <td>{{ $loan->created_at->format('d-m-Y') }}</td>
                    <td>{{ $loan->created_at->format('H:i') }}</td>
                    <td>{{ ucfirst($loan->status) }}</td>
                    <td>
                        @if($loan->representative)
                            {{ $loan->representative->nis }} - {{ $loan->representative->name }} -
                            {{ $loan->representative->schoolClass ? $loan->representative->schoolClass->name : '-' }}
                        @else
                            -
                        @endif
                    </td>
                    <td>{{ $loan->reason }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>