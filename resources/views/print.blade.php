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
        table {
            border-collapse: collapse;
            width: 100%;
        }

        th,
        td {
            border: 1px solid #ddd;
            text-align: center;
            padding: 8px;
        }

        .topct {
            padding: 0px;
        }

        hr {
            border: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
        }

        .logo-container {
            text-align: center;
            /* height: 130px; */
        }

        .logo {
            width: 78px;
            height: auto;
        }

        .center {
            text-align: center;
        }

        @media print {
            .address-details {}

            .printdate {
                font-size: 8px !important;
            }
        }
    </style>

</head>

<body>

    @foreach ($repackProducts as $productId => $products)
        <table>
            <thead>
                <tr style="height:100px">
                    <th colspan="2" class="-container">
                        <img src="{{ asset('logo1.png') }}" alt="Logo" class="logo">
                    </th>
                    <th colspan="7" style="text-align: center">
                        <div class="address-details">
                            {!! optional($products[0]->customer)->addressDetails() ?? '' !!}
                        </div>
                    </th>
                    <th colspan="1" class="topct">
                        CT.ID
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

                            @if((float)$products[$i]->t_cube > 0  )    
                                {{$products[$i]->t_cube}}
                            @else
                                @php
                                    $num_for = number_format((($products[$i]->w * $products[$i]->h * $products[$i]->l) / 1000000) * $products[$i]->tpcs, 2) ;
                                @endphp
                                {{ $num_for }}
                                
                            @endif
                                
                            </td>
                            <td style="font-size: 13px">{{ auth()->user()->name }}</td>
                            <td class="printdate" style="font-size: 13px">{{ now() }}</td>
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
                        @endif
                    </tr>
                @endfor



            </tbody>
            <tfoot>
                <tr>
                    <td colspan="10" style="text-align: center">Preferred WULIU:
                        {{ $products[0]->customer->Preferred_WULIU ?? '' }}</td>
                </tr>
                <tr>
                    <td colspan="10" style="font-size: 25px;height:40px">ประเทศไทย ความประสง สามารถติดต่อได้ที่
                        1234567</td>
                </tr>
                <tr>
                    <th colspan="3" class="center" style="font-size: 13px">SONGHUO REN/送货人:</th>
                    <th colspan="4" class="center" style="font-size: 13px">SOUHUO REN/收货人:</th>
                    <th colspan="3" class="center" style="font-size: 13px">RIQI SOUHUO/收货日期:</th>
                </tr>
                <tr>
                    <td colspan="3" style="height:50px" class="center"></td>
                    <td colspan="4" style="height:50px" class="center"></td>
                    <td colspan="3" style="height:50px" class="center"></td>
                </tr>

            </tfoot>
        </table>
        @if (!$loop->last)
            <div style="break-after:page"></div>
        @endif
    @endforeach
</body>



</html>
