<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>StarBucks</title>
    <style>
        body {
            width: 80%;
            margin: auto;
            padding: 5%;
            font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto,
            Oxygen, Ubuntu, Cantarell, "Open Sans", "Helvetica Neue", sans-serif;
        }
        .logo {
            margin-bottom: 20px;
        }
        /* .str {
            font-size: 14px;
        } */
        .head {
            display: flex;
            justify-content: space-between;
        }
        .right {
            display: flex;
            flex-direction: column;
            align-items: flex-end;
        }
        .tax {
            color: #ffc000;
            font-size: 35px;
            margin-right: 12%;
        }
        .leftTab {
            margin: 40px 0 10px 0;
        }

        table {
            font-size: 20px;
        }

        .address {
            padding: 10px 0;
        }

        .address-3 {
            padding: 20px 0;
        }

        .datee {
            padding: 10px 110px;
        }

        .tab {
            width: 100%;
            overflow-x: auto;
            border-spacing: 3px;
        }

        .tab th {
            text-align: left;
            padding: 5px;
            background-color: #ffc000;
            color: white;
        }

        .row-2 td {
            font-size: 16px;
            background-color: #DBDCDB;
            padding: 5px;

        }

        .row-3 td {
            font-size: 16px;
            background-color: #EDEDEC;
            padding: 5px;

        }

        .amount {
            text-align-last: end;
            padding-right: 20px !important;
        }

        .sub {
            display: flex;
            justify-content: flex-end;
            margin-top: 20px;
        }

        .subPrice {
            padding: 5px 20px 5px 160px;
            text-align: end;
            font-size: 16px;
        }

        .topHr {
            border: 2px solid black;
        }

        .total {
            display: flex;
            justify-content: flex-end;
            /* margin-top: 20px; */
        }

        .totalPrice {
            padding: 5px 20px 5px 120px;
            text-align: end;
            font-size: 25px;
        }

        .bottomHr {
            border: 1px solid black;
        }

        .last {
            display: flex;
            justify-content: space-between;
            margin: 30px 0;
        }

        .note {
            margin-top: 100px;
            font-size: 18px;
        }

        .table-heading {
            color: #ffc000;
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 10px;
        }
    </style>
</head>

<body>

<header>
    <div class="logo">
        <img src="{{asset('assets/images/starbuck-logo-black.png')}}" alt="logo" style="width: 25%" />
    </div>

    <div class="head">
        <div class="left">
            <h1 class="str">Starbuck Excavation Pty Ltd</h1>
            <p>15/882-900 Cooper Street, Somerton VIC 3062</p>
            <strong>www.starbuckexcavations.com.au</strong>
            <p>ABN 51 253 288 279</p>
            <p>ACN 169 208 780</p>

            <div class="leftTab">
                <table style="font-size: 16px">
                    <tr>
                        <td class="address"><strong>Bill To:</strong></td>
                        <td>{{ $mailData['invoice']->client->name }}</td>
                    </tr>
                    <tr>
                        <td class="address"><strong>Address:</strong></td>
                        <td>{{ $mailData['invoice']->client->address }}</td>
                    </tr>
                    <tr>
                        <td class="address-3"><strong>Job Location:</strong>
                        </td>
                        <td> &nbsp;{{ $mailData['invoice']->job->job_location }}</td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="right">
            <h1 class="tax">Tax Invoice</h1>
            <div class="rightTab">
                <table style="font-size: 16px">
                    <tr>
                        <td class="datee">Invoice No</td>
                        <td class="datee"><strong>{{ $mailData['invoice']->id }}</strong></td>
                    </tr>
                    <tr>
                        <td class="datee">Invoice Date</td>
                        <td class="datee"><strong>{{ $mailData['invoice']->created_at }}</strong></td>
                    </tr>
                    <tr>
                        <td class="datee">Job No</td>
                        <td class="datee"><strong>{{ $mailData['invoice']->job_id }}</strong>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</header>
