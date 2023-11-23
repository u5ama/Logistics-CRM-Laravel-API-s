<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        .body {
            margin: 0 auto;
        }
        .banner img {
            width: 100%;
            height: 470px;
            object-fit: cover;
        }

        .exp {
            font-size: 50px;
            font-weight: bold;
            text-align: center;
            margin-top: 60px;
            margin-bottom: 300px;
        }

        .info {
            text-align: right;
            margin-bottom: 60px;
        }

        .addr {
            font-size: 37px;
            font-weight: bold;
            margin-bottom: 30px;
        }

        .details {
            font-size: 17px;
        }

        @media screen and (max-width: 600px) {
            .body {
                width: 100%;
            }

            .info {
                padding: 0 10px;
                margin-bottom: 30px;
            }

            .exp {
                font-size: 30px;
                margin-bottom: 200px;
            }

            .addr {
                font-size: 17px;
            }

            .details {
                font-size: 15px;
            }
        }
        body{
            background-color: #f5f2eb;
            font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto,
            Oxygen, Ubuntu, Cantarell, "Open Sans", "Helvetica Neue", sans-serif;
        }
        .top {
            width: 58%;
            margin: auto;
            padding: 1%;
            background-color: #a3a3a3;
            color: white;
            font-size: large;
        }
        .valid {
            margin-top: -85px;
            display: flex;
            justify-content: flex-end;
            text-align: end;
        }
        .valid h1 {
            font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
            font-size: 40px;
            margin-bottom: 5px;
        }
        .content{
            background-color: white;
            width: 50%;
            margin: auto;
            padding: 5%;
        }
        .photo {
            padding: 0 40px;
        }
        .sign {
            width: 20%;
            margin-left: -40px;
        }
        .yel {
            color: #f2ca16;
        }
        .quote {
            padding: 0 2%;
            font-size: 13px;
            color: #a3a3a3;
        }
        .detail {
            margin: 30px 0;
        }
    </style>
    <title>StarBuck</title>
</head>

<body>
<div class="body">
    <div class="banner">
        <img src="{{asset('assets/images/banner_2.jpg')}}" alt="banner" />
    </div>
    <div class="content">
        <div class="">
            <p class="exp">{{ $mailData['quote']->client->name }}</p>
        </div>
        <div class="info">
            <p class="addr">{{ $mailData['quote']->job_title }} / ADDRESS</p>
            <div>
                <p class="details">{{ $mailData['quote']->location }}</p>
            </div>
        </div>
    </div>
</div>
<header>
    <div class="top">
        <div class="logo">
            <img src="{{asset('assets/images/starbuck-logo-black.png')}}" alt="logo" style="width: 30%" />
        </div>
    </div>
</header>

<main>
    <div class="content">
        <div class="valid">
            <div>
                <h1>QUOTE</h1>
                <i>Valid for 30 days from date listed below: <br> {{ $mailData['quote']->created_at }} </i>
            </div>
        </div>
        <div>
            <strong>
                {{ $mailData['quote']->client->name }} <br>
                {{ $mailData['quote']->client->address }}<br>
            </strong>
            <p>Dear {{ $mailData['quote']->client->name }},</p>
            <strong>Re: {{ $mailData['quote']->location }}</strong>
            <p>The price quoted for the excavation works at the above-mentioned address is: ${{ $mailData['quote']->total_price }} plus GST</p>
            <strong>The quoted price includes:</strong>
            @if( count($mailData['quote']->quoteItems) > 0)
                @foreach($mailData['quote']->quoteItems as $item)
                    <div>
                        <ul>
                            <li>
                                <p><strong>{{ $item->title }}</strong><br>
                                   {!! $item->description !!}
                                </p>
                            </li>
                        </ul>
                        <br />
                    </div>
                @endforeach
            @endif
        </div>
        <div>
            <p><strong>The above pricing excludes:</strong></p>
            <ul>
                <li><strong>Any / all rock extraction, removal, and / or disposal</strong></li>
                <li><strong>Any / all contaminated material and / or any material not classified as “clean
                        fill”</strong>
                </li>
            </ul>
        </div>
        <div>
            <h5>TERMS & CONDITIONS</h5>
            <p>
                {!! $mailData['quote']->terms_conditions !!}
            </p>
            <p>
                {!! $mailData['quote']->over_rate !!}
            </p>
            <p>Kind Regards,</p>
            <img src="{{asset('assets/images/Sign.jpg')}}" class="sign" alt="">
            <p>
                <strong>{{ $mailData['quote']->setting->op_manager_name }}</strong><br>
                Operations Manager <br>
                <span class="yel">Starbuck Excavation Pty Ltd</span><br>
                <strong>M: {{ $mailData['quote']->setting->op_manager_phone }}</strong> <br>
                <strong>E:</strong> {{ $mailData['quote']->setting->op_manager_email }}
            </p>
        </div>
        <div class="quote">
            <p>
                {!! $mailData['quote']->setting->quote_note !!}
            </p>
        </div>
        <div class="detail">
            <strong>I/We wish to proceed with the services outlined in this quotation:</strong>
            <p>Name: ………………………………………………………………</p>
            <p>Company Name: {{ $mailData['quote']->setting->company_name }} </p>
            <p>Purchase Order: ………………………………………………………………</p>
            <p>Date: ………………………………………………………………</p>
        </div>

        <div>
            <strong>I also confirm I am duly authorized to act on behalf of {{ $mailData['quote']->setting->company_name }} </strong>
            <p>Signed: ………………………………………………………………</p>
            <p>Name: ………………………………………………………………</p>
            <p>Position: ……………………………………………………………</p>
            <p>Date: ………………………………………………………………</p>
        </div>
    </div>
</main>
</body>
</html>
