@extends("emails.layout_emails")
@section("content")
<!-- products_2items -->
@foreach($wishlists->chunk(2) as $wishlistChunk)
<table role="presentation" class="email_table" width="100%" border="0" cellspacing="0" cellpadding="0" style="box-sizing: border-box;mso-table-lspace: 0pt;mso-table-rspace: 0pt;border-spacing: 0;width: 100%;min-width: 0 !important;">
  <tbody>
    <tr>
      <td class="email_body tc" style="box-sizing: border-box;mso-table-lspace: 0pt;mso-table-rspace: 0pt;vertical-align: top;line-height: 100%;padding-left: 8px;padding-right: 8px;background-color: #eceff1;text-align: center;font-size: 0 !important;">
        <!--[if (mso)|(IE)]><table role="presentation" width="640" border="0" cellspacing="0" cellpadding="0" align="center" style="vertical-align:top;width:640px;Margin:0 auto;"><tbody><tr><td style="line-height:0px;font-size:0px;mso-line-height-rule:exactly;"><![endif]-->
        <table role="presentation" class="content_section" width="100%" border="0" cellspacing="0" cellpadding="0" style="box-sizing: border-box;mso-table-lspace: 0pt;mso-table-rspace: 0pt;border-spacing: 0;width: 100%;max-width: 640px;margin: 0 auto;text-align: center;min-width: 0 !important;">
          <tbody>
            <tr>
              <td>
                @if(\LaravelLocalization::getCurrentLocale() === 'es')
                <img src="https://bipolar-peru.s3.amazonaws.com/assets/mails/pedido-recibido-esp.jpg" style="max-width: 100%" alt="Bipolar">
                @elseif(\LaravelLocalization::getCurrentLocale() === 'en')
                <img src="https://bipolar-peru.s3.amazonaws.com/assets/mails/pedido-recibido-eng.jpg" style="max-width: 100%" alt="Bipolar">
                @endif
              </td>
            </tr>
            <tr>
              <td class="content_cell content_b pbe tc" style="box-sizing: border-box;mso-table-lspace: 0pt;mso-table-rspace: 0pt;vertical-align: top;line-height: inherit;padding-left: 8px;padding-right: 8px;background-color: #ffffff;text-align: center;padding-bottom: 24px;font-size: 0 !important;">
                @foreach($wishlistChunk as $wishlist)
                <!--[if (mso)|(IE)]><table role="presentation" width="624" border="0" cellspacing="0" cellpadding="0" align="center" style="vertical-align:top;width:624px;Margin:0 auto;"><tbody><tr><td width="312" style="line-height:0px;font-size:0px;mso-line-height-rule:exactly;"><![endif]-->
                <div class="col_2" style="box-sizing: border-box;width: 100%;line-height: inherit;display: inline-block;vertical-align: top;max-width: 312px;min-width: 0 !important;font-size: 0 !important;">
                  <table role="presentation" class="column" width="100%" border="0" cellspacing="0" cellpadding="0" style="box-sizing: border-box;mso-table-lspace: 0pt;mso-table-rspace: 0pt;border-spacing: 0;width: 100%;min-width: 0 !important;">
                    <tbody>
                      <tr>
                        <td class="column_cell pte tc" style="box-sizing: border-box;mso-table-lspace: 0pt;mso-table-rspace: 0pt;vertical-align: top;padding-left: 8px;padding-right: 8px;font-family: Arial, Helvetica, sans-serif;font-size: 16px;color: #757575;text-align: center;padding-top: 32px;line-height: inherit;">
                          <p class="mb_xs imgr" style="font-family: Arial, Helvetica, sans-serif;font-size: 0;color: #757575;line-height: 100%;mso-line-height-rule: exactly;margin-top: 0;margin-bottom: 8px;width: 100%;height: auto;clear: both;"><img class="bra" role="img" src="{{ $wishlist->product->photos->first()->url }}" width="140" height="140" alt="image description" style="max-width: 140px;outline: none;border: 0;text-decoration: none;-ms-interpolation-mode: bicubic;clear: both;line-height: 100%;width: 100%;height: auto;font-size: 0;margin-left: auto;margin-right: auto;"></p>
                          <p class="mb_0" style="font-family: Arial, Helvetica, sans-serif;font-size: 16px;color: #757575;line-height: 23px;mso-line-height-rule: exactly;margin-top: 0;margin-bottom: 0;"><a href="#" style="line-height: inherit;text-decoration: none;color: #000000;"><span style="line-height: inherit;color: #000000;"><strong>{{ $wishlist->product->name }}</strong></span></a></p>
                          <p class="mb_0" style="font-family: Arial, Helvetica, sans-serif;font-size: 16px;color: #000000;line-height: 23px;mso-line-height-rule: exactly;margin-top: 0;margin-bottom: 0;">{{ $wishlist->product->price }}</p>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
                @endforeach
                <!--[if (mso)|(IE)]></td></tr></tbody></table><![endif]-->
              </td>
            </tr>
          </tbody>
        </table>
        <!--[if (mso)|(IE)]></td></tr></tbody></table><![endif]-->
      </td>
    </tr>
  </tbody>
