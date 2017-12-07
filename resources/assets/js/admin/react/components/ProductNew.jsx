import React from 'react';
import ReactDOM from 'react-dom';
import axios from 'axios';
import {existInArray, removeFromSimpleArray} from '../helpers';
import swal from 'sweetalert2';
import ProductColors from "./partials/ProductColors";
import ProductSizes from "./partials/ProductSizes";
import ProductTypes from "./partials/ProductTypes";

export default class BipolarProductNew extends React.Component {

  constructor() {
    super();
    this.state = {
      name: '',
      price: 1,
      description: '',
      weight: '',
      free_shipping: false,
      salient: false,
      // Colors info
      colors: [],
      selectedColors: [],
      // Other info
      sizes: [],
      selectedSizes: [],
      types: [],
      selectedSubtypes: [],
      productStates: [],
      selectedState: '',
    };

    this.handleInputChange = this.handleInputChange.bind(this);
    this.handleSalientChange = this.handleSalientChange.bind(this);
    this.handleColorChange = this.handleColorChange.bind(this);
    this.handleSizeChange = this.handleSizeChange.bind(this);
    this.handleSaveProduct = this.handleSaveProduct.bind(this);
    this.handleSubtypeChange = this.handleSubtypeChange.bind(this);
    this.handleProductStateChange = this.handleProductStateChange.bind(this);
    this.handleChangeFreeShipping = this.handleChangeFreeShipping.bind(this);
  }

  handleInputChange(event) {
    this.setState({[event.target.name]: event.target.value});
  }

  handleSalientChange(event) {
    this.setState({salient: event.target.checked});
  }

  handleColorChange(event) {
    const colorHashId = event.target.value;
    let selected = this.state.selectedColors;

    if (event.target.checked) {
      selected.push(colorHashId);
    } else {
      selected = removeFromSimpleArray(selected, colorHashId);
    }

    return this.setState({selectedColors: selected});
  }

  handleSizeChange(event) {
    const sizeHashId = event.target.value;
    let selected = this.state.selectedSizes;

    if (event.target.checked) {
      selected.push(sizeHashId);
    } else {
      selected = removeFromSimpleArray(selected, sizeHashId);
    }

    return this.setState({selectedSizes: selected});
  }

  handleSubtypeChange(event) {
    const subtypeHashId = event.target.value;
    let selected = this.state.selectedSubtypes;

    if (event.target.checked) {
      selected.push(subtypeHashId);
    } else {
      selected = removeFromSimpleArray(selected, subtypeHashId);
    }

    return this.setState({selectedSubtypes: selected});
  }

  handleProductStateChange(event) {
    this.setState({selectedState: event.target.value});
  }

  handleChangeFreeShipping(event) {
    this.setState({free_shipping: event.target.checked});
  }

  handleSaveProduct(event) {
    event.preventDefault();

    axios.post('/ajax-admin/products', {
      name: this.state.name,
      price: this.state.price,
      weight: this.state.weight,
      description: this.state.description,
      free_shipping: this.state.free_shipping,
      salient: this.state.salient,
      colors: this.state.selectedColors,
      sizes: this.state.selectedSizes,
      subtypes: this.state.selectedSubtypes,
      state: this.state.selectedState,
    })
      .then(response => {
        const data = response.data;
        return (response.status === 201) ? window.location.href = data['edit_route'] : alert('algo malo paso');
      });
  }

  render() {
    const isInvalidForm = this.state.name.length === 0 || this.state.price <= 0 || this.state.selectedState.length === 0;

    const productStatesRender = this.state.productStates.map(state => {
      return <option key={state['hash_id']} value={state['hash_id']}>{state['name']}</option>
    });

    return (
      <div className="row">
        <div className="col-md-9">
          <div className="white-box">
            <form onSubmit={this.handleSaveProduct}>
              <div className="form-row">
                <div className="col-md-6">
                  <div className="form-group">
                    <label>Nombre</label>
                    <input value={this.state.name} onChange={this.handleInputChange} name="name" type="text"
                           className="form-control" required/>
                  </div>
                </div>
                <div className="col-md-6">
                  <div className="form-group">
                    <label>Precio</label>
                    <input value={this.state.price} onChange={this.handleInputChange} name="price" type="number" step="any"
                           className="form-control" required/>
                  </div>
                </div>
              </div>
              <div className="form-group">
                <label>Descripción (Opcional)</label>
                <textarea value={this.state.description} onChange={this.handleInputChange} name="description"
                          className="form-control" rows="7"/>
              </div>
              <div className="form-row">
                <div className="col-md-6">
                  <div className="form-group">
                    <label>Estado</label>
                    <select className="custom-select col-12" value={this.state.selectedState} onChange={this.handleProductStateChange} required>
                      <option value="" disabled>Seleccione un estado</option>
                      {productStatesRender.length ? productStatesRender : null}
                    </select>
                  </div>
                </div>
                <div className="col-md-6">
                  <div className="form-group">
                    <label>Peso (kg)</label>
                    <input value={this.state.weight} onChange={this.handleInputChange} name="weight" type="number" step="any"
                           className="form-control" placeholder="Opcional"/>
                  </div>
                </div>
              </div>
              <div className="form-row">
                <div className="col-md-3">
                  <label className="checkbox-inline">
                    <input checked={this.state.free_shipping} onChange={this.handleChangeFreeShipping} type="checkbox"/>
                    Envío gratuito
                  </label>
                </div>
                <div className="col-md-3">
                  <label className="checkbox-inline">
                    <input checked={this.state.salient} onChange={this.handleSalientChange} type="checkbox"/>
                    Destacado
                  </label>
                </div>
              </div>
              <hr/>
              <button disabled={isInvalidForm} type="submit" className="btn btn-dark btn-rounded">
                Guardar e ir a subir fotos
              </button>
            </form>
          </div>
        </div>
        <div className="col-md-3">
          <ProductColors colors={this.state.colors}
                         selected={this.state.selectedColors}
                         toggleCheck={this.handleColorChange}/>
          <ProductSizes sizes={this.state.sizes}
                        selected={this.state.selectedSizes}
                        toggleCheck={this.handleSizeChange}/>
          <ProductTypes types={this.state.types}
                        selected={this.state.selectedSubtypes}
                        toggleCheck={this.handleSubtypeChange}/>
        </div>
      </div>
    );
  }

  getAllInformation() {
    axios.all([
      axios.get('/ajax-admin/colors'),
      axios.get('/ajax-admin/sizes'),
      axios.get('/ajax-admin/types'),
      axios.get('/ajax-admin/states'),
    ])
      .then(axios.spread((responseColors, responseSizes, responseTypes, responseStates) => {
        this.setState({
          colors: responseColors.data['data'],
          sizes: responseSizes.data['data'],
          types: responseTypes.data['data'],
          productStates: responseStates.data['data'],
        });
      }));
  }

  componentDidMount() {
    this.getAllInformation();
  }
}

if (document.getElementById('bipolar-product-new')) {
  ReactDOM.render(
    <BipolarProductNew/>,
    document.getElementById('bipolar-product-new')
  );
}