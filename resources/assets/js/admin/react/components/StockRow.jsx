import React from 'react';
import Autocomplete from 'react-autocomplete';
import axios from 'axios';

class StockRow extends React.Component {

  state = {
    copyBsaleStocks: [],
    selectedBsaleStock: 0,
    selectedBsaleQuantity: 0,
    selectedBsaleStockText: '',
  };
  styles = {
    selected: {
      background: 'black',
      color: 'white',
      cursor: 'pointer',
      padding: '10px',
    },
    unselected: {
      background: 'white',
      color: 'black',
      cursor: 'pointer',
      padding: '10px',
    },
    wrapperAutocomplete: {
      width: 500,
    },
    inputAutocomplete: {
      width: '100%',
    },
  };

  constructor(props) {
    super(props);
  }

  onChangeText = (event, value) => {
    const searchText = value;
    const bsaleStocks = [...this.state.copyBsaleStocks];

    if (searchText.length === 0) {
      return this.setState({
        copyBsaleStocks: this.props.stocksBsale,
        selectedBsaleStockText: '',
      });
    }

    const filtered = bsaleStocks.filter(stock => {
      return stock.text.toLowerCase().includes(searchText.toLowerCase());
    });

    return this.setState({
      copyBsaleStocks: filtered,
      selectedBsaleStockText: searchText,
    });
  };

  onSelectStock = (nameStock, item) => {
    this.setState({
      selectedBsaleStock: item['id'],
      selectedBsaleQuantity: item['quantity'],
      selectedBsaleStockText: nameStock,
    });
  };

  getItemValue = item => item.text;

  renderAutocomplete = (item, isHighlighted) => {
    return (
      <div key={item.id} style={isHighlighted ? this.styles.selected : this.styles.unselected}>
        {item.text}
      </div>
    );
  };

  saveStockData = () => {
    if (this.state.selectedBsaleStock === 0) {
      return alert('No ha seleccionado ningun stock');
    }

    const params = {
      bsaleStockId: this.state.selectedBsaleStock,
      quantity: this.state.selectedBsaleQuantity,
    };

    return axios.post(`/ajax-admin/stocks/${this.props.stock['id']}`, params)
      .then(() => this.props.onUpdate());
  };

  componentDidMount() {
    this.setState({copyBsaleStocks: [...this.props.stocksBsale]});

    if (this.props.stock['bsale_stock_id'] !== null) {
      const filtered = this.props.stocksBsale.filter(stock => {
        return stock.id === this.props.stock['bsale_stock_id'];
      });

      this.setState({
        copyBsaleStocks: filtered,
        selectedBsaleStockText: filtered[0]['text'],
      });
    }
  }

  render() {
    const stock = this.props.stock;
    const selectedBsaleText = this.state.selectedBsaleStockText;

    return (
      <tr>
        <td>{stock['id']}</td>
        <td className="text-center">{stock['size_name']}</td>
        <td className="text-center">{stock['quantity']}</td>
        <td>
          <Autocomplete
            value={selectedBsaleText}
            items={this.state.copyBsaleStocks}
            renderItem={this.renderAutocomplete}
            getItemValue={this.getItemValue}
            onChange={this.onChangeText}
            onSelect={this.onSelectStock}
            inputProps={{style: this.styles.inputAutocomplete}}
            wrapperStyle={this.styles.wrapperAutocomplete}/>
        </td>
        <td>
          <button onClick={this.saveStockData} className="btn btn-dark btn-rounded btn-sm">
            Guardar
          </button>
        </td>
      </tr>
    );
  }
}

export default StockRow;