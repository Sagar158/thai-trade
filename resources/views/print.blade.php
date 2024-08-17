<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <meta charset="utf-8">
    <style>
    /* Base styles */
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
    }

    table {
        border-collapse: collapse;
        width: 100%;
        margin: 0;
        padding: 0;
    }

    th, td {
        border: 1px solid #ddd;
        text-align: center;
        padding: 8px;
        box-sizing: border-box; /* Ensures padding is included in the width */
    }

    th {
        background-color: #f2f2f2;
    }

    .topct {
        padding: 0px;
    }

    hr {
        border: 1px solid #ddd;
    }

    .logo-container {
        text-align: center;
    }

    .logo {
        width: 78px;
        height: auto;
    }

    .center {
        text-align: center;
    }

    .address-details {
        text-align: center;
    }

    .printdate {
        font-size: 8px !important;
    }

    /* Styles for A4 Paper Size */
    @page {
        size: A4;
        margin: 1cm; /* Adjust margin as needed */
    }

    @media print {
        body {
            width: 21cm; /* A4 width */
            height: 29.7cm; /* A4 height */
            margin: 0;
            padding: 0;
        }

        table {
            width: calc(100% - 2cm); /* Adjust width for margins */
        }

        .address-details {
            font-size: 10px; /* Adjust font size for print */
        }

        .printdate {
            font-size: 8px !important;
        }
    }

    /* Styles for A5 Paper Size */
    @media print {
        body.a5 {
            width: 14.85cm; /* A5 width */
            height: 21cm; /* A5 height */
        }

        body.a5 table {
            width: calc(100% - 2cm); /* Adjust width for margins */
        }
    }
</style>


</head>

<body>

    @foreach ($repackProducts as $productId => $products)
        <table>
            <thead>
                <tr style="height:80px">
                    <th colspan="2" class="-container">
                        <img src="{{ asset('logo1.png') }}" alt="Logo" class="logo">
                    </th>
                    <th colspan="8" style="text-align: center">
                        <div class="address-details">
                            {!! optional($products[0]->customer)->addressDetails() ?? '' !!}
                        </div>
                    </th>
                    <th colspan="1" class="topct">
                        CS ID/CT.ID
                        <hr>
                        {{ $products[0]->ct_id }}
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td style="font-size: 12px; font-weight:bold;">SN<br>序号</td>
                    <td style="font-size: 12px; font-weight:bold;">BILL ID<br>帐单号</td>
                    <td style="font-size: 12px; font-weight:bold;">NAME<br>品名</td>
                    <td style="font-size: 12px; font-weight:bold;">CTNs<br>件数</td>
                    <td style="font-size: 12px; font-weight:bold;">P.TYPE<br>类型</td>
                    <td style="font-size: 12px; font-weight:bold;">WAREHOUSE<br>仓库</td>
                    <td style="font-size: 12px; font-weight:bold;">T.OPTION<br>运输方式</td>
                    <td style="font-size: 12px; font-weight:bold;">CUBE<br>立方数</td>
                    <td style="font-size: 12px; font-weight:bold;">STAFF<br>打单员</td>
                    <td style="font-size: 12px; font-weight:bold;">PRINT TIME<br>打印时间</td>
                    <td style="font-size: 12px; font-weight:bold;">BARCODE ID<br>条形码编号</td>
                </tr>
                @for ($i = 0; $i < 5; $i++)
                    <tr>
                        @if (isset($products[$i]))
                            <td style="font-size: 13px">{{ $i + 1 }}</td>
                            <td style="font-size: 13px">{{ $products[$i]->bill_id }}</td>
                            <td style="font-size: 13px">{{ $products[$i]->name }}</td>
                            <td style="font-size: 13px">{{ $products[$i]->tpcs }}</td>
                            <td style="font-size: 13px">{{ $products[$i]->type }}</td>
                            <td style="font-size: 13px">{{ $products[$i]->warehouse }}</td>
                            <td style="font-size: 13px">{{ $products[$i]->option }}</td>
                            <td style="font-size: 13px">
                                @if((float)$products[$i]->t_cube > 0)    
                                    {{ $products[$i]->t_cube }}
                                @else
                                    @php
                                        $num_for = number_format((($products[$i]->w * $products[$i]->h * $products[$i]->l) / 1000000) * $products[$i]->tpcs, 2);
                                    @endphp
                                    {{ $num_for }}
                                @endif
                            </td>
                            <td style="font-size: 13px">{{ auth()->user()->name }}</td>
                            <td style="font-size: 13px">{{ now() }}</td>
                            <td style="font-size: 13px">{{ $products[$i]->sku }}</td>
                        @else
                            <td style="font-size: 13px">{{ $i + 1 }}</td>
                            <td style="font-size: 13px">&nbsp;</td>
                            <td style="font-size: 13px">&nbsp;</td>
                            <td style="font-size: 13px">&nbsp;</td>
                            <td style="font-size: 13px">&nbsp;</td>
                            <td style="font-size: 13px">&nbsp;</td>
                            <td style="font-size: 13px">&nbsp;</td>
                            <td style="font-size: 13px">&nbsp;</td>
                            <td style="font-size: 13px">&nbsp;</td>
                            <td style="font-size: 13px">&nbsp;</td>
                            <td style="font-size: 13px">&nbsp;</td>
                        @endif
                    </tr>
                @endfor
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="1" style="font-size: 20px;height:30px">Information</td>
                    <td colspan="10" style="font-size: 20px;height:30px">ประเทศไทย ความประสง สามารถติดต่อได้ที่ 123456789</td>
                </tr>
                <tr>
                    <td colspan="1" style="text-align: center">Remarks</td>
                    <td colspan="10" style="text-align: center">Preferred WULIU: {{ $products[0]->customer->Preferred_WULIU ?? '' }}</td>
                </tr>
                <tr>
                    <th rowspan="2" style="font-size: 13px">{{ $products[0]->customer->remarks ?? '' }}</th>
                    <th colspan="1" class="center" style="font-size: 13px">STAFF/员工:</th>
                    <th colspan="3" class="center" style="font-size: 13px">SONGHUO REN/送货人:</th>
                    <th colspan="4" class="center" style="font-size: 13px">SOUHUO REN/收货人:</th>
                    <th colspan="3" class="center" style="font-size: 13px">RIQI SOUHUO/收货日期:</th>
                </tr>
                <tr>
                    <td colspan="1" style="height:50px" class="center"></td>
                    <td colspan="3" style="height:50px" class="center"></td>
                    <td colspan="4" style="height:50px" class="center"></td>
                    <td colspan="3" style="height:50px" class="center"></td>
                </tr>
            </tfoot>
        </table>

        <!-- Generate QR Code -->
        @foreach ($products as $product)
            <div class="qr-code">
                <div id="qrcode-{{ $product->bill_id }}"></div>
            </div>
            <script>
                $(document).ready(function() {
                    var billId = '{{ $product->bill_id }}';
                    var option = '{{ $product->option }}';
                    var statusToUpdate = (option === 'EK') ? 8 : (option === 'SEA') ? 17 : null;

                    // Generate QR Code
                    QRCode.toCanvas(document.getElementById('qrcode-' + billId), billId, function (error) {
                        if (error) console.error(error);
                        console.log('QR Code generated!');
                    });
                });
            </script>
        @endforeach

        @if (!$loop->last)
            <div style="page-break-after:always;"></div>
        @endif
    @endforeach
</body>




</html>
