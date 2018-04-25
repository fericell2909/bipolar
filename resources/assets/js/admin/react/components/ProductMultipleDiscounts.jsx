import React, {Fragment} from 'react';
import ReactDOM from 'react-dom';
import axios from 'axios';
import ReactSelect from "react-select";
import "react-select/dist/react-select.css";
import * as moment from "moment";
import Datetime from "react-datetime";
import "react-datetime/css/react-datetime.css";

class ProductMultipleDiscounts extends React.Component {
  state = {
    showErrorMessage: false,
    // data from ajax
    productsCopy: [],
    products: [],
    subtypes: [],
    types: [],
    // selected from selects
    selectedSubtypes: [],
    selectedTypes: [],
    selectedProducts: [],
    // form data
    qtyDiscountPEN: 0,
    qtyDiscountUSD: 0,
    beginDate: moment().format('DD/MM/YYYY'),
    endDate: moment().format('DD/MM/YYYY'),
  };

  handleUpdateSubtype = values => {
    const optionsSelected = values.map(value => value['value']);
    this.setState({selectedSubtypes: optionsSelected});
  };

  handleUpdateType = values => {
    const optionsSelected = values.map(value => value['value']);
    this.setState({selectedTypes: optionsSelected});
  };

  handleUpdateProducts = values => {
    const optionsSelected = values.map(value => value['value']);
    this.setState({selectedProducts: optionsSelected});
  };

  handleChangeBeginDate = date => {
    this.setState({beginDate: date.format('DD/MM/YYYY')})
  };

  handleChangeEndDate = date => {
    this.setState({endDate: date.format('DD/MM/YYYY')});
  };

  handleChangeDiscountPEN = (event) => this.setState({ qtyDiscountPEN: event.target.value });

  handleChangeDiscountUSD = (event) => this.setState({ qtyDiscountUSD: event.target.value });

  handleSaveDiscount = event => {
    event.preventDefault();
    const selectedTypes = this.state.selectedTypes;
    const selectedSubtypes = this.state.selectedSubtypes;
    const selectedProducts = this.state.selectedProducts;

    if (selectedSubtypes.length === 0 && selectedTypes.length === 0 && selectedProducts.length === 0) {
      return this.setState({ showErrorMessage: true });
    }

    axios.post('/ajax-admin/products/discounts', {
      types: selectedTypes,
      subtypes: selectedSubtypes,
      products: selectedProducts,
      beginDiscount: this.state.beginDate,
      endDiscount: this.state.endDate,
      discountPEN: this.state.qtyDiscountPEN,
      discountUSD: this.state.qtyDiscountUSD,
    }).then(() => this.getProducts()).catch(console.warn);
  };

  filterProductsWithDiscount = product => {
    if (
      product['discount_pen'] &&
      product['discount_usd'] &&
      product['price_pen_discount'] &&
      product['price_usd_discount'] &&
      product['begin_discount'] &&
      product['end_discount']
    ) {
      return true;
    }
  };

  getProducts = async () => {
    const {data} = await axios.get('/ajax-admin/products').catch(console.warn);
    this.setState({products: data['data'], productsCopy: data['data']});
  };

  getData = async () => {
    const dataTypes = await axios.get('/ajax-admin/types').catch(console.warn);
    const dataSubtypes = await axios.get('/ajax-admin/subtypes').catch(console.warn);
    this.setState({
      subtypes: dataSubtypes['data']['data'],
      types: dataTypes['data']['data'],
    });
  };

  componentDidMount() {
    this.getProducts();
    this.getData();
  }

