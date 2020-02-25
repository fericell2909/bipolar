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
  price?: number;
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
  is_salient?: any;
  preview_route?: string;
  edit_route?: string;
  shop_route?: string;
  subtypes?: Subtype[];
  state?: State;
  colors?: Color[];
  sizes?: Size[];
  created_at_month_year?: string;
}

export interface IProductCollection {
  data: IProduct[];
}

export interface Subtype {
  id: number;
  hash_id: string;
  name: string;
  slug: string;
}

export interface State {
  hash_id: string;
  name: string;
  color: string;
  html: string;
}

export interface Color {
  hash_id: string;
  name: string;
}

export interface Size {
  hash_id: string;
  name: string;
}
