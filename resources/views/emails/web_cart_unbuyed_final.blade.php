@extends("emails.layout_emails")
@section("content")
<?php /** @var \App\Models\Cart $cart */ ?>
<table role="presentation" class="email_table" width="100%" border="0" cellspacing="0" cellpadding="0" style="box-sizing: border-box;mso-table-lspace: 0pt;mso-table-rspace: 0pt;border-spacing: 0;width: 100%;min-width: 0 !important;">
  <tbody>
    <tr>
      <td class="email_body tc" style="box-sizing: border-box;mso-table-lspace: 0pt;mso-table-rspace: 0pt;vertical-align: top;line-height: 100%;padding-left: 8px;padding-right: 8px;background-color: #eceff1;text-align: center;font-size: 0 !important;">
        <!--[if (mso)|(IE)]><table role="presentation" width="640" border="0" cellspacing="0" cellpadding="0" align="center" style="vertical-align:top;width:640px;Margin:0 auto;"><tbody><tr><td style="line-height:0px;font-size:0px;mso-line-height-rule:exactly;"><![endif]-->
        <table role="presentation" class="content_section" width="100%" border="0" cellspacing="0" cellpadding="0" style="box-sizing: border-box;mso-table-lspace: 0pt;mso-table-rspace: 0pt;border-spacing: 0;width: 100%;max-width: 640px;margin: 0 auto;text-align: center;min-width: 0 !important;">
          <tbody>
            <tr>
              <td>
                <a href="{{ route('cart') }}">
                  @if($cart->user->language === 'es')
                    <img src="https://bipolar.nyc3.digitaloceanspaces.com/mails/cart-unbuyed-spa-new-1.png" style="max-width: 100%" alt="Bipolar">
                  @elseif($cart->user->language === 'en')
                    <img src="https://bipolar.nyc3.digitaloceanspaces.com/mails/cart-unbuyed-eng-new-1.png" style="max-width: 100%" alt="Bipolar">
                  @endif
                </a>
              </td>
            </tr>
            @foreach($cart->details->chunk(2) as $detailChunk)
            <tr>
              <td class="content_cell content_b pbe tc" style="box-sizing: border-box;mso-table-lspace: 0pt;mso-table-rspace: 0pt;vertical-align: top;line-height: inherit;padding-left: 8px;padding-right: 8px;background-color: #ffffff;text-align: center;padding-bottom: 24px;font-size: 0 !important;">
                @foreach($detailChunk as $detail)
                <?php /** @var \App\Models\CartDetail $detail */ ?>
                <!--[if (mso)|(IE)]><table role="presentation" width="624" border="0" cellspacing="0" cellpadding="0" align="center" style="vertical-align:top;width:624px;Margin:0 auto;"><tbody><tr><td width="312" style="line-height:0px;font-size:0px;mso-line-height-rule:exactly;"><![endif]-->
                <div class="col_2" style="box-sizing: border-box;width: 100%;line-height: inherit;display: inline-block;vertical-align: top;max-width: 312px;min-width: 0 !important;font-size: 0 !important;">
                  <table role="presentation" class="column" width="100%" border="0" cellspacing="0" cellpadding="0" style="box-sizing: border-box;mso-table-lspace: 0pt;mso-table-rspace: 0pt;border-spacing: 0;width: 100%;min-width: 0 !important;">
                    <tbody>
                      <tr>
                        @if($detail->product)
                          @if($detail->product->photos->count())
                            <td class="column_cell pte tc" style="box-sizing: border-box;mso-table-lspace: 0pt;mso-table-rspace: 0pt;vertical-align: top;padding-left: 8px;padding-right: 8px;font-family: 'Times New Roman', Times, serif;font-size: 16px;color: #757575;text-align: center;padding-top: 32px;line-height: inherit;">
                              <p class="mb_xs imgr" style="font-family: 'Times New Roman', Times, serif;font-size: 0;color: #757575;line-height: 100%;mso-line-height-rule: exactly;margin-top: 0;margin-bottom: 8px;width: 100%;height: auto;clear: both;"><img role="img" src="{{ $message->embed(optional($detail->product->mainPhoto())->url) }}" width="140" height="140" alt="image description" style="max-width: 280px;outline: none;border: 0;text-decoration: none;-ms-interpolation-mode: bicubic;clear: both;line-height: 100%;width: 100%;height: auto;font-size: 0;margin-left: auto;margin-right: auto;"></p>
                              <p class="mb_0" style="font-family: 'Times New Roman', Times, serif;font-size: 16px;color: #757575;line-height: 23px;mso-line-height-rule: exactly;margin-top: 0;margin-bottom: 0;"><a href="#" style="line-height: inherit;text-decoration: none;color: #000000;"><span style="line-height: inherit;color: #000000;"><strong>{{ $detail->product->name }}</strong></span></a></p>
                              <p class="mb_xs tm" style="font-family: 'Times New Roman', Times, serif;font-size: 16px;color: #000000;line-height: 23px;mso-line-height-rule: exactly;margin-top: 0;margin-bottom: 8px;">
                                {{ $detail->stock ? __('bipolar.size_abbr') . ". " . $detail->stock->size->name : null }}
                              </p>
                              <p class="mb_0" style="font-family: 'Times New Roman', Times, serif;font-size: 16px;color: #000000;line-height: 23px;mso-line-height-rule: exactly;margin-top: 0;margin-bottom: 0;">{{ $detail->total_currency }}</p>
                            </td>
                          @endif
                        @endif
                      </tr>
                    </tbody>
                  </table>
                </div>
                @endforeach
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
{{-- @include('emails.partials.faq') --}}
@include('emails.partials.cart_un_buyed_final')
@endsection