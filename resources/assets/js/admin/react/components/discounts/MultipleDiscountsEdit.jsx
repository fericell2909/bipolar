import React, {Fragment} from 'react';
import ReactDOM from 'react-dom';
import axios from 'axios';
import ReactSelect from "react-select";
import Animated from 'react-select/lib/animated';
import * as moment from "moment";
import Datetime from "react-datetime";
import swal from 'sweetalert2';
import "react-datetime/css/react-datetime.css";

class MultipleDiscountsEdit extends React.Component {
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

    axios.put(`/ajax-admin/discount-tasks/${this.props.taskId}`, {
      name: this.state.name,
      types: selectedTypes,
      subtypes: selectedSubtypes,
      products: selectedProducts,
      beginDiscount: this.state.beginDate,
      endDiscount: this.state.endDate,
      discountPEN: this.state.qtyDiscountPEN,
      discountUSD: this.state.qtyDiscountUSD,
    })
      .then(() => (swal('Actualizado', '', 'success')))
      .then(this.getData)
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

  getDiscountTask = async () => {
    const {data} = await axios.get(`/ajax-admin/discount-tasks/${this.props.taskId}/edit`).catch(console.warn);
    const task = data['data'];

    this.setState({
      qtyDiscountPEN: task['discount_pen'],
      qtyDiscountUSD: task['discount_usd'],
      beginDate: moment(task['begin']).format('DD/MM/YYYY'),
      endDate: moment(task['end']).format('DD/MM/YYYY'),
      name: task['name'],
    });
  };

  getData = async () => {
    const dataTypes = await axios.get('/ajax-admin/types').catch(console.warn);
    const dataSubtypes = await axios.get('/ajax-admin/subtypes').catch(console.warn);
    const dataProducts = await axios.get('/ajax-admin/products').catch(console.warn);
    const subtypes = dataSubtypes['data']['data'];
    const types = dataTypes['data']['data'];
    const products = dataProducts['data']['data'];
    const {data} = await axios.get(`/ajax-admin/discount-tasks/${this.props.taskId}/edit`).catch(console.warn);
    const task = data['data'];

    const selectedSubtypes = subtypes.filter(subtype => (task['product_subtypes'].includes(subtype['id']))).map(this.mapSubtypes);
    const selectedTypes = types.filter(subtype => (task['product_types'].includes(subtype['id']))).map(this.mapTypes);
    const selectedProducts = products.filter(product => (task['products'].includes(product['id']))).map(this.mapProducts);

    this.setState({
      subtypes,
      types,
      products,
      productsCopy: products,
      selectedSubtypes,
      selectedTypes,
      selectedProducts,
      // task data
      qtyDiscountPEN: task['discount_pen'],
      qtyDiscountUSD: task['discount_usd'],
      beginDate: moment(task['begin'], 'DD-MM-YYYY').format('DD/MM/YYYY'),
      endDate: moment(task['end'], 'DD-MM-YYYY').format('DD/MM/YYYY'),
      name: task['name'],
    });
  };

  componentDidMount() {
    this.getData();
    this.getDiscountTask();
  }

  mapTypes = type => ({value: type['id'], label: type["name"]});

  mapProducts = product => ({value: product['id'], label: `${product["fullname"]} - PEN: ${product['price']} / USD: ${product["price_dolar"]}`});

  mapSubtypes = subtype => ({value: subtype['id'], label: subtype["name"]});

  render() {
    const optionTypes = this.state.types.length ? this.state.types.map(this.mapTypes) : [];
    const optionProducts = this.state.productsCopy.length ? this.state.productsCopy.map(this.mapProducts) : [];
    const optionSubtypes = this.state.subtypes.length ? this.state.subtypes.map(this.mapSubtypes) : [];

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
                    <Datetime dateFormat="DD/MM/YYYY" onChange={this.handleChangeBeginDate} timeFormat={false} value={this.state.beginDate} defaultValue={this.state.beginDate}/>
                  </div>
                </div>
                <div className="col-md">
                  <div className="form-group">
                    <label>Fin de descuento</label>
                    <Datetime dateFormat="DD/MM/YYYY" onChange={this.handleChangeEndDate} timeFormat={false} value={this.state.endDate} defaultValue={this.state.endDate}/>
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
                    {/*<ReactSelect components={Animated} onChange={this.handleUpdateType} options={optionTypes} value={this.state.selectedTypes} isMulti closeMenuOnSelect={false} />*/}
                    <input type="text" className="form-control" placeholder="Deshabilitado, línea oculta en el código" disabled={true}/>
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
              <button type="submit" className="btn btn-sm btn-dark btn-rounded">Actualizar tarea de descuento</button>
            </form>
          </div>
        </div>
      </Fragment>
    );
  }
}

if (document.getElementById('bipolar-product-multiple-discounts-edit')) {
  const BipolarTaskId = window.BipolarDiscountTaskId;
  ReactDOM.render(<MultipleDiscountsEdit taskId={BipolarTaskId}/>, document.getElementById('bipolar-product-multiple-discounts-edit'));
}