</table>
@endforeach
<!-- total -->
<table role="presentation" class="email_table" width="100%" border="0" cellspacing="0" cellpadding="0" style="box-sizing: border-box;mso-table-lspace: 0pt;mso-table-rspace: 0pt;border-spacing: 0;width: 100%;min-width: 0 !important;">
  <tbody>
  <tr>
    <td class="email_body tc" style="box-sizing: border-box;mso-table-lspace: 0pt;mso-table-rspace: 0pt;vertical-align: top;line-height: 100%;padding-left: 8px;padding-right: 8px;background-color: #eceff1;text-align: center;font-size: 0 !important;">
      <!--[if (mso)|(IE)]><table role="presentation" width="640" border="0" cellspacing="0" cellpadding="0" align="center" style="vertical-align:top;width:640px;Margin:0 auto;"><tbody><tr><td style="line-height:0px;font-size:0px;mso-line-height-rule:exactly;"><![endif]-->
      <table role="presentation" class="content_section" width="100%" border="0" cellspacing="0" cellpadding="0" style="box-sizing: border-box;mso-table-lspace: 0pt;mso-table-rspace: 0pt;border-spacing: 0;width: 100%;max-width: 640px;margin: 0 auto;text-align: center;min-width: 0 !important;">
        <tbody>
        <tr>
          <td class="content_cell content_b py pr_0 pl_0 tr" style="box-sizing: border-box;mso-table-lspace: 0pt;mso-table-rspace: 0pt;vertical-align: top;line-height: inherit;padding-left: 0;padding-right: 0;background-color: #ffffff;text-align: right;padding-top: 16px;padding-bottom: 16px;font-size: 0 !important; border-bottom: 1px solid; border-color: #e6e9eb">
            <!--[if (mso)|(IE)]><table role="presentation" width="192" border="0" cellspacing="0" cellpadding="0" align="right" style="vertical-align:top;width:192px;Margin:0 0 0 auto;"><tbody><tr><td style="line-height:0px;font-size:0px;mso-line-height-rule:exactly;"><![endif]-->
            <div class="col_12" style="box-sizing: border-box;width: 100%;line-height: inherit;display: inline-block;vertical-align: top;max-width: 192px;min-width: 0 !important;font-size: 0 !important;">
              <table role="presentation" class="column" width="100%" border="0" cellspacing="0" cellpadding="0" style="box-sizing: border-box;mso-table-lspace: 0pt;mso-table-rspace: 0pt;border-spacing: 0;width: 100%;min-width: 0 !important;">
                <tbody>
                <tr>
                  <td class="column_cell px bb tr switch_tc" style="box-sizing: border-box;mso-table-lspace: 0pt;mso-table-rspace: 0pt;vertical-align: top;padding-left: 16px;padding-right: 16px;font-family: Arial, Helvetica, sans-serif;font-size: 16px;color: #f8beb6;text-align: right;border-bottom: 1px solid;border-color: #e6e9eb;line-height: inherit;">
                    <p class="mb" style="font-weight: 700;font-size: 16px;color: #f8beb6;line-height: 23px;mso-line-height-rule: exactly;margin-top: 0;margin-bottom: 16px;">
                      Subtotal {{ $cart->total_currency }}<br>
                    </p>
                  </td>
                </tr>
                <tr>
                  <td class="column_cell px tr switch_tc" style="box-sizing: border-box;mso-table-lspace: 0pt;mso-table-rspace: 0pt;vertical-align: top;padding-left: 16px;padding-right: 16px;font-family: Arial, Helvetica, sans-serif;font-size: 16px;color: #757575;text-align: right;line-height: inherit;">
                    <h3 class="mb" style="font-family: Arial, Helvetica, sans-serif;font-weight: bold;padding: 0;margin-left: 0;margin-right: 0;margin-top: 16px;margin-bottom: 16px;color: #4d4d4d;font-size: 18px;line-height: 23px;"><span class="tp" style="font-size: 25px; line-height: inherit; color: #000000">{{ $cart->total_currency }}</span></h3>
                  </td>
                </tr>
                </tbody>
              </table>
            </div>
            <!--[if (mso)|(IE)]></td></tr></tbody></table><![endif]-->
          </td>
        </tr>
        </tbody>
      </table>
      <!--[if (mso)|(IE)]></td></tr></tbody></table><![endif]-->
    </td>
  </tr>
  </tbody>
</table>
@endsection