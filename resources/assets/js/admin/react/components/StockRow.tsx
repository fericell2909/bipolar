import React from 'react';
import { AxiosResponse } from 'axios';
import { IStock } from '@interfaces/IStock';
import Select from 'react-select';
import { faCircleNotch } from '@fortawesome/free-solid-svg-icons';
import { FontAwesomeIcon } from '@fortawesome/react-fontawesome';

interface Props {
  stock: IStock;
  bsaleStockIds: number[];
  getStockFromBsale: (bsaleStockIds: number[]) => Promise<AxiosResponse>;
}

interface State {
  hasGetStocksFromBsale: boolean;
  infoFromBsale: { label: string; value: number }[];
  isLoading: boolean;
}

class StockRow extends React.Component<Props, State> {
  state: State = {
    hasGetStocksFromBsale: false,
    infoFromBsale: [],
    isLoading: false,
  };

  componentDidMount() {
    if (this.props.bsaleStockIds.length) {
      this.getStockInfoFromBsale();
    }
  }

  getStockInfoFromBsale = () => {
    this.setState({ isLoading: true });
    return this.props.getStockFromBsale(this.props.bsaleStockIds).then(response =>
      this.setState({
        infoFromBsale: response.data,
        hasGetStocksFromBsale: true,
        isLoading: false,
      })
    );
  };

  render() {
    const stock = this.props.stock;
    const isLoadingText = this.state.isLoading ? (
      <>
        <FontAwesomeIcon icon={faCircleNotch} spin /> <span>Obteniendo...</span>{' '}
      </>
    ) : (
      <span>Ver stock desde Bsale</span>
    );
    const hasGetStockFromBsale = this.state.hasGetStocksFromBsale ? (
      <Select
        options={this.state.infoFromBsale}
        value={this.state.infoFromBsale}
        isDisabled={true}
        isMulti={true}
      />
    ) : (
      <button onClick={this.getStockInfoFromBsale} className="btn btn-dark">
        {isLoadingText}
      </button>
    );
    const hasBsaleStock = this.props.stock.bsale_stock_ids.length ? (
      hasGetStockFromBsale
    ) : (
      <span>No tiene stocks asociados a Bsale</span>
    );

    return (
      <tr>
        <td className="align-middle text-center">{stock.size_name}</td>
        <td className="align-middle text-center">{stock.quantity}</td>
        <td className="align-middle">{hasBsaleStock}</td>
      </tr>
    );
  }
}

export default StockRow;
