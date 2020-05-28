export interface IStock {
  id: number;
  product_id: number;
  size_id?: number;
  bsale_stock_ids?: number[];
  quantity: number;
  size_name?: string;
}
