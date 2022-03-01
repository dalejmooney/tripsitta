<!doctype html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Invoice</title>

    <style>
        .invoice-box {
            max-width: 800px;
            margin: auto;
            padding: 30px;
            border: 1px solid #eee;
            box-shadow: 0 0 10px rgba(0, 0, 0, .15);
            font-size: 16px;
            line-height: 24px;
            font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
            color: #555;
        }

        .invoice-box table {
            width: 100%;
            line-height: inherit;
            text-align: left;
        }

        .invoice-box table td {
            padding: 5px;
            vertical-align: top;
        }

        .invoice-box table tr td:nth-child(2) {
            text-align: right;
        }

        .invoice-box table tr.top table td {
            padding-bottom: 20px;
        }

        .invoice-box table tr.top table td.title {
            font-size: 45px;
            line-height: 45px;
            color: #333;
        }

        .invoice-box table tr.information table td {
            padding-bottom: 40px;
        }

        .invoice-box table tr.heading td {
            background: #eee;
            border-bottom: 1px solid #ddd;
            font-weight: bold;
        }

        .invoice-box table tr.details td {
            padding-bottom: 20px;
        }

        .invoice-box table tr.item td{
            border-bottom: 1px solid #eee;
        }

        .invoice-box table tr.item.last td {
            border-bottom: none;
        }

        .invoice-box table tr.total td:nth-child(2) {
            border-top: 2px solid #eee;
            font-weight: bold;
        }

        .invoice-box table tr.bottom td{
            padding-top:20%;
            text-align: center;
        }

        .is-bold{
            font-weight: bold;
        }

        .capitalize{
            text-transform: capitalize;
        }

        @media only screen and (max-width: 600px) {
            .invoice-box table tr.top table td {
                width: 100%;
                display: block;
                text-align: center;
            }

            .invoice-box table tr.information table td {
                width: 100%;
                display: block;
                text-align: center;
            }
        }

        /** RTL **/
        .rtl {
            direction: rtl;
            font-family: Tahoma, 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
        }

        .rtl table {
            text-align: right;
        }

        .rtl table tr td:nth-child(2) {
            text-align: left;
        }
    </style>
</head>

<body>
<div class="invoice-box">
    <table cellpadding="0" cellspacing="0">
        <tr class="top">
            <td colspan="2">
                <table>
                    <tr>
                        <td class="title">
                            <img src="./images/Tripsitta-combo.png" style="width:150px;">
                        </td>

                        <td>
                            Invoice #: {{$invoice->reference}}<br>
                            Created: {{$invoice->created_at->format('d M Y')}}<br>
                            Due: {{$invoice->created_at->addDays(2)->format('d M Y')}}
                        </td>
                    </tr>
                </table>
            </td>
        </tr>

        <tr class="information">
            <td colspan="2">
                <table>
                    <tr>
                        <td>
                            Tripsitta Ltd, <br />6 Penland Road, <br />Bexhill On Sea, TN40 2JG, <br />United Kingdom
                        </td>

                        <td>
                            {{$invoice->babysitter->user->fullName}}<br />
                            @if($invoice->babysitter_address !== 'null' && is_array($invoice->babysitter_address))
                                {{$invoice->babysitter_address['address1']}}<br>
                                @if($invoice->babysitter_address['address2'] !== '')
                                    {{$invoice->babysitter_address['address2']}} <br />
                                @endif
                                {{$invoice->babysitter_address['town']}}, {{$invoice->babysitter_address['postcode']}}<br>
                                @if($invoice->babysitter_address['country'] !== '')
                                    {{Countries::getOne($invoice->family_address['country'])}}<br>
                                @endif
                            @endif
                        </td>
                    </tr>
                </table>
            </td>
        </tr>

        <tr class="information">
            <td colspan="2">
                <table>
                    <tr>
                        <td>
                            Booking ID: <strong class="is-bold">{{$invoice->booking->idPadded}}</strong>
                        </td>
                        <td>{{$invoice->booking->startDate}} - {{$invoice->booking->endDate}}</td>
                    </tr>
                </table>
            </td>
        </tr>


        <tr class="heading">
            <td>
                Description
            </td>

            <td>
                Price
            </td>
        </tr>

        <tr class="item">
            <td>
                <span class="capitalize">{{$invoice->type}}</span>{{$invoice->description ? ' - '.$invoice->description : ''}}
            </td>
            <td>
                {!! $invoice->amountDueFormatted !!}
            </td>
        </tr>
        <tr class="item last">
            <td>
                <span class="capitalize">Tripsitta Service Fee</span>
            </td>
            <td>
                - {!! $invoice->adminEarningFormatted !!}
            </td>
        </tr>

        <tr class="total">
            <td></td>
            <td>
                Total: {!! $invoice->babysitterEarningFormatted !!}
            </td>
        </tr>

        <tr class="bottom">
            <td colspan="2">
                <strong class="is-bold">Thank you for your booking!</strong> <br> If you didn't already, please remember to contact babysitter to confirm booking details. In case of any problems you can always contact Tripsitta directly and we'll do our best to help.
            </td>
        </tr>
        <tr>
            <td colspan="2" style="font-size:12px; text-align: center">
                Tripsitta Ltd is the agent for this booking / purchase.<br />
                Tripsitta Ltd, 6 Penland Road, Bexhill On Sea, TN40 2JG, United Kingdom. Company reg number: 11725982
            </td>
        </tr>
    </table>
</div>
</body>
</html>
