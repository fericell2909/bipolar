import React from 'react';
import axios from 'axios';
import Select from 'react-select';

class StockRow extends React.Component {
  state = {
    selectedBsaleQuantity: 0,
    mappedStocks: [],
    selectedStocks: [],
  };

  handleSelectStock = async (selectedStocks = []) => {
    await this.setState({ selectedStocks });

    if (selectedStocks.length) {
      let totalQuantity = 0;
      const selectedStockIds = selectedStocks.map(thisStock => thisStock.value);
      this.props.stocksBsale.filter(stock => {
        if (selectedStockIds.includes(stock.id)) {
          totalQuantity += stock.quantity;
        }
      });
      return this.setState({ selectedBsaleQuantity: totalQuantity });
    }
  };

  saveStockData = async () => {
    if (this.state.selectedStocks.length === 0) {
      return alert('No ha seleccionado ningun stock');
    }
    let totalQuantity = 0;

    const bsaleStockIds = this.state.selectedStocks.map(stock => parseInt(stock['value']));

    this.props.stocksBsale.filter(stock => {
      if (bsaleStockIds.includes(stock.id)) {
        totalQuantity += stock.quantity;
      }
    });

    await axios.post(`/ajax-admin/stocks/${this.props.stock['id']}`, {
      bsaleStockIds,
      quantity: totalQuantity,
    });

    this.setState({ selectedBsaleQuantity: 0 });

    return this.props.onUpdate();
  };

  mapStock = async () => {
    const stocks = this.props.stocksBsale.map(stock => ({ value: stock.id, label: stock.text }));
    return this.setState({ mappedStocks: stocks });
  };

  async componentDidMount() {
    await this.mapStock();
    const bsaleStockIdsFromStock = this.props.stock['bsale_stock_ids'];
    if (bsaleStockIdsFromStock.length) {
      const selectedStocks = [];
      this.props.stocksBsale.filter(stock => {
        if (bsaleStockIdsFromStock.includes(stock.id)) {
          selectedStocks.push({ value: stock.id, label: stock.text });
        }
      });

      return this.setState({ selectedStocks });
    }
  }

  render() {
    const stock = this.props.stock;
    const { selectedStocks } = this.state;

    return (
      <tr>
        <td className="align-middle text-center">{stock['size_name']}</td>
        <td className="align-middle text-center">
          {stock['quantity']}{' '}
          {this.state.selectedBsaleQuantity > 0 ? `-> ${this.state.selectedBsaleQuantity}` : ''}
        </td>
        <td className="align-middle">
          <Select
            isMulti={true}
            onChange={this.handleSelectStock}
            options={this.state.mappedStocks}
            value={selectedStocks}
          />
        </td>
        <td className="align-middle">
          <button onClick={this.saveStockData} className="btn btn-dark btn-rounded btn-sm">
            Actualizar
          </button>
        </td>
      </tr>
    );
  }
}

export default StockRow;
