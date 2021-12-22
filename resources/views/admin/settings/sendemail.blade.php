<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml" xmlns:o="urn:schemas-microsoft-com:office:office">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <meta name="x-apple-disable-message-reformatting">
  <title></title>
  <!--[if mso]>
  <noscript>
    <xml>
      <o:OfficeDocumentSettings>
        <o:PixelsPerInch>96</o:PixelsPerInch>
      </o:OfficeDocumentSettings>
    </xml>
  </noscript>
  <![endif]-->
  <style>
    table, td, div, h1, p {font-family: Arial, sans-serif;}
    p {
      font-size:14px;
    }

    .msg-1655005966335219611 table, .msg-1655005966335219611 td, .msg-1655005966335219611 div, .msg-1655005966335219611 h1, .msg-1655005966335219611 p {
      font-size: 15px !important;
    line-height: 18px !important; 
    }
  </style>
</head>
@php
                                            $date = explode(" ",$order->created_at);
                                        @endphp
<body style="margin:0;padding:0;">
  <table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;background:#ffffff;">
    <tr>
        <td align="center" style="">
                <table role="presentation" style="width:840px;border-collapse:collapse;border:0;border-spacing:0;">
                      <tr style="backround: #ec607f;">
                        <td style="width:260px;vertical-align:top;color:#153643;">
                          <!-- <p style="margin:0 0 25px 0;font-size:16px;line-height:24px;font-family:Arial,sans-serif;"><img src="https://assets.codepen.io/210284/left.gif" alt="" width="260" style="height:auto;display:block;" /></p> -->
                            @if(isset($header))
                            @php
                                
                            $head = str_replace("{suplier_name}",$supplier->first_name,$supplier->header);
                                $head = str_replace("{mobile_number}",$supplier->mobilenumber,$head);
                                $head = str_replace("{address}",$supplier->address,$head);
                                $head = str_replace("{email}",$supplier->email,$head);
                                $head = str_replace("{total}",$order->total,$head);
                                $head = str_replace("{customer_name}",$order->user_name,$head);
                                $head = str_replace("{order_number}",$order->order_number,$head);
                                $head = str_replace("{customer_city}",$customer->city,$head);
                                $head = str_replace("{delivery_date}","",$head);

                            @endphp
                            <p style="margin:0 0 12px 0;font-size:16px;line-height:24px;font-family:Arial,sans-serif;">{!! html_entity_decode($head) !!}</p>
                            @endif
                        </td>
                      </tr>
                </table>
            
        </td>
    </tr>
    <tr>
      <td align="center" style="margin-top:10px">
        <table role="presentation" style="width:840px;border-collapse:collapse;border-spacing:0;text-align:left;">
         
          <tr>
            <td style="">
              <table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;">
                <!-- <tr>
                  <td style="padding:0 0 36px 0;color:#153643;">
                    <h1 style="font-size:24px;margin:0 0 20px 0;font-family:Arial,sans-serif;">Creating Email Magic</h1>
                    <p style="margin:0 0 12px 0;font-size:16px;line-height:24px;font-family:Arial,sans-serif;">Lorem ipsum dolor sit amet, consectetur adipiscing elit. In tempus adipiscing felis, sit amet blandit ipsum volutpat sed. Morbi porttitor, eget accumsan et dictum, nisi libero ultricies ipsum, posuere neque at erat.</p>
                    <p style="margin:0;font-size:16px;line-height:24px;font-family:Arial,sans-serif;"><a href="http://www.example.com" style="color:#ee4c50;text-decoration:underline;">In tempus felis blandit</a></p>
                  </td>
                </tr> -->
                <tr>
                  <td style="padding:0;">
                   



                    <table role="presentation" style="margin-top: 23px;width:100%;border-collapse:collapse;border:0;border-spacing:0;">
                      <tr>
                        <th scope="col" style="width:50px">#</th>
                        <th scope="col">Product Name</th>
                        <th scope="col">Unit</th>
                        <th scope="col">Price (€)</th>
                        <th scope="col">Required Quantity</th>
                        <th scope="col">Minimum Quantity</th>
                      </tr>
                      @php $k = 0; @endphp
                                                            
                        @foreach($order->products as $product)
                    
                        <tr>
                            <td scope="row">{{ $loop->index+1 }}</td>
                            <td scope="row">{{ $product->pivot->product_name }}</td>
                            <td scope="row">{{ $product->pivot->unit_name }}</td>
                            <td scope="row">{{ $product->pivot->unit_price }} €</td>
                            <td scope="row">{{ $product->pivot->quantity }}</td>
                            <td scope="row">{{ $product->pivot->min_quantity}}</td>
                        </tr>
                        @php $k++; @endphp

                        @endforeach
                    </table>
                  </td>
                </tr>
              </table>
            </td>
          </tr>
          <tr>
                    <div class="form-group" style="margin-top:30px;font-size:14px;">
                        Expected Delivery date for your order is <b>{{$order->delivery_date}}</b>
                    </div>
          </tr>
          <tr>
            <td style="margin-top:10px">
              <table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;font-size:9px;font-family:Arial,sans-serif;">
                <tr>
                  <td style="padding:0;width:50%;" align="left">
                    <p style="margin:0;font-size:20px;line-height:16px;font-family:Arial,sans-serif;color:#ffffff;">
                      {!! html_entity_decode($footer) !!}<br>
                      <p>&reg; Royal Donuts 2021</p><br/>
                    </p>
                  </td>
                  
                </tr>
              </table>
            </td>
          </tr>
        </table>
      </td>
    </tr>
  </table>
</body>
</html>