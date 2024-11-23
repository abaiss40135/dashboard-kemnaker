


<html>

  <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        @import('https://fonts.googleapis.com/css2?family=Poppins&display=swap');
        body{
            font-family: 'Poppins' , sans-serif;
        }
        tr , td , th{
            border: 1px solid #000;
            padding: 5px 20px;
            margin: 0;
        
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-left: -10px !important;
        }
        table , h2{
            font-family: 'Poppins' , sans-serif;
        }
        thead{
            background: #1E4588;
            color: #fff;
        }

        .text-center{
            text-align: center;
        }
    </style>
    <body>
        

        <main>
            <h2 class="text-center">Daftar Data Diri Satpam</h2>
            <br>


            <table class="table table-bordered mb-5">
                <thead>
                    <tr class="table-danger">
                        <th scope="col">NO</th>
                        <th scope="col">No KTP</th>
                        <th scope="col">Nama Satpam</th>
                        <th scope="col">Badan Usaha</th>
                        <th scope="col">Polda</th>
                    </tr>
                </thead>
                <tbody>
                   
                    @foreach($data as $satpam)
                    <tr>
                        <th scope="row">{{ $loop->iteration }}</th>
                        <td> {{ $satpam->no_ktp }} </td>
                        <td> {{ $satpam->nama }} </td>
                        <td> {{ $satpam->bujp->nama_badan_usaha}}  </td>
                        <td> {{ $satpam->provinsi == 'DKI JAKARTA' ? 'Metro Jaya' : $satpam->provinsi }}  </td>
                    
                    </tr>
                    @endforeach
                </tbody>
            </table>
        
        </div>
        
        </main>

    </body>
</html>


