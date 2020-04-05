import { IState } from './IState';
import { ISubtype } from './ISubtype';
import { IColor } from './IColor';
import { ISize } from './ISize';
import { ILabel } from './ILabel';

export interface IProduct {
  id?: number;
  hash_id?: string;
  name: string;
  name_english: string;
  fullname?: string;
  description?: string;
  description_english?: string;
  slug?: string;
  weight?: string;
  price_pen?: number;
  price_dolar?: number;
  price_pen_discount?: number;
  price_usd_discount?: number;
  discount_pen?: number;
  discount_usd?: number;
  begin_discount?: any;
  end_discount?: any;
  publish_date?: any;
  free_shipping?: boolean;
  is_showroom_sale?: boolean;
  is_salient?: boolean | null;
  is_soldout ?: boolean;
  is_deal_2x1 ?: boolean;
  route_preview?: string;
  edit_route?: string;
  shop_route?: string;
  subtypes?: ISubtype[];
  state?: IState;
  colors?: IColor[];
  sizes?: ISize[];
  photos?: any[];
  label?: ILabel;
  created_at_month_year?: string;
  first_photo_url?: string;
  // TODO: Deprecated
  preview_route?: string;
  price?: number;
}

export interface IProductCollection {
  data: IProduct[];
}
