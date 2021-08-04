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
              {{-- <tr>
                <td>
                  @if(\LaravelLocalization::getCurrentLocale() === 'es')
                    <img src="{{ bipolar_mail_asset_url('storage/bipolar-images/assets/mails/pedido-enviado-esp.jpg', $message) }}" style="max-width: 100%" alt="Bipolar">
                    @elseif(\LaravelLocalization::getCurrentLocale() === 'en')
                    <img src="{{ bipolar_mail_asset_url('storage/bipolar-images/assets/mails/pedido-enviado-eng.jpg', $message) }}" style="max-width: 100%" alt="Bipolar">
                  @endif
                </td>
              </tr> --}}
              <tr>
                <td>
                  <a href="{{ route('confirmation', $buy->id) }}">
                    @if(\LaravelLocalization::getCurrentLocale() === 'es')
                      <img src="https://bipolar.nyc3.digitaloceanspaces.com/images/emails/pedido-en-camino-SPA.png" style="max-width: 100%" alt="Bipolar">
                      @elseif(\LaravelLocalization::getCurrentLocale() === 'en')
                      <img src="https://bipolar.nyc3.digitaloceanspaces.com/images/emails/pedido-en-camino-ING.png" style="max-width: 100%" alt="Bipolar">
                    @endif
                  </a>
                </td>
              </tr>
          </tbody>
        </table>
        <!--[if (mso)|(IE)]></td></tr></tbody></table><![endif]-->
      </td>
    </tr>
  </tbody>
</table>
@include('emails.partials.buy_sent')
@endsection