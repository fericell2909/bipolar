@extends("emails.layout_emails")
@section("content")
<!-- product_extended -->
<table role="presentation" class="email_table" width="100%" border="0" cellspacing="0" cellpadding="0" style="box-sizing: border-box;mso-table-lspace: 0pt;mso-table-rspace: 0pt;border-spacing: 0;width: 100%;min-width: 0 !important;">
  <tbody>
  <tr>
    <td class="email_body tc" style="box-sizing: border-box;mso-table-lspace: 0pt;mso-table-rspace: 0pt;vertical-align: top;line-height: 100%;padding-left: 8px;padding-right: 8px;background-color: #eceff1;text-align: center;font-size: 0 !important;">
      <!--[if (mso)|(IE)]><table role="presentation" width="640" border="0" cellspacing="0" cellpadding="0" align="center" style="vertical-align:top;width:640px;Margin:0 auto;"><tbody><tr><td style="line-height:0px;font-size:0px;mso-line-height-rule:exactly;"><![endif]-->
      <table role="presentation" class="content_section" width="100%" border="0" cellspacing="0" cellpadding="0" style="box-sizing: border-box;mso-table-lspace: 0pt;mso-table-rspace: 0pt;border-spacing: 0;width: 100%;max-width: 640px;margin: 0 auto;text-align: center;min-width: 0 !important;">
        <tbody>
        @foreach($buy->details as $detail)
          <tr>
            <td class="content_cell content_b py bb tc" style="box-sizing: border-box;mso-table-lspace: 0pt;mso-table-rspace: 0pt;vertical-align: top;line-height: inherit;padding-left: 8px;padding-right: 8px;background-color: #ffffff;text-align: center;padding-top: 16px;padding-bottom: 16px;border-bottom: 1px solid;border-color: #e6e9eb;font-size: 0 !important;">
              <!--[if (mso)|(IE)]><table role="presentation" width="624" border="0" cellspacing="0" cellpadding="0" align="center" style="vertical-align:top;width:624px;Margin:0 auto;"><tbody><tr><td width="156" style="line-height:0px;font-size:0px;mso-line-height-rule:exactly;"><![endif]-->
              <div class="col_1" style="box-sizing: border-box;width: 100%;line-height: inherit;display: inline-block;vertical-align: top;max-width: 156px;min-width: 0 !important;font-size: 0 !important;">
                <table role="presentation" class="column" width="100%" border="0" cellspacing="0" cellpadding="0" style="box-sizing: border-box;mso-table-lspace: 0pt;mso-table-rspace: 0pt;border-spacing: 0;width: 100%;min-width: 0 !important;">
                  <tbody>
                  <tr>
                    <td class="column_cell tc" style="box-sizing: border-box;mso-table-lspace: 0pt;mso-table-rspace: 0pt;vertical-align: top;padding-left: 8px;padding-right: 8px;font-family: Arial, Helvetica, sans-serif;font-size: 16px;color: #757575;text-align: center;line-height: inherit;">
                      <p class="mb_0 imgr" style="font-family: Arial, Helvetica, sans-serif;font-size: 0;color: #757575;line-height: 100%;mso-line-height-rule: exactly;margin-top: 0;margin-bottom: 0;width: 100%;height: auto;clear: both;"><img class="bra" role="img" src="{{ $detail->product->photos->first()->url }}" width="140" height="140" alt="image description" style="max-width: 140px;outline: none;border: 0;text-decoration: none;-ms-interpolation-mode: bicubic;clear: both;line-height: 100%;border-radius: 4px;width: 100%;height: auto;font-size: 0;margin-left: auto;margin-right: auto;"></p>
                    </td>
                  </tr>
                  </tbody>
                </table>
              </div>
              <!--[if (mso)|(IE)]></td><td width="484" style="line-height:0px;font-size:0px;mso-line-height-rule:exactly;"><![endif]-->
              <div class="col_2" style="box-sizing: border-box;width: 100%;line-height: inherit;display: inline-block;vertical-align: top;max-width: 312px;min-width: 0 !important;font-size: 0 !important;">
                <table role="presentation" class="column" width="100%" border="0" cellspacing="0" cellpadding="0" style="box-sizing: border-box;mso-table-lspace: 0pt;mso-table-rspace: 0pt;border-spacing: 0;width: 100%;min-width: 0 !important;">
                  <tbody>
                  <tr>
                    <td class="column_cell tl switch_tc" style="box-sizing: border-box;mso-table-lspace: 0pt;mso-table-rspace: 0pt;vertical-align: top;padding-left: 8px;padding-right: 8px;font-family: Arial, Helvetica, sans-serif;font-size: 16px;color: #757575;text-align: left;line-height: inherit;">
                      <h3 style="font-family: Arial, Helvetica, sans-serif;font-weight: bold;padding: 0;margin-left: 0;margin-right: 0;margin-top: 16px;margin-bottom: 8px;color: #4d4d4d;font-size: 18px;line-height: 23px;">{{ $detail->product->name }} <span class="tm" style="line-height: inherit;color: #b3b3b3;">× {{ $detail->quantity }}</span></h3>
                    </td>
                  </tr>
                  </tbody>
                </table>
              </div>
              <!--[if (mso)|(IE)]></td><td width="484" style="line-height:0px;font-size:0px;mso-line-height-rule:exactly;"><![endif]-->
              <div class="col_1" style="box-sizing: border-box;width: 100%;line-height: inherit;display: inline-block;vertical-align: top;max-width: 156px;min-width: 0 !important;font-size: 0 !important;">
                <table role="presentation" class="column" width="100%" border="0" cellspacing="0" cellpadding="0" style="box-sizing: border-box;mso-table-lspace: 0pt;mso-table-rspace: 0pt;border-spacing: 0;width: 100%;min-width: 0 !important;">
                  <tbody>
                  <tr>
                    <td class="column_cell py tr switch_tc" style="box-sizing: border-box;mso-table-lspace: 0pt;mso-table-rspace: 0pt;vertical-align: top;padding-left: 8px;padding-right: 8px;font-family: Arial, Helvetica, sans-serif;font-size: 16px;color: #757575;text-align: right;padding-top: 16px;padding-bottom: 16px;line-height: inherit;">
                      <p class="mb_0 tp" style="font-family: Arial, Helvetica, sans-serif;font-size: 16px;color: #388cda;line-height: 23px;mso-line-height-rule: exactly;margin-top: 0;margin-bottom: 0;">{{ $detail->total_currency }} {{ Session::get('BIPOLAR_CURRENCY', 'USD') }}</p>
                    </td>
                  </tr>
                  </tbody>
                </table>
              </div>
              <!--[if (mso)|(IE)]></td></tr></tbody></table><![endif]-->
            </td>
          </tr>
        @endforeach
        </tbody>
      </table>
      <!--[if (mso)|(IE)]></td></tr></tbody></table><![endif]-->
    </td>
  </tr>
  </tbody>
