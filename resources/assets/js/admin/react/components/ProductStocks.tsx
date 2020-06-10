import React from 'react';
import ReactDOM from 'react-dom';
import axios from 'axios';
import StockRow from './StockRow';
import { FontAwesomeIcon } from '@fortawesome/react-fontawesome';
import { faCircleNotch } from '@fortawesome/free-solid-svg-icons';
import Select from 'react-select';
import AsyncSelect from 'react-select/async';
import { IStock } from '@interfaces/IStock';

interface ISelectOption {
  label: string;
  value: number;
}

interface Props {
  productHashId: string;
}

interface State {
  stocks: IStock[];
  stocksForSelect: ISelectOption[];
  stockSelected: ISelectOption;
  variantsSelected: ISelectOption[];
  loading: boolean;
  searchProduct: string;
  productId: number;
  productVariantsIds: string[];
  isVariantsDisabled: boolean;
  showSecondOption: boolean;
}

class BipolarProductStocks extends React.Component<Props, State> {
  state: State = {
    stocks: [],
    stocksForSelect: [],
    stockSelected: null,
    variantsSelected: [],
    loading: true,
    searchProduct: '',
    productId: 0,
    productVariantsIds: [],
    isVariantsDisabled: true,
    showSecondOption: false,
  };

  refetchStock = () => {
    return this.getStocksByProduct().then(response => {
      return this.setState({ stocks: response.data.data });
    });
  };

  getStocksByProduct = () => {
    return axios.get<{ data: IStock[] }>(`/ajax-admin/products/${this.props.productHashId}/stocks`);
  };

  toggleSearchEngine = () => this.setState({ showSecondOption: !this.state.showSecondOption });

  onSelectProduct = (element: ISelectOption) =>
    axios.get(`/ajax-admin/bsale/products/${element.value}/variants`).then(response => {
      this.setState({
        productId: element.value,
        productVariantsIds: response.data,
        isVariantsDisabled: false,
      });
    });

  onSelectVariant = (elements: ISelectOption[]) => this.setState({ variantsSelected: elements });

  onSelectStock = async (element: ISelectOption) => {
    const bsaleStockIds =
      this.state.stocks.find(stock => stock.id === element.value)?.bsale_stock_ids ?? [];
    const { data } = await this.getStockInfoFromBsale(bsaleStockIds);
    this.setState({ variantsSelected: data, stockSelected: element });
  };

  searchProducts = (text: string) =>
    axios.get(`/ajax-admin/bsale/products/search?text=${text}`).then(response => response.data);

  searchCrawlerProducts = (text: string) =>
    axios
      .get(`/ajax-admin/bsale/products-crawler/search?text=${text}`)
      .then(response => response.data);

  getStockInfoFromBsale = (bsaleStockIds: number[]) =>
    axios.get<ISelectOption[]>(`/ajax-admin/bsale/variants?variants=${bsaleStockIds.join(',')}`);

  saveStockData = async () => {
    const variantIds = this.state.variantsSelected?.map(stock => stock.value) ?? [];
    await axios
      .post(`/ajax-admin/stocks/${this.state.stockSelected.value}`, {
        bsaleStockIds: variantIds,
      })
      .then(() => this.refetchStock());
  };

  componentDidMount() {
    this.getStocksByProduct().then(responseStocks => {
      const stocksForSelect = responseStocks.data.data.map(stock => ({
        label: stock.size_name,
        value: stock.id,
      }));
      this.setState({
        stocks: responseStocks.data.data,
        stocksForSelect,
        loading: false,
      });
    });
  }

  render() {
    const stocks = this.state.stocks.length ? (
      this.state.stocks.map(stock => {
        return (
          <StockRow
            key={stock.bsale_stock_ids.toString()}
            stock={stock}
            bsaleStockIds={stock?.bsale_stock_ids ?? []}
            getStockFromBsale={this.getStockInfoFromBsale}
          />
        );
      })
    ) : (
      <tr>
        <td colSpan={3}>No hay stocks</td>
      </tr>
    );

    const StockSelector = (
      <Select
        options={this.state.stocksForSelect}
        onChange={this.onSelectStock}
        value={this.state.stockSelected}
        placeholder="Talla"
      />
    );

    const UpdateButton = (
      <button
        onClick={this.saveStockData}
        className="btn btn-dark"
        disabled={this.state.stockSelected === null}>
        Actualizar
      </button>
    );

    const SearchEngineCrawler = (
      <div className="row mb-3">
        <div className="col-7">
          <div className="row">
            <div className="col-3">{StockSelector}</div>
            <div className="col-9">
              <AsyncSelect
                isMulti={true}
                loadOptions={this.searchCrawlerProducts}
                value={this.state.variantsSelected}
                placeholder="Buscar producto"
                onChange={this.onSelectVariant}
                isDisabled={this.state.stockSelected === null}
              />
            </div>
          </div>
        </div>
        <div className="col-2 d-flex">{UpdateButton}</div>
        <div className="col-3 d-flex justify-content-end">
          <button onClick={this.toggleSearchEngine} className="btn btn-outline-info">
            ¿Buscador no funciona?
          </button>
        </div>
      </div>
    );

    const SearchEngineAPI = (
      <div className="row mb-3">
        <div className="col-2">{StockSelector}</div>
        <div className="col-4">
          <AsyncSelect
            isMulti={false}
            loadOptions={this.searchProducts}
            onChange={this.onSelectProduct}
          />
        </div>
        <div className="col-4">
          <Select
            isMulti={true}
            options={this.state.productVariantsIds}
            value={this.state.variantsSelected}
            onChange={this.onSelectVariant}
            isDisabled={this.state.isVariantsDisabled}
          />
        </div>
        <div className="col-2">
          <div className="col-2 d-flex">{UpdateButton}</div>
        </div>
      </div>
    );

    return (
      <div>
        {SearchEngineCrawler}
        {this.state.showSecondOption ? SearchEngineAPI : null}
        {this.state.loading ? (
          <div className="text-center">
            <FontAwesomeIcon icon={faCircleNotch} spin /> Cargando contenido...{' '}
            <FontAwesomeIcon icon={faCircleNotch} spin />
          </div>
        ) : (
          <table className="table">
            <thead>
              <tr>
                <th className="text-center">Talla</th>
                <th className="text-center">Cantidad</th>
                <th>Producto en Bsale</th>
              </tr>
            </thead>
            <tbody>{stocks}</tbody>
          </table>
        )}
      </div>
    );
  }
}

if (document.getElementById('bipolar-product-stocks')) {
  const ProductHashId = (window as any).BipolarProductId;
  ReactDOM.render(
    <BipolarProductStocks productHashId={ProductHashId} />,
    document.getElementById('bipolar-product-stocks')
  );
}
