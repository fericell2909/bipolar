import React, {Fragment} from 'react';
import ReactDOM from 'react-dom';
import axios from 'axios';
import ReactSelect from "react-select";
import Animated from 'react-select/lib/animated';
import * as moment from "moment";
import Datetime from "react-datetime";
import "react-datetime/css/react-datetime.css";
import MultipleDiscountList from './MultipleDiscountsList';

class MultipleDiscountsNew extends React.Component {
  state = {
    showErrorMessage: false,
    // data from ajax
    productsCopy: [],
    products: [],
    subtypes: [],
    types: [],
    tasks: [],
    // selected from selects
    selectedSubtypes: [],
    selectedTypes: [],
    selectedProducts: [],
    // form data
    name: '',
    qtyDiscountPEN: 0,
    qtyDiscountUSD: 0,
    beginDate: moment().format('DD/MM/YYYY'),
    endDate: moment().format('DD/MM/YYYY'),
  };

  handleUpdateSubtype = values => this.setState({selectedSubtypes: values});

  handleUpdateType = values => this.setState({selectedTypes: values});

  handleUpdateProducts = values => this.setState({selectedProducts: values});

  handleChangeBeginDate = date => {
    this.setState({beginDate: date.format('DD/MM/YYYY')})
  };

  handleChangeEndDate = date => {
    this.setState({endDate: date.format('DD/MM/YYYY')});
  };

  handleChangeDiscountPEN = (event) => this.setState({ qtyDiscountPEN: event.target.value });

  handleChangeDiscountUSD = (event) => this.setState({ qtyDiscountUSD: event.target.value });

  handleNameChange = event => this.setState({ name: event.target.value });

  handleSaveDiscount = event => {
    event.preventDefault();
    const selectedTypes = this.state.selectedTypes;
    const selectedSubtypes = this.state.selectedSubtypes;
    const selectedProducts = this.state.selectedProducts;

    if (selectedSubtypes.length === 0 && selectedTypes.length === 0 && selectedProducts.length === 0) {
      return this.setState({ showErrorMessage: true });
    }

    axios.post('/ajax-admin/discount-tasks', {
      name: this.state.name,
      types: selectedTypes,
      subtypes: selectedSubtypes,
      products: selectedProducts,
      beginDiscount: this.state.beginDate,
      endDiscount: this.state.endDate,
      discountPEN: this.state.qtyDiscountPEN,
      discountUSD: this.state.qtyDiscountUSD,
    })
      .then(() => {
        this.setState({ 
          name: '',
          selectedSubtypes: [],
          selectedTypes: [],
          selectedProducts: [], 
          qtyDiscountPEN: 0,
          qtyDiscountUSD: 0,
        });
      })
      .then(this.getTasks)
      .catch(console.warn);
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

  getTasks = async () => {
    const {data} = await axios.get('/ajax-admin/discount-tasks').catch(console.warn);
    this.setState({tasks: data['data']});
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
    this.getTasks();
    this.getData();
  }

  render() {
    const optionTypes = this.state.types.length ? this.state.types.map(type => {
      return {value: type['id'], label: type["name"]};
    }) : [];
    const optionProducts = this.state.productsCopy.length ? this.state.productsCopy.map(product => {
      return {value: product['id'], label: `${product["fullname"]} - PEN: ${product['price']} / USD: ${product["price_dolar"]}`};
    }) : [];
    const optionSubtypes = this.state.subtypes.length ? this.state.subtypes.map(product => {
      return {value: product['id'], label: product["name"]};
    }) : [];

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
                    <label>Porcentaje descuento soles</label>
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
                    <label>Porcentaje descuento dólares</label>
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
                    <label>Nombre descriptivo</label>
                    <input type="text" onChange={this.handleNameChange} value={this.state.name} className="form-control" placeholder="Ej: Descuentos Cyber Day" maxLength="250" required/>
                  </div>
                </div>
                <div className="col-md">
                  <div className="form-group">
                    <label>Aplicar a tipos</label>
                    <ReactSelect components={Animated} onChange={this.handleUpdateType} options={optionTypes} value={this.state.selectedTypes} isMulti closeMenuOnSelect={false}/>
                  </div>
                </div>
                <div className="col-md">
                  <div className="form-group">
                    <label>Aplicar a subtipos</label>
                    <ReactSelect components={Animated} onChange={this.handleUpdateSubtype} options={optionSubtypes} value={this.state.selectedSubtypes} isMulti closeMenuOnSelect={false}/>
                  </div>
                </div>
                <div className="col-md">
                  <div className="form-group">
                    <label>Aplicar a productos</label>
                    <ReactSelect components={Animated} onChange={this.handleUpdateProducts} options={optionProducts} value={this.state.selectedProducts} isMulti closeMenuOnSelect={false}/>
                  </div>
                </div>
              </div>
              <button type="submit" className="btn btn-sm btn-dark btn-rounded">Crear tarea</button>
            </form>
          </div>
        </div>
        <div className="alert alert-info">
          Disponible: Los descuentos estarán disponibles para aplicarse automáticamente, Ejecutada: el descuento ya fue activado.
        </div>
        <MultipleDiscountList tasks={this.state.tasks} onUpdateTasks={this.getTasks}/>
      </Fragment>
    );
  }
}

if (document.getElementById('bipolar-product-multiple-discounts')) {
  ReactDOM.render(<MultipleDiscountsNew/>, document.getElementById('bipolar-product-multiple-discounts'));
}