</table>
<!-- total -->
<table role="presentation" class="email_table" width="100%" border="0" cellspacing="0" cellpadding="0" style="box-sizing: border-box;mso-table-lspace: 0pt;mso-table-rspace: 0pt;border-spacing: 0;width: 100%;min-width: 0 !important;">
  <tbody>
  <tr>
    <td class="email_body tc" style="box-sizing: border-box;mso-table-lspace: 0pt;mso-table-rspace: 0pt;vertical-align: top;line-height: 100%;padding-left: 8px;padding-right: 8px;background-color: #eceff1;text-align: center;font-size: 0 !important;">
      <!--[if (mso)|(IE)]><table role="presentation" width="640" border="0" cellspacing="0" cellpadding="0" align="center" style="vertical-align:top;width:640px;Margin:0 auto;"><tbody><tr><td style="line-height:0px;font-size:0px;mso-line-height-rule:exactly;"><![endif]-->
      <table role="presentation" class="content_section" width="100%" border="0" cellspacing="0" cellpadding="0" style="box-sizing: border-box;mso-table-lspace: 0pt;mso-table-rspace: 0pt;border-spacing: 0;width: 100%;max-width: 640px;margin: 0 auto;text-align: center;min-width: 0 !important;">
        <tbody>
        <tr>
          <td class="content_cell content_b py pr_0 pl_0 tr" style="box-sizing: border-box;mso-table-lspace: 0pt;mso-table-rspace: 0pt;vertical-align: top;line-height: inherit;padding-left: 0;padding-right: 0;background-color: #ffffff;text-align: right;padding-top: 16px;padding-bottom: 16px;font-size: 0 !important;">
            <!--[if (mso)|(IE)]><table role="presentation" width="192" border="0" cellspacing="0" cellpadding="0" align="right" style="vertical-align:top;width:192px;Margin:0 0 0 auto;"><tbody><tr><td style="line-height:0px;font-size:0px;mso-line-height-rule:exactly;"><![endif]-->
            <div class="col_12" style="box-sizing: border-box;width: 100%;line-height: inherit;display: inline-block;vertical-align: top;max-width: 192px;min-width: 0 !important;font-size: 0 !important;">
              <table role="presentation" class="column" width="100%" border="0" cellspacing="0" cellpadding="0" style="box-sizing: border-box;mso-table-lspace: 0pt;mso-table-rspace: 0pt;border-spacing: 0;width: 100%;min-width: 0 !important;">
                <tbody>
                <tr>
                  <td class="column_cell px bb tr switch_tc" style="box-sizing: border-box;mso-table-lspace: 0pt;mso-table-rspace: 0pt;vertical-align: top;padding-left: 16px;padding-right: 16px;font-family: Arial, Helvetica, sans-serif;font-size: 16px;color: #757575;text-align: right;border-bottom: 1px solid;border-color: #e6e9eb;line-height: inherit;">
                    <p class="mb" style="font-family: Arial, Helvetica, sans-serif;font-size: 16px;color: #757575;line-height: 23px;mso-line-height-rule: exactly;margin-top: 0;margin-bottom: 16px;">
                      Subtotal {{ $buy->total_currency }}<br>
                      Shipping $20
                    </p>
                  </td>
                </tr>
                <tr>
                  <td class="column_cell px tr switch_tc" style="box-sizing: border-box;mso-table-lspace: 0pt;mso-table-rspace: 0pt;vertical-align: top;padding-left: 16px;padding-right: 16px;font-family: Arial, Helvetica, sans-serif;font-size: 16px;color: #757575;text-align: right;line-height: inherit;">
                    <h3 class="mb" style="font-family: Arial, Helvetica, sans-serif;font-weight: bold;padding: 0;margin-left: 0;margin-right: 0;margin-top: 16px;margin-bottom: 16px;color: #4d4d4d;font-size: 18px;line-height: 23px;">Total <span class="tp" style="line-height: inherit;color: #388cda;">{{ $buy->total_currency }} {{ Session::get('BIPOLAR_CURRENCY') }}</span></h3>
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
<!-- address -->
<table role="presentation" class="email_table" width="100%" border="0" cellspacing="0" cellpadding="0" style="box-sizing: border-box;mso-table-lspace: 0pt;mso-table-rspace: 0pt;border-spacing: 0;width: 100%;min-width: 0 !important;">
  <tbody>
  <tr>
    <td class="email_body tc" style="box-sizing: border-box;mso-table-lspace: 0pt;mso-table-rspace: 0pt;vertical-align: top;line-height: 100%;padding-left: 8px;padding-right: 8px;background-color: #eceff1;text-align: center;font-size: 0 !important;">
      <!--[if (mso)|(IE)]><table role="presentation" width="640" border="0" cellspacing="0" cellpadding="0" align="center" style="vertical-align:top;width:640px;Margin:0 auto;"><tbody><tr><td style="line-height:0px;font-size:0px;mso-line-height-rule:exactly;"><![endif]-->
      <table role="presentation" class="content_section" width="100%" border="0" cellspacing="0" cellpadding="0" style="box-sizing: border-box;mso-table-lspace: 0pt;mso-table-rspace: 0pt;border-spacing: 0;width: 100%;max-width: 640px;margin: 0 auto;text-align: center;min-width: 0 !important;">
        <tbody>
        <tr>
          <td class="content_cell content_b pbe tc" style="box-sizing: border-box;mso-table-lspace: 0pt;mso-table-rspace: 0pt;vertical-align: top;line-height: inherit;padding-left: 8px;padding-right: 8px;background-color: #ffffff;text-align: center;padding-bottom: 24px;font-size: 0 !important;">
            <!--[if (mso)|(IE)]><table role="presentation" width="624" border="0" cellspacing="0" cellpadding="0" align="center" style="vertical-align:top;width:624px;Margin:0 auto;"><tbody><tr><td width="312" style="line-height:0px;font-size:0px;mso-line-height-rule:exactly;"><![endif]-->
            <div class="col_2" style="box-sizing: border-box;width: 100%;line-height: inherit;display: inline-block;vertical-align: top;max-width: 312px;min-width: 0 !important;font-size: 0 !important;">
              <table role="presentation" class="column" width="100%" border="0" cellspacing="0" cellpadding="0" style="box-sizing: border-box;mso-table-lspace: 0pt;mso-table-rspace: 0pt;border-spacing: 0;width: 100%;min-width: 0 !important;">
                <tbody>
                <tr>
                  <td class="column_cell tc" style="box-sizing: border-box;mso-table-lspace: 0pt;mso-table-rspace: 0pt;vertical-align: top;padding-left: 8px;padding-right: 8px;font-family: Arial, Helvetica, sans-serif;font-size: 16px;color: #757575;text-align: center;line-height: inherit;">
                    <h4 class="mte" style="font-family: Arial, Helvetica, sans-serif;font-weight: bold;padding: 0;margin-left: 0;margin-right: 0;margin-top: 32px;margin-bottom: 8px;color: #4d4d4d;font-size: 14px;line-height: 18px;">Shipping address</h4>
                    <p style="font-family: Arial, Helvetica, sans-serif;font-size: 16px;color: #757575;line-height: 23px;mso-line-height-rule: exactly;margin-top: 0;margin-bottom: 24px;">
                      @if($buy->billing_address)
                        {{ $buy->billing_address->name }} {{ $buy->billing_address->lastname }}<br>
                        {{ $buy->billing_address->address }} <br>
                        {{ $buy->billing_address->country_state->name }} <br>
                        {{ $buy->billing_address->zip }} <br>
                        {{ $buy->billing_address->country_state->country->name }}
                      @endif
                    </p>
                    <h4 class="mte" style="font-family: Arial, Helvetica, sans-serif;font-weight: bold;padding: 0;margin-left: 0;margin-right: 0;margin-top: 32px;margin-bottom: 8px;color: #4d4d4d;font-size: 14px;line-height: 18px;">Shipping method</h4>
                    <p class="mb_0" style="font-family: Arial, Helvetica, sans-serif;font-size: 16px;color: #757575;line-height: 23px;mso-line-height-rule: exactly;margin-top: 0;margin-bottom: 0;">Generic Shipping</p>
                  </td>
                </tr>
                </tbody>
              </table>
            </div>
            <!--[if (mso)|(IE)]></td><td width="312" style="line-height:0px;font-size:0px;mso-line-height-rule:exactly;"><![endif]-->
            <div class="col_2" style="box-sizing: border-box;width: 100%;line-height: inherit;display: inline-block;vertical-align: top;max-width: 312px;min-width: 0 !important;font-size: 0 !important;">
              <table role="presentation" class="column" width="100%" border="0" cellspacing="0" cellpadding="0" style="box-sizing: border-box;mso-table-lspace: 0pt;mso-table-rspace: 0pt;border-spacing: 0;width: 100%;min-width: 0 !important;">
                <tbody>
                <tr>
                  <td class="column_cell tc" style="box-sizing: border-box;mso-table-lspace: 0pt;mso-table-rspace: 0pt;vertical-align: top;padding-left: 8px;padding-right: 8px;font-family: Arial, Helvetica, sans-serif;font-size: 16px;color: #757575;text-align: center;line-height: inherit;">
                    <h4 class="mte" style="font-family: Arial, Helvetica, sans-serif;font-weight: bold;padding: 0;margin-left: 0;margin-right: 0;margin-top: 32px;margin-bottom: 8px;color: #4d4d4d;font-size: 14px;line-height: 18px;">Billing address</h4>
                    <p style="font-family: Arial, Helvetica, sans-serif;font-size: 16px;color: #757575;line-height: 23px;mso-line-height-rule: exactly;margin-top: 0;margin-bottom: 24px;">
                      @if($buy->shipping_address)
                        {{ $buy->shipping_address->name }} {{ $buy->shipping_address->lastname }}<br>
                        {{ $buy->shipping_address->address }} <br>
                        {{ $buy->shipping_address->country_state->name }} <br>
                        {{ $buy->shipping_address->zip }} <br>
                        {{ $buy->shipping_address->country_state->country->name }}
                      @endif
                    </p>
                    <h4 class="mte" style="font-family: Arial, Helvetica, sans-serif;font-weight: bold;padding: 0;margin-left: 0;margin-right: 0;margin-top: 32px;margin-bottom: 8px;color: #4d4d4d;font-size: 14px;line-height: 18px;">Buy #ID</h4>
                    <p class="mb_0" style="font-family: Arial, Helvetica, sans-serif;font-size: 16px;color: #757575;line-height: 23px;mso-line-height-rule: exactly;margin-top: 0;margin-bottom: 0;">{{ $buy->id }}</p>
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