<main>
    @if(count($mailData['invoice']->invoiceProducts) > 0)
    <h4 class="table-heading">
        Invoice Products
    </h4>
    <table class="tab">
        <tr>
            <th>DATE</th>
            <th>DESCRIPTION</th>
            <th>DOCKET #</th>
            <th>QTY</th>
            <th>RATE</th>
            <th>UNIT</th>
            <th class="amount">AMOUNT ($)</th>
        </tr>
            @foreach( $mailData['invoice']->invoiceProducts as $prod)
                <tr class="row-2">
                    <td>{{ $prod->created_at }}</td>
                    <td>{{ $prod->name .' '. $prod->description }}</td>
                    <td>{{ $prod->docket }}</td>
                    <td>{{ $prod->quantity }}</td>
                    <td>$ {{ $prod->price }}</td>
                    <td>{{ $prod->uom }}</td>
                    <td class="amount">$ {{ $prod->price * $prod->quantity }}</td>
                </tr>
            @endforeach
    </table>
    @endif
    <br> <br>
   @if(count($mailData['invoice']->invoiceItems) > 0)
    <h4 class="table-heading">
        Invoice Assets
    </h4>
    <table class="tab">
        <tr>
            <th>DATE</th>
            <th>START TIME</th>
            <th>END TIME</th>
            <th>ASSET NAME</th>
            <th>DIFFERENCE</th>
            <th>RATE</th>
            <th class="amount">AMOUNT ($)</th>
        </tr>
            @foreach( $mailData['invoice']->invoiceItems as $item)

                <tr class="row-2">
                    <td>{{ $item->created_at }}</td>
                    <td>{{ $item->start_time }}</td>
                    <td>{{ $item->end_time }}</td>
                    <td>{{ $item->asset->name }}</td>
                    <td>{{ $item->total_time }} hours</td>
                    <td>$ {{ $item->asset->avg_hourly_rate }}</td>
                    <td class="amount">
                        $ {{ $item->asset->avg_hourly_rate * $item->total_time }}
                    </td>
                </tr>
            @endforeach
    </table>
    @endif
</main>

<footer>
    <div class="sub">
        <table>
            <tr>
                <td class="subPrice"><strong>Subtotal</strong></td>
                <td class="subPrice">$ {{ $mailData['invoice']->subTotal }}</td>
            </tr>
            <tr>
                <td class="subPrice"><strong>GST</strong></td>
                <td class="subPrice">$ {{ $mailData['invoice']->gst }}</td>
            </tr>
            <tr>
                <td class="subPrice"><strong>Balance Due</strong>
                </td>
                <td class="subPrice">$ {{ $mailData['invoice']->finalTotal }}</td>
            </tr>
        </table>
    </div>
    <hr class="topHr">
    <div class="total">
        <table>
            <tr>
                <th class="totalPrice">Invoice Total</th>
                <th class="totalPrice">$ {{ $mailData['invoice']->finalTotal }}</th>
            </tr>
        </table>
    </div>
    <hr class="bottomHr">

    <div class="last">
        <div class="left">
            <p>BANK ACCOUNT DETAILS</p>
            <p>Account Name: <strong>{{ $mailData['invoice']->account_name }}</strong></p>
            <p>BSB: <strong>{{ $mailData['invoice']->account_bsb }}</strong></p>
            <p>ACCOUNT: <strong>{{ $mailData['invoice']->account_number }}</strong></p>
            <i>Please reference invoice number</i>
        </div>
        <div class="right">
            <p><strong>Terms: {!! $mailData['invoice']->terms !!}</strong></p>
            <p><strong>Please forward all enquiries to<br> {{ $mailData['invoice']->inquiry_email }}</strong></p>
        </div>
    </div>
    <div class="note">
        {!! $mailData['invoice']->note !!}
    </div>
</footer>
</body>
</html>
