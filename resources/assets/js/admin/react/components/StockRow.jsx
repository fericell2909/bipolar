import React from 'react';
import axios from 'axios';
import Select from 'react-select'

class StockRow extends React.Component {
  state = {
    selectedBsaleQuantity: 0,
    mappedStocks: [],
    selectedStock: null,
  };

  handleSelectStock = selectedStock => {
    this.setState({selectedStock});

    if (selectedStock) {
      this.props.stocksBsale.filter(stock => {
        if (stock.id === parseInt(selectedStock['value'])) {
          return this.setState({selectedBsaleQuantity: stock.quantity});
        }
      });
    }
  };

  saveStockData = () => {
    if (this.state.selectedStock === null) {
      return alert('No ha seleccionado ningun stock');
    }

    const params = {
      bsaleStockId: this.state.selectedStock['value'],
      quantity: this.state.selectedBsaleQuantity,
    };

    return axios.post(`/ajax-admin/stocks/${this.props.stock['id']}`, params)
      .then(() => this.props.onUpdate());
  };

  mapStock = async () => {
    const stocks = this.props.stocksBsale.map(stock => ({value: stock.id, label: stock.text}));
    return this.setState({mappedStocks: stocks});
  };

  componentDidMount() {
    this.mapStock().then(() => {
      // set the bsale stock id in state
      if (this.props.stock['bsale_stock_id'] !== null) {
        this.props.stocksBsale.filter(stock => {
          if (stock.id === this.props.stock['bsale_stock_id']) {
            return this.setState({selectedStock: {value: stock.id, label: stock.text}});
          }
        });
      }
    });
  }

  render() {
    const stock = this.props.stock;
    const {selectedStock} = this.state;

    return (
      <tr>
        <td className="align-middle text-center">{stock['size_name']}</td>
        <td className="align-middle text-center">{stock['quantity']}</td>
        <td className="align-middle">
          <Select onChange={this.handleSelectStock}
                  options={this.state.mappedStocks}
                  value={selectedStock}/>
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