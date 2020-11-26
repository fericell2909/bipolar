import { IProduct } from '@interfaces/IProduct';

export interface IPremiumLink {
  hash_id: string;
  name: string;
  end: string;
  products: number[];
  available: boolean;
  // GraphQL fields only
  products_model?: IProduct[];
  edit_route?: string;
  preview_route?: string;
  uuid?: string;
}