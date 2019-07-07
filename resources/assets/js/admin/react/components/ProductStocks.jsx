import React from 'react';
import ReactDOM from 'react-dom';
import axios from 'axios';
import StockRow from './StockRow';
import { FontAwesomeIcon } from '@fortawesome/react-fontawesome';
import { faCircleNotch } from '@fortawesome/free-solid-svg-icons';

class BipolarProductStocks extends React.Component {
  constructor(props) {
    super(props);
  }

  state = {
    stocks: [],
    stocksBsale: [],
    loading: true,
  };

  onUpdateStock = () => {
    return this.getStocksByProduct().then(response => {
      return this.setState({ stocks: response.data.data });
    });
  };

  getStocksByProduct = () => {
    return axios.get(`/ajax-admin/products/${this.props.productHashId}/stocks`);
  };

  componentDidMount() {
    const getBsaleStocks = axios.get('/ajax-admin/bsale/products');

    axios.all([getBsaleStocks, this.getStocksByProduct()]).then(
      axios.spread((responseBsale, responseStocks) => {
        this.setState({
          stocksBsale: responseBsale.data,
          stocks: responseStocks.data.data,
          loading: false,
        });
      })
    );
  }

  render() {
    const stocks = this.state.stocks.length ? (
      this.state.stocks.map(stock => {
        return (
          <StockRow
            key={stock['id']}
            stock={stock}
            onUpdate={this.onUpdateStock}
            stocksBsale={this.state.stocksBsale}
          />
        );
      })
    ) : (
      <tr>
        <td colSpan={3}>No hay stocks</td>
      </tr>
    );

    return (
      <div>
        {this.state.loading ? (
          <div className="text-center">
            <FontAwesomeIcon icon={faCircleNotch} spin /> Cargando contenido desde Bsale...{' '}
            <FontAwesomeIcon icon={faCircleNotch} spin />
          </div>
        ) : (
          <table className="table">
            <thead>
              <tr>
                <th className="text-center">Talla</th>
                <th className="text-center">Cantidad</th>
                <th>Producto en Bsale</th>
                <th>Acciones</th>
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
  const ProductHashId = window.BipolarProductId;
  ReactDOM.render(
    <BipolarProductStocks productHashId={ProductHashId} />,
    document.getElementById('bipolar-product-stocks')
  );
}
