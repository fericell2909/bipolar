import React, {Fragment} from 'react';
import ReactDOM from 'react-dom';
import axios from 'axios';
import ReactSelect from "react-select";
import Animated from 'react-select/lib/animated';
import * as moment from "moment";
import Datetime from "react-datetime";
import "react-datetime/css/react-datetime.css";
import * as swal from "sweetalert2";
import { FontAwesomeIcon } from '@fortawesome/react-fontawesome';

class ProductMultipleDiscounts extends React.Component {
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

  handleAvailableToggle = (taskId, available) => {
    return swal({
      title: '¿Cambiar disponibilidad de la tarea?',
      text: "Cambiarla a activa hará que esté disponible para ejecutarse automáticamente",
      showCancelButton: true,
      confirmButtonColor: '#000',
      cancelButtonColor: '#000',
      confirmButtonText: 'Sí, cambiar',
    }).then(async result => {
      if (result.value) {
        await axios.put(`/ajax-admin/discount-tasks/${taskId}`, { available }).catch(console.warn);
        this.getTasks();
        swal({
          title: 'Actualizado',
          type: 'success',
          toast: true,
          position: 'top-right',
          showConfirmButton: false,
          timer: 3000,
        });
      }
    });
  };

  handleExecuteTask = taskId => {
    return swal({
      title: '¿Ejecutar tarea?',
      text: "Esta tarea se ejecutará ahora, se aplicarán descuentos a los productos",
      showCancelButton: true,
      confirmButtonColor: '#000',
      cancelButtonColor: '#000',
      confirmButtonText: 'Sí, ejecutar',
    }).then(async result => {
      if (result.value) {
        await axios.post(`/ajax-admin/discount-tasks/${taskId}/execute`).catch(console.warn);
        this.getTasks();
        swal({
          title: 'Tarea ejecutada',
          type: 'success',
          toast: true,
          position: 'top-right',
          showConfirmButton: false,
          timer: 3000,
        });
      }
    });
  };

  handleRevertTask = taskId => {
    return swal({
      title: '¿Revertir tarea?',
      text: "La reversión se ejecutará ahora, se removerán descuentos a los productos",
      showCancelButton: true,
      confirmButtonColor: '#000',
      cancelButtonColor: '#000',
      confirmButtonText: 'Sí, revertir',
    }).then(async result => {
      if (result.value) {
        await axios.post(`/ajax-admin/discount-tasks/${taskId}/revert`).catch(console.warn);
        this.getTasks();
        swal({
          title: 'Tarea revertida',
          type: 'success',
          toast: true,
          position: 'top-right',
          showConfirmButton: false,
          timer: 3000,
        });
      }
    });
  };

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

    const tasks = this.state.tasks.map(task => {
      const subtypes = task['product_subtypes_full'] ? task['product_subtypes_full'].map(type => type['name']).join(',') : '';
      const types = task['product_types_full'] ? task['product_types_full'].map(type => type['name']).join(',') : '';
      const products = task['products_full'] ? task['products_full'].map(product => product['fullname']).join(',') : '';
      let executable;
      let available;
      let buttonExecute;
      let buttonActivate;
      
      if (task['available']) {
        available = <FontAwesomeIcon icon="check"/>;
        buttonActivate = (
          <button onClick={() => this.handleAvailableToggle(task['id'], false)} className="btn btn-sm btn-dark btn-rounded">
            <FontAwesomeIcon icon="times"/> Desactivar
          </button>
        );
      } else {
        available = <FontAwesomeIcon icon="times"/>;
        buttonActivate = (
          <button onClick={() => this.handleAvailableToggle(task['id'], true)} className="btn btn-sm btn-dark btn-rounded">
            <FontAwesomeIcon icon="check"/> Activar
          </button>
        );
      }

      if (task['available'] && !task['executed']) {
        buttonExecute = (
          <button onClick={() => this.handleExecuteTask(task['id'])} className="btn btn-sm btn-dark btn-rounded">
            <FontAwesomeIcon icon="play"/> Ejecutar
          </button>
        );
      }

      if (task['executed']) {
        executable = <FontAwesomeIcon icon="check"/>;
        buttonExecute = (
          <button onClick={() => this.handleRevertTask(task['id'])} className="btn btn-sm btn-dark btn-rounded">
            <FontAwesomeIcon icon="undo-alt"/> Revertir
          </button>
        );
      } else {
        executable = <FontAwesomeIcon icon="times"/>;
      }
      
      return (
        <tr key={task['id']}>
          <td className="align-middle text-center">{task['name']}</td>
          <td className="align-middle text-center">{task['discount_pen']}</td>
          <td className="align-middle text-center">{task['discount_usd']}</td>
          <td className="align-middle text-center">{task['begin']}</td>
          <td className="align-middle text-center">{task['end']}</td>
          <td className="align-middle text-center">{types}</td>
          <td className="align-middle text-center">{subtypes}</td>
          <td className="align-middle text-center">{products}</td>
          <td className="align-middle text-center">{available}</td>
          <td className="align-middle text-center">{executable}</td>
          <td className="align-middle text-center">
            <div className="button-group">
              {buttonActivate}
              {buttonExecute}
            </div>
          </td>
        </tr>
      );
    });

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
        <div className="card">
          <div className="card-body">
            <h4 className="card-title">Tareas de descuento pendientes</h4>
            <div className="table-responsive">
              <table className="table table-hover color-table dark-table">
                <thead>
                  <tr>
                    <th className="text-center">Nombre</th>
                    <th className="text-center">Desc. S/</th>
                    <th className="text-center">Desc. $</th>
                    <th className="text-center">Inicio</th>
                    <th className="text-center">Fin</th>
                    <th className="text-center">Tipos</th>
                    <th className="text-center">Subtipos</th>
                    <th className="text-center">Productos</th>
                    <th className="text-center">Disponible</th>
                    <th className="text-center">Ejecutada</th>
                    <th className="text-center">Acciones</th>
                  </tr>
                </thead>
                <tbody>
                  {tasks}
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