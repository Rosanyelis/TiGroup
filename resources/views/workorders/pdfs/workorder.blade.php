<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orden de Trabajo</title>
</head>
<body>
    <table cellspacing="0" style="width: 100%; border-collapse: collapse; font-family: Arial, Helvetica, sans-serif">
        <thead>
            <tr>
                <th colspan="4" style="text-align: left; ">
                    <img src="{{ public_path('assets/img/tigroup.png') }}" alt="logo" height="70">
                    <h5>
                        Doctor Manuel Barro Borgoño 138 <br>
                        Providencia,  Santiago <br>
                        ventas@tigroup.cl - 233125091
                    </h5>
                </th>

                <th colspan="4" style="text-align: right;">
                    <h3 style="line-height: 0;">
                        Orden de Trabajo N° {{ $workorder->correlativo }}
                    </h3>
                    <h4 style="line-height: 0;">{{ \Carbon\Carbon::now('America/Santiago')->translatedFormat('l, d \d\e F \d\e Y'); }}</h5>
                </th>
            </tr>
        </thead>
        <tbody>
            <tr style="margin-top: 40px;">
                <td colspan="4" >
                    <strong>Cliente:</strong>
                    {{ $workorder->customer->business_name }}
                </td>
                <td colspan="4" >
                    <strong>Dirección:</strong>
                    <span style="text-align: right;">{{ $workorder->customer->address }}</span>
                </td>
            </tr>
            <tr>
                <td colspan="4" >
                    <strong>Atención:</strong>
                    {{ $workorder->customer->name }} </td>
                <td colspan="4" >
                    <strong>Teléfono:</strong>
                    <span style="text-align: right;"> {{ $workorder->customer->phone }} a</span>
                </td>
            </tr>
        </tbody>
    </table>
    <table cellspacing="0" style="width: 100%; margin-top: 40px; border-collapse: collapse; font-family: Arial, Helvetica, sans-serif">
        <thead>
            <tr style="text-align: left; font-size: 18px; border-bottom: 1px solid #0483b2">
                <th colspan="2">Actividades o Tareas</th>
            </tr>
            <tr style="text-align: left; font-size: 14px; border-bottom: 1px solid #0483b2">
                <th>#</th>
                <th>Actividades</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($workorder->tasks as $item)
                <tr style="font-size: 16px">
                    <td width="5%">{{ $loop->iteration }}</td>
                    <td>{{ $item->task }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <table cellspacing="0" style="width: 100%; margin-top: 40px; border-collapse: collapse; font-family: Arial, Helvetica, sans-serif">
        <thead>
            <tr style="text-align: center; font-size: 18px; border-bottom: 1px solid #0483b2">
                <th colspan="8" style="text-align: center; font-weight: bold">Detalles de Productos o Servicios</th>
            </tr>
            <tr style="text-align: center; font-size: 14px; border-bottom: 1px solid #0483b2">
                <th colspan="2">Producto</th>
                <th colspan="2">Cantidad</th>
                <th colspan="2">Precio Unit.</th>
                <th colspan="2">Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($workorder->items as $item)
                <tr style="text-align: center; font-size: 16px">
                    <td colspan="2">{{ $item->product->name }}</td>
                    <td colspan="2">{{ $item->quantity }}</td>
                    <td colspan="2">{{ number_format($item->price + $item->margen, 0, ',', '.') }}</td>
                    <td colspan="2">{{  number_format($item->quantity * ($item->price + $item->margen), 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot style="border-top: 1px solid #0483b2; padding-top: 20px">
            <tr>
                <td colspan="6" style="text-align: right; font-weight: bold">Total:</td>
                <td colspan="2" style="text-align: center;">$ {{ number_format($workorder->total, 0, ',', '.') }}</td>
            </tr>
        </tfoot>
    </table>
    <div style="position: fixed; bottom: 0; width: 100%; border-top: 1px solid #0483b2">
        <div style="text-align: center;font-family: Arial, Helvetica, sans-serif">
            <p>
                Doctor Manuel Barro Borgoño 138 <br>
                Providencia,  Santiago <br>
                ventas@tigroup.cl - 233125091
            </p>
        </div>
    </div>
</body>
</html>
