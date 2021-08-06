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
                <img src="https://bipolar.nyc3.digitaloceanspaces.com/mails/suscription_esp_two_new.png" style="max-width: 100%" alt="Bipolar Mail">
                @elseif(\LaravelLocalization::getCurrentLocale() === 'en')
                <img src="https://bipolar.nyc3.digitaloceanspaces.com/mails/suscription_eng_new.png" style="max-width: 100%" alt="Bipolar Mail">
                @endif
              </td>
            </tr>
          </tbody>
        </table>
        <!--[if (mso)|(IE)]></td></tr></tbody></table><![endif]-->
      </td>
    </tr>
  </tbody>
</table>
@push('plus_text')
<!-- hero_alt_welcome -->
<table role="presentation" class="email_table" width="100%" border="0" cellspacing="0" cellpadding="0" style="box-sizing: border-box;mso-table-lspace: 0pt;mso-table-rspace: 0pt;border-spacing: 0;width: 100%;min-width: 0 !important;">
  <tbody>
    <tr>
      <td class="email_body tc" style="box-sizing: border-box;mso-table-lspace: 0pt;mso-table-rspace: 0pt;vertical-align: top;line-height: 100%;padding-left: 8px;padding-right: 8px;background-color: #eceff1;text-align: center;font-size: 0 !important;">
        <!--[if (mso)|(IE)]><table role="presentation" width="640" border="0" cellspacing="0" cellpadding="0" align="center" style="vertical-align:top;width:640px;Margin:0 auto;"><tbody><tr><td style="line-height:0px;font-size:0px;mso-line-height-rule:exactly;"><![endif]-->
        <table role="presentation" class="content_section" width="100%" border="0" cellspacing="0" cellpadding="0" style="box-sizing: border-box;mso-table-lspace: 0pt;mso-table-rspace: 0pt;border-spacing: 0;width: 100%;max-width: 640px;margin: 0 auto;text-align: center;min-width: 0 !important;">
          <tbody>
            <tr>
              <td class="content_cell content_b tc" style="box-sizing: border-box;mso-table-lspace: 0pt;mso-table-rspace: 0pt;vertical-align: top;line-height: inherit;padding-left: 8px;padding-right: 8px;background-color: #ffffff;text-align: center;font-size: 0 !important;">
                <table role="presentation" class="column" width="100%" border="0" cellspacing="0" cellpadding="0" style="box-sizing: border-box;mso-table-lspace: 0pt;mso-table-rspace: 0pt;border-spacing: 0;width: 100%;min-width: 0 !important;">
                  <tbody>
                    <tr>
                      <td class="column_cell tc" style="box-sizing: border-box;mso-table-lspace: 0pt;mso-table-rspace: 0pt;vertical-align: top;padding-left: 8px;padding-right: 8px;font-family: Arial, Helvetica, sans-serif;font-size: 16px;color: #757575;text-align: center;line-height: inherit;">
                        <h5 style="font-family: Arial, Helvetica, sans-serif;font-weight: bold;padding: 0;margin-left: 0;margin-right: 0;margin-top: 16px;margin-bottom: 8px;color: #4d4d4d;font-size: 11px;line-height: 30px;">{{ __('bipolar.mails.unsuscribe_newsletter') }} <a href="https://bipolar.us12.list-manage.com/unsubscribe?u=d616f5c8cc9cff44a6ae9337a&id=914e120268">{{ __('bipolar.mails.here') }}</a>.</h5>
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
@endpush
{{-- @include('emails.partials.faq') --}}
@include('emails.partials.notification_newsletter')
@endsection