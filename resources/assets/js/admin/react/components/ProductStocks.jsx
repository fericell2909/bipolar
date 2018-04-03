import React from 'react';
import ReactDOM from 'react-dom';
import axios from 'axios';
import StockRow from './StockRow';

class BipolarProductStocks extends React.Component {
  constructor(props) {
    super(props);
    this.state = {
      stocks: [],
      stocksBsale: [
        {id: 1, name: 'Papas'},
        {id: 2, name: 'Camotes'},
        {id: 3, name: 'Yucas'},
      ],
    };
  }

  saveStockData = stockId => {
    return console.log(`Presionado ${stockId}`);
  };

  componentDidMount() {
    const getBsaleStocks = axios.get('/ajax-admin/bsale/products');
    const getStocksByProduct = axios.get(`/ajax-admin/products/${this.props.productHashId}/stocks`);

    axios.all([getBsaleStocks, getStocksByProduct])
      .then(axios.spread((responseBsale, responseStocks) => {
        this.setState({
          stocksBsale: responseBsale.data,
          stocks: responseStocks.data.data,
        });
      }));
  }

  render() {
    const stocks = this.state.stocks.length ?
      this.state.stocks.map(stock => {
        return <StockRow key={stock['id']}
                         stock={stock}
                         stocksBsale={this.state.stocksBsale}
                         saveStock={this.saveStockData}/>;
      }) :
      <tr>
        <td colSpan={3}>No hay stocks</td>
      </tr>;

    return (
      <table className="table table-responsive">
        <thead>
        <tr>
          <th>#</th>
          <th className="text-center">Talla</th>
          <th>Cantidad</th>
          <th>Producto en Bsale</th>
          <th>Acciones</th>
        </tr>
        </thead>
        <tbody>
        {stocks}
        </tbody>
      </table>
    );
  }
}

if (document.getElementById('bipolar-product-stocks')) {
  const ProductHashId = window.BipolarProductId;
  ReactDOM.render(
    <BipolarProductStocks productHashId={ProductHashId}/>,
    document.getElementById('bipolar-product-stocks')
  );
}