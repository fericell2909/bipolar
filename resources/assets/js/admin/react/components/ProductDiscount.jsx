import React from 'react';
import ReactDOM from 'react-dom';
import axios from 'axios';
import {calculatePercentage} from '../helpers';
import swal from 'sweetalert2';

class ProductDiscount extends React.Component {
  constructor(props) {
    super(props);
  }

  state = {
    product: {
      name: '',
      price: 0,
      price_dolar: 0,
      discount: 0,
      price_discount: 0,
      price_dolar_discount: 0,
    },
  };

  modifyDiscount = event => {
    let discount = event.target.value;
    const product = this.state.product;

    if (discount === "" || discount === '-') {
      return this.setState({
        product: {
          ...product,
          discount: "",
          price_discount: 0,
          price_dolar_discount: 0,
        }
      });
    }

    discount = parseFloat(event.target.value);

    if (discount <= 0) {
      return this.setState({
        product: {
          ...product,
          discount: 0,
          price_discount: 0,
          price_dolar_discount: 0,
        }
      });
    }

    const discountPEN = calculatePercentage(this.state.product.price, discount, true);
    const discountUSD = calculatePercentage(this.state.product.price_dolar, discount, true);

    this.setState({
      product: {
        ...product,
        discount,
        price_discount: product.price - discountPEN,
        price_dolar_discount: product.price_dolar - discountUSD,
      }
    });
  };

  changePricePEN = event => {
    const discountPEN = parseInt(event.target.value);
    return this.setState({ product: {...this.state.product, price_discount: discountPEN} });
  };

  changePriceUSD = event => {
    const discountUSD = parseInt(event.target.value);
    return this.setState({ product: {...this.state.product, price_dolar_discount: discountUSD} });
  };

  getProduct = () => {
    axios.get(`/ajax-admin/products/${this.props.productHashId}`)
      .then(response => {
        const product = response.data.data;
        this.setState({
          product: {
            ...this.state.product,
            name: product['name'],
            price: product['price'],
            price_dolar: product['price_dolar'],
            discount: product['discount'],
            price_discount: product['price_discount'],
            price_dolar_discount: product['price_dolar_discount'],
          }
        })
      });
  };

  saveChanges = event => {
    event.preventDefault();
    const params = {
      discount: this.state.product.discount,
      price_discount: this.state.product.price_discount,
      price_dolar_discount: this.state.product.price_dolar_discount,
    };
    return axios.post(`/ajax-admin/products/${this.props.productHashId}/discount`, params)
      .then(response => {
        if (response.data['mensaje']) {
          this.getProduct();
          return swal('Hecho', 'Guardado con éxito', 'success');
        }
      });
  };

  render() {
    return (
      <div className="card">
        <div className="card-body">
          <form onSubmit={this.saveChanges}>
            <div className="row">
              <div className="col-md">
                <div className="form-group">
                  <label>Aplicar un descuento para {this.state.product.name} de</label>
                  <div className="input-group">
                    <input value={this.state.product.discount} onChange={this.modifyDiscount} type="number"  max={100} className="form-control"  required/>
                    <div className="input-group-append">
                    <span className="input-group-text">
                      <i className="fas fa-fw fa-percent"/>
                    </span>
                    </div>
                  </div>
                  <span className="help-block">
                    <small>0: Sin descuento, >= 0: Aplica descuento</small>
                  </span>
                </div>
              </div>
              <div className="col-md">
                <div className="form-group">
                  <label>Precio con descuento en soles</label>
                  <div className="input-group">
                    <div className="input-group-prepend">
                      <span className="input-group-text">S/</span>
                    </div>
                    <input value={this.state.product.price_discount}
                           onChange={this.changePricePEN}
                           max={this.state.product.price}
                           type="number"
                           step="any"
                           className="form-control"
                           required/>
                  </div>
                  <span className="help-block">
                    <small>Precio original: S/ {this.state.product.price}</small>
                  </span>
                </div>
              </div>
              <div className="col-md">
                <div className="form-group">
                  <label>Precio con descuento en dólares</label>
                  <div className="input-group">
                    <div className="input-group-prepend">
                      <span className="input-group-text">$</span>
                    </div>
                    <input value={this.state.product.price_dolar_discount}
                           onChange={this.changePriceUSD}
                           max={this.state.product.price_dolar}
                           type="number"
                           step="any"
                           className="form-control"
                           required/>
                  </div>
                  <span className="help-block">
                    <small>Precio original: $ {this.state.product.price_dolar}</small>
                  </span>
                </div>
              </div>
            </div>
            <button type="submit" className="btn btn-dark btn-rounded">Guardar</button>
          </form>
        </div>
      </div>
    );
  }

  componentDidMount() {
    this.getProduct();
  }
}

if (document.getElementById('bipolar-product-discount')) {
  const productId = window.BipolarProductId;
  ReactDOM.render(<ProductDiscount productHashId={productId}/>, document.getElementById('bipolar-product-discount'));
}