  render() {
    const optionTypes = this.state.types.length ? this.state.types.map(type => {
      return {value: type['id'], label: type["name"]};
    }) : null;
    const optionProducts = this.state.productsCopy.length ? this.state.productsCopy.map(product => {
      return {value: product['id'], label: `${product["name"]} - PEN: ${product['price']} - USD: ${product["price_dolar"]}`};
    }) : null;
    const optionSubtypes = this.state.subtypes.length ? this.state.subtypes.map(product => {
      return {value: product['id'], label: product["name"]};
    }) : null;

    const products = this.state.products
      .filter(this.filterProductsWithDiscount)
      .map(product => (
        <tr key={product['id']}>
          <td className="align-middle">{product['name']}</td>
          <td className="align-middle text-center">{product['discount_pen']}%</td>
          <td className="align-middle text-center">{product['discount_usd']}%</td>
          <td className="align-middle text-right">S/{product['price']}</td>
          <td className="align-middle text-right">S/{product['price_pen_discount']}</td>
          <td className="align-middle text-right">S/{product['price_dolar']}</td>
          <td className="align-middle text-right">${product['price_usd_discount']}</td>
          <td className="align-middle text-center">{product['begin_discount']}</td>
          <td className="align-middle text-center">{product['end_discount']}</td>
          <td className="align-middle text-center">
            <a href={`/admin/products/${product['slug']}/discount`} target="_blank" className="btn btn-sm btn-dark btn-rounded">Editar único</a>
          </td>
        </tr>
      ));

    const errorMessage = this.state.showErrorMessage ? (
      <div className="alert alert-danger">
        Por favor llene todos los campos necesarios
      </div>
    ) : null;

    return (
      <Fragment>
        <div className="card">
          <div className="card-body">
            {errorMessage}
            <form onSubmit={this.handleSaveDiscount}>
              <div className="row">
                <div className="col-md">
                  <div className="form-group">
                    <label>Cantidad descuento soles</label>
                    <div className="input-group">
                      <input value={this.state.qtyDiscountPEN} onChange={this.handleChangeDiscountPEN} type="number" max={100} className="form-control"  required/>
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
                    <label>Cantidad descuento dólares</label>
                    <div className="input-group">
                      <input value={this.state.qtyDiscountUSD} onChange={this.handleChangeDiscountUSD} type="number" max={100} className="form-control"  required/>
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
                    <label>Inicio de descuento</label>
                    <Datetime dateFormat="DD/MM/YYYY" onChange={this.handleChangeBeginDate} timeFormat={false} defaultValue={this.state.beginDate}/>
                  </div>
                </div>
                <div className="col-md">
                  <div className="form-group">
                    <label>Fin de descuento</label>
                    <Datetime dateFormat="DD/MM/YYYY" onChange={this.handleChangeEndDate} timeFormat={false} defaultValue={this.state.endDate}/>
                  </div>
                </div>
              </div>
              <div className="row">
                <div className="col-md">
                  <div className="form-group">
                    <label>Aplicar a tipos</label>
                    <ReactSelect onChange={this.handleUpdateType} options={optionTypes} value={this.state.selectedTypes} multi closeOnSelect={false}/>
                  </div>
                </div>
                <div className="col-md">
                  <div className="form-group">
                    <label>Aplicar a subtipos</label>
                    <ReactSelect onChange={this.handleUpdateSubtype} options={optionSubtypes} value={this.state.selectedSubtypes} multi closeOnSelect={false}/>
                  </div>
                </div>
                <div className="col-md">
                  <div className="form-group">
                    <label>Aplicar a productos</label>
                    <ReactSelect onChange={this.handleUpdateProducts} options={optionProducts} value={this.state.selectedProducts} multi closeOnSelect={false}/>
                  </div>
                </div>
              </div>
              <button type="submit" className="btn btn-sm btn-dark btn-rounded">Guardar</button>
            </form>
          </div>
        </div>
        <div className="card">
          <div className="card-body">
            <h4 className="card-title">Lista de productos con descuento</h4>
            <div className="table-responsive">
              <table className="table table-hover color-table dark-table">
                <thead>
                  <tr>
                    <th>Producto</th>
                    <th className="text-center">Descuento PEN</th>
                    <th className="text-center">Descuento USD</th>
                    <th className="text-right">Precio PEN</th>
                    <th className="text-right">Precio descuento PEN</th>
                    <th className="text-right">Precio USD</th>
                    <th className="text-right">Precio descuento USD</th>
                    <th className="text-right">Inicio</th>
                    <th className="text-right">Fin</th>
                    <th className="text-center">Acciones</th>
                  </tr>
                </thead>
                <tbody>
                  {products}
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </Fragment>
    );
  }
}

if (document.getElementById('bipolar-product-multiple-discounts')) {
  ReactDOM.render(<ProductMultipleDiscounts/>, document.getElementById('bipolar-product-multiple-discounts'));
}