import React from 'react';
import ReactDOM from 'react-dom';
import axios from 'axios';
import { calculatePercentage } from '../helpers';
import swal from 'sweetalert2';

class ProductDiscount extends React.Component<any, any> {
  state = {
    product: {
      name: '',
      price: 0,
      price_dolar: 0,
      discount_PEN: 0,
      discount_USD: 0,
      price_pen_discount: 0,
      price_usd_discount: 0,
    },
  };

  modifyPENDiscount = event => {
    let discount = event.target.value;
    const product = this.state.product;

    if (discount === '' || discount === '-') {
      discount = 0;
    } else {
      discount = parseFloat(event.target.value);
    }

    if (discount <= 0) {
      return this.setState({
        product: {
          ...product,
          discount: 0,
          price_pen_discount: 0,
        },
      });
    }

    const discountPEN = calculatePercentage(this.state.product.price, discount, true);

    this.setState({
      product: {
        ...product,
        discount_PEN: discount,
        price_pen_discount: product.price - discountPEN,
      },
    });
  };

  modifyUSDDiscount = event => {
    let discount = event.target.value;
    const product = this.state.product;

    if (discount === '' || discount === '-') {
      discount = 0;
    } else {
      discount = parseFloat(event.target.value);
    }

    if (discount <= 0) {
      return this.setState({
        product: {
          ...product,
          discount: 0,
          price_usd_discount: 0,
        },
      });
    }

    const discountUSD = calculatePercentage(this.state.product.price_dolar, discount, true);

    this.setState({
      product: {
        ...product,
        discount_USD: discount,
        price_usd_discount: product.price_dolar - discountUSD,
      },
    });
  };

  changePricePEN = event => {
    const discountPEN = parseInt(event.target.value);
    return this.setState({ product: { ...this.state.product, price_discount: discountPEN } });
  };

  changePriceUSD = event => {
    const discountUSD = parseInt(event.target.value);
    return this.setState({ product: { ...this.state.product, price_dolar_discount: discountUSD } });
  };

  getProduct = () => {
    axios.get(`/ajax-admin/products/${this.props.productHashId}`).then(response => {
      const product = response.data.data;
      this.setState({
        product: {
          ...this.state.product,
          name: product['name'],
          price: product['price'],
          price_dolar: product['price_dolar'],
          discount_PEN: product['discount_pen'],
          discount_USD: product['discount_usd'],
          price_pen_discount: product['price_pen_discount'],
          price_usd_discount: product['price_usd_discount'],
        },
      });
    });
  };

  saveChanges = event => {
    event.preventDefault();
    const params = {
      discount_pen: this.state.product.discount_PEN,
      discount_usd: this.state.product.discount_USD,
      price_pen_discount: this.state.product.price_pen_discount,
      price_usd_discount: this.state.product.price_usd_discount,
    };
    return axios
      .post(`/ajax-admin/products/${this.props.productHashId}/discount`, params)
      .then(response => {
        if (response.data['mensaje']) {
          this.getProduct();
          return swal('Hecho', 'Guardado con éxito', 'success');
        }
      });
  };

  removeDiscount = () => {
    const confirmation = confirm('Quitar descuento del producto?');
    if (confirmation) {
      return axios
        .post(`/ajax-admin/products/${this.props.productHashId}/discount`, {
          discount_pen: 0,
          discount_usd: 0,
          price_pen_discount: 0,
          price_usd_discount: 0,
        })
        .then(response => {
          if (response.data['mensaje']) {
            this.getProduct();
            return swal('Hecho', 'Guardado con éxito', 'success');
          }
        });
    }
  };

  render() {
    return (
      <div className="card">
        <div className="card-body">
          <form onSubmit={this.saveChanges}>
            <div className="row">
              <div className="col-md">
                <div className="form-group">
                  <label>Aplicar un descuento en soles para {this.state.product.name} de</label>
                  <div className="input-group">
                    <input
                      value={this.state.product.discount_PEN}
                      onChange={this.modifyPENDiscount}
                      type="number"
                      max={100}
                      className="form-control"
                      required
                    />
                    <div className="input-group-append">
                      <span className="input-group-text">
                        <i className="fas fa-fw fa-percent" />
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
                  <label>Aplicar un descuento en dólares para {this.state.product.name} de</label>
                  <div className="input-group">
                    <input
                      value={this.state.product.discount_USD}
                      onChange={this.modifyUSDDiscount}
                      type="number"
                      max={100}
                      className="form-control"
                      required
                    />
                    <div className="input-group-append">
                      <span className="input-group-text">
                        <i className="fas fa-fw fa-percent" />
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
                    <input
                      value={this.state.product.price_pen_discount}
                      onChange={this.changePricePEN}
                      max={this.state.product.price}
                      type="number"
                      step="any"
                      className="form-control"
                      required
                    />
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
                    <input
                      value={this.state.product.price_usd_discount}
                      onChange={this.changePriceUSD}
                      max={this.state.product.price_dolar}
                      type="number"
                      step="any"
                      className="form-control"
                      required
                    />
                  </div>
                  <span className="help-block">
                    <small>Precio original: $ {this.state.product.price_dolar}</small>
                  </span>
                </div>
              </div>
            </div>
            <button type="submit" className="btn btn-dark btn-rounded">
              Guardar
            </button>
            <button
              onClick={this.removeDiscount}
              type="button"
              className="btn btn-dark btn-rounded ml-1">
              Remover descuento
            </button>
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
  const productId = (window as any).BipolarProductId;
  ReactDOM.render(
    <ProductDiscount productHashId={productId} />,
    document.getElementById('bipolar-product-discount')
  );
}
