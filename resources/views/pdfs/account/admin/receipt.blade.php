


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>SPR - {{$student->first_name}} {{$student->middle_name}} {{$student->last_name}}</title>
    <style type="text/css">
        .content-table{
            border-collapse: collapse;
            margin: 25px; 0;
            font-size: 0.9em;
            min-width: 400px;
            overflow: hidden;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.15);
            /* box-shadow: 0 2px 12px rgba(22,22,22,0.1); */
            /* border-radius: 12px 12px 0 0; */
            border: 3px solid black;

        }

        .content-table thead tr{
            color: #14211e;
            background-color: #ffffff;
            text-align: left;
            font-weight: bold;

        }
        .content-table th,
        .content-table td{
            padding: 5px 15px;
        }
        .content-table tbody tr{
            border-bottom: 2px solid #dddddd;
        }
        .content-table tbody tr:nth-of-type(even){
            background-color: #f3f3f3;
        }
        .content-table tbody tr:last-of-type{
            border-bottom: 5px solid black;
        }
        .content-table th{
            background-color: rgb(72, 67, 67);
            color: white;
        }
        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .text-left {
            text-align: left;
        }
        p{
            font-size: 1em;
        }
    </style>
</head>
<body>
<div class="container" style="margin-top: -30px;">
<div class="row">
    <div class="col-md-12">
       <table width="100%">
           <tr>
               <td class="text-center" width="15%">
                {{-- <img src="{{asset("uploads").'/'.$school->username.'/'.$school->logo}}" style="width: 80px; height: 80px;"> --}}
            </td>
               <td class="text-center" width="85%">
                <{{$school->heading}} style="text-transform: uppercase;"><strong>{{$school->name}}</strong></{{$school->heading}}>
                <h4 style="margin-top: -15px;"><strong>{{@$school->motto}}</strong></h4>
                <h5 style="margin-top: -10px;"><strong>Tel: {{ @$school->phone_first }}, {{ @$school->phone_second }} | website: {{ @$school->website}} | Email: {{$school->email}}</strong></h5>
                <h5 style="margin-top: -20px;"><strong>{{ @$school->address }}</strong></h5>
            </td>

           </tr>
       </table>
       <div style="margin-top: -20px;">
        <hr style="margin-bottom: 30px; color: black;">
       </div>
    </div>


    <div style="width: 100%">
        <div style="width: 50%; float: left;">

            <p style="margin-top: -10px;"><strong>Roll Number:</strong> {{$student->login}}</p>
            <p style="margin-top: -15px;"><strong>Name:</strong> {{$student->first_name}}  {{$student->middle_name}}  {{$student->last_name}}</p>
            {{-- <p style="margin-top: -15px;"><strong>Class: </strong> {{$student['class']['name']}}  {{$student['class_section']['name']}}</p>
            @if($student['parent']['first_name'] != null)<p style="margin-top: -15px;"><strong>Parent/Guardian: </strong> {{$student['parent']['first_name']}}  {{$student['parent']['middle_name']}}  {{$student['parent']['last_name']}}</p>@endif
            @if($student['parent']['phone'] != null) <p style="margin-top: -15px;"><strong>Mobile Number: </strong> {{$student['parent']['phone']}}</p>@endif --}}
     </div>



        <div style="width:50%; float: right; margin-top: -10px;">

            <p style="margin-top: -10px;"><strong>Total Amount Payable:</strong> N{{number_format($payment_slip->payable,0)}}</p>
            <p style="margin-top: -15px;"><strong>Amount Paid (This Transaction):</strong> N{{number_format($payment_record->paid_amount,0)}}</p>
            <p style="margin-top: -15px;"><strong>Total Amount Paid:</strong> N{{number_format($payment_slip->paid,0)}}</p>
            <p style="margin-top: -15px;"><strong>Payment Description:</strong>{{$payment_record->description}}</h5></p>
            <p style="margin-top: -15px;"><strong>Balance:</strong> N</span>{{number_format(($payment_slip->payable - $payment_slip->discount) - $payment_slip->paid,2)}}</p>
            <p style="margin-top: -15px;"><strong>Processed:</strong> {{$payment_record->created_at->format('l, jS \of F Y')}}</p>
        </div>
    </div>

    <div style="width: 100%; clear: both; overflow: auto; border-top: 2px solid black;">
        @php
            $session = App\Models\Session::select('name')->where('id',$payment_record->session_id)->first()
        @endphp
        <h2 style="font-size: 20px; text-align: center; font-style:oblique; ">{{ $session->name }} {{ ucfirst($payment_record->term) }} Term Fee Collection - Student Payment Receipt</h2>
    </div>


    <div style="width: 100%; overflow: auto; clear:both; margin-top: 0px;">
        <div style="width: 80%; margin: 0 auto;">
            <h4 style="font-size: 16px; text-align: center; text-transform: initial; margin-top: -30px;"> Payment Details for:</h5>
            <h6 style="font-size: 14px; text-align: center; text-transform: initial; font-style:oblique; line-height: 1.2em;">({{$student->login}} -  {{$student['class']['name']}})</h6>
            <table border="1" width="100%" cellpadding="1" cellspacing="2" style="margin-top: -50px;" class="content-table">
                <thead>
                    <tr>
                        <th class="text-center" style="width: 15%;">S/N</th>
                        <th class="text-center"  style="width: 50%;">Item/Description</th>
                        <th class="text-center"  style="width: 35%;">Cost (<span style="text-decoration: line-through; text-decoration-style: double;">N</span>)</th>
                    </tr>
                </thead>
                <tbody>

                        <tr>
                            <td class="text-center">1</td>
                            <td class="text-left">School Fee Payable</td>
                            <td class="text-center">{{number_format($payment_slip->payable,0)}}</td>
                        </tr>
                        <tr>
                            <td class="text-center">2</td>
                            <td class="text-left">Late Payment Surcharge</td>
                            <td class="text-center">0.00</td>
                        </tr>

                        {{-- <tr>
                            <td class="text-center"></td>
                            <td class="text-right">Total Amount Payable</td>
                            <td class="text-center">{{number_format($sum,0)}}</td>
                        </tr> --}}
                        <tr>
                            <td class="text-center"></td>
                            <td class="text-right">Total Amount Paid</td>
                            <td class="text-center">{{number_format($payment_slip->paid,0)}}</td>
                        </tr>
                        <tr>
                            <td class="text-center"></td>
                            <td class="text-right"><strong>Outstanding Balance</strong></td>
                            <td class="text-center"><strong>{{number_format(($payment_slip->payable - $payment_slip->discount) - $payment_slip->paid,2)}}</strong></td>
                        </tr>
                </tbody>
            </table>
        </div>

            <div style="width: 90%; margin: 0 auto; overflow: auto; clear:both; margin-top: 30px;">



            </div>


        </div>
    </div>
    <div style=" width: 100%; overflow: auto; clear:both; margin-top: 20px;">
        <div style="width: 20%; float: left; text-align: center;">
            {{-- <img src="{{asset('/uploads/qr-code.png')}}" style="width: 80px; height: 80px; margin-top: 20px;"> --}}
        </div>

        <div style="width: 80%; float: right;">
            {{-- <h4 style="font-size: 18px; text-align: center">The Sum of <span style="text-decoration: line-through; text-decoration-style: double;">N</span>{{number_format($payment->amount,2)}} was paid to {{$school->name}} in respect of {{$school['session']['name']}} Academic Session - {{$school->term}} Term Fee Collection Services via {{$payment['method']['completion']}} on {{$payment->created_at->format('l, jS \of F Y')}}.</h4> --}}
        </div>
    </div>

    <div style=" width: 100%; margin-top: -100px; clear: both;">

    </div>
    <div style="border:  2px solid black; width: 100%; clear: both; overflow: auto;">
        <p style="font-size: 14px; text-align: center;">SCHOOL FEES ARE NOT REFUNDABLE AFTER PAYMENT</p>
    </div>
    <div style=" width: 100%; margin-top: 20px;">
        <p style="font-size: 13px; text-align: center">Generated on {{date("l, jS \of F Y ")}} @ {{date("h:i A")}}</p>
    </div>

</div>
</body>
</html>

