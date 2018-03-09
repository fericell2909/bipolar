@extends("emails.layout_emails")
@section("content")
<!-- hero_alt_welcome -->
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
                <img src="https://bipolar-peru.s3.amazonaws.com/assets/mails/pedido-enviado-esp.jpg" style="max-width: 100%" alt="Bipolar">
                @elseif(\LaravelLocalization::getCurrentLocale() === 'en')
                <img src="https://bipolar-peru.s3.amazonaws.com/assets/mails/pedido-enviado-eng.jpg" style="max-width: 100%" alt="Bipolar">
                @endif
              </td>
            </tr>
            <tr>
              <td class="content_cell content_b py tc" style="box-sizing: border-box;mso-table-lspace: 0pt;mso-table-rspace: 0pt;vertical-align: top;line-height: inherit;padding-left: 8px;padding-right: 8px;background-color: #ffffff;text-align: center;padding-top: 16px;padding-bottom: 16px;font-size: 0 !important;">
                <table role="presentation" class="column" width="100%" border="0" cellspacing="0" cellpadding="0" style="box-sizing: border-box;mso-table-lspace: 0pt;mso-table-rspace: 0pt;border-spacing: 0;width: 100%;min-width: 0 !important;">
                  <tbody>
                    <tr>
                      <td class="column_cell pt tc" style="box-sizing: border-box;mso-table-lspace: 0pt;mso-table-rspace: 0pt;vertical-align: top;padding-left: 8px;padding-right: 8px;font-family: Arial, Helvetica, sans-serif;font-size: 16px;color: #757575;text-align: center;padding-top: 16px;line-height: inherit;">
                        <h1 style="font-family: Arial, Helvetica, sans-serif;font-weight: bold;padding: 0;margin-left: 0;margin-right: 0;margin-top: 16px;margin-bottom: 8px;color: #4d4d4d;font-size: 26px;line-height: 34px;">
                          GRACIAS {{ strtoupper($name) }} <br> POR SUSCRIBIRTE A NUESTRO NEWSLETTER
                        </h1>
                      </td>
                    </tr>
                  </tbody>
                </table>
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