import { IProduct } from '@interfaces/IProduct';
import { ISubtype } from '@interfaces/ISubtype';
import { IType } from '@interfaces/IType';

export interface IDiscountTask {
  hash_id: string;
  name: string;
  discount_pen?: string;
  discount_usd?: string;
  begin: string;
  end: string;
  products: number[];
  is_2x1: boolean;
  available: boolean;
  executed: boolean;
  // GraphQL fields only
  products_model?: IProduct[];
  subtypes_model?: ISubtype[];
  types_model?: IType[];
  edit_route?: string;
}
