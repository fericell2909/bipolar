import ReactDOM from "react-dom";
import React from 'react';
import axios from "axios";
import {removeFromSimpleArray} from "../helpers";
import ProductColors from "./partials/ProductColors";
import ProductSizes from "./partials/ProductSizes";
import ProductTypes from "./partials/ProductTypes";
import {get} from 'lodash';
import swal from "sweetalert2";

export default class BipolarProductEdit extends React.Component {

  constructor(props) {
    super(props);
    this.state = {
      product: {
        name: "",
        price: 0,
        weight: "",
        description: "",
        salient: false,
        selectedState: "",
        selectedColors: [],
        selectedSizes: [],
        selectedSubtypes: [],
      },
      // data for info
      colors: [],
      sizes: [],
      types: [],
      productStates: [],
    };

    this.handleInputChange = this.handleInputChange.bind(this);
    this.handleColorChange = this.handleColorChange.bind(this);
    this.handleSizeChange = this.handleSizeChange.bind(this);
    this.handleSubtypeChange = this.handleSubtypeChange.bind(this);
    this.handleUpdateProduct = this.handleUpdateProduct.bind(this);
    this.handleProductStateChange = this.handleProductStateChange.bind(this);
    this.handleSalientChange = this.handleSalientChange.bind(this);
  }

  handleInputChange(event) {
    this.setState({
      product: {
        ...this.state.product,
        [event.target.name]: event.target.value,
      }
    });
  }

  handleSalientChange(event) {
    this.setState({
      product: {
        ...this.state.product,
        salient: event.target.checked,
      }
    });
  }

  handleColorChange(event) {
    const colorHashId = event.target.value;
    let selected = this.state.product.selectedColors;

    if (event.target.checked) {
      selected.push(colorHashId);
    } else {
      selected = removeFromSimpleArray(selected, colorHashId);
    }

    return this.setState({
      product: {
        ...this.state.product,
        selectedColors: selected,
      }
    });
  }

  handleSizeChange(event) {
    const sizeHashId = event.target.value;
    let selected = this.state.product.selectedSizes;

    if (event.target.checked) {
      selected.push(sizeHashId);
    } else {
      selected = removeFromSimpleArray(selected, sizeHashId);
    }

    return this.setState({
      product: {
        ...this.state.product,
        selectedSizes: selected,
      }
    });
  }

  handleSubtypeChange(event) {
    const subtypeHashId = event.target.value;
    let selected = this.state.product.selectedSubtypes;

    if (event.target.checked) {
      selected.push(subtypeHashId);
    } else {
      selected = removeFromSimpleArray(selected, subtypeHashId);
    }

    return this.setState({
      product: {
        ...this.state.product,
        selectedSubtypes: selected,
      }
    });
  }

  handleUpdateProduct() {
    axios.put(`/ajax-admin/products/${this.props.productHashId}`, {
      name: this.state.product.name,
      price: this.state.product.price,
      weight: this.state.product.weight,
      description: this.state.product.description,
      salient: this.state.product.salient,
      colors: this.state.product.selectedColors,
      sizes: this.state.product.selectedSizes,
      subtypes: this.state.product.selectedSubtypes,
      state: this.state.product.selectedState,
    })
      .then(response => {
        const data = response.data;

        if (response.status === 200) {
          swal({
            title: 'Actualizado',
            type: 'success',
            toast: true,
            position: 'top-right',
            showConfirmButton: false,
            timer: 3000,
          });
          return setTimeout(() => window.location.href = data['edit_route'], 3000);
        }

        return alert('algo malo paso');
      });
  }

  handleProductStateChange(event) {
    this.setState({
      product: {
        ...this.state.product,
        selectedState: event.target.value,
      }
    });
  }

  render() {
    const productStatesRender = this.state.productStates.map(state => {
      return <option key={state['hash_id']} value={state['hash_id']}>{state['name']}</option>
    });

    return (
      <div className="row">
        <div className="col-md-9">
          <div className="white-box">
            <div className="form-row">
              <div className="col-md-6">
                <div className="form-group">
                  <label>Nombre</label>
                  <input value={this.state.product.name} onChange={this.handleInputChange} name="name" type="text"
                         className="form-control" required/>
                </div>
              </div>
              <div className="col-md-6">
                <div className="form-group">
                  <label>Precio</label>
                  <input value={this.state.product.price} onChange={this.handleInputChange} name="price" type="number"
                         className="form-control"/>
                </div>
              </div>
            </div>
            <div className="form-group">
              <label>Descripción (Opcional)</label>
              <textarea value={this.state.product.description} onChange={this.handleInputChange} name="description"
                        className="form-control" rows="7"/>
            </div>
            <div className="form-row">
              <div className="col-md-6">
                <div className="form-group">
                  <label>Estado</label>
                  <select className="form-control" value={this.state.product.selectedState} onChange={this.handleProductStateChange}>
                    <option value="" disabled>Seleccione un estado</option>
                    {productStatesRender.length ? productStatesRender : null}
                  </select>
                </div>
              </div>
              <div className="col-md-6">
                <div className="form-group">
                  <label>Peso (kg)</label>
                  <input value={this.state.product.weight} onChange={this.handleInputChange} name="weight" type="number" step="any"
                         className="form-control" placeholder="Opcional"/>
                </div>
              </div>
            </div>
            <label className="checkbox-inline">
              <input checked={this.state.product.salient} onChange={this.handleSalientChange} type="checkbox"/>
              Destacado
            </label>
            <hr/>
            <button onClick={this.handleUpdateProduct} className="btn btn-dark btn-rounded">
              Actualizar e ir a subir fotos
            </button>
          </div>
        </div>
        <div className="col-md-3">
          <ProductColors colors={this.state.colors}
                         selected={this.state.product.selectedColors}
                         toggleCheck={this.handleColorChange}/>
          <ProductSizes sizes={this.state.sizes}
                        selected={this.state.product.selectedSizes}
                        toggleCheck={this.handleSizeChange}/>
          <ProductTypes types={this.state.types}
                        selected={this.state.product.selectedSubtypes}
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
      axios.get(`/ajax-admin/products/${this.props.productHashId}`),
    ])
      .then(axios.spread((responseColors, responseSizes, responseTypes, responseStates, responseProduct) => {
        const product = responseProduct.data['data'];
        const productInState = {...this.state.product};

        productInState.name = product.name;
        productInState.price = product.price;
        productInState.weight = product.weight !== null ? product.weight : "";
        productInState.description = product.description !== null ? product.description : "";
        productInState.salient = product['is_salient'] !== null;
        productInState.selectedState = get(product, 'state.hash_id', "");
        productInState.selectedColors = product.colors.map(color => color['hash_id']);
        productInState.selectedSubtypes = product.subtypes.map(subtype => subtype['hash_id']);
        productInState.selectedSizes = product.sizes.map(size => size['hash_id']);

        this.setState({
          product: {...productInState},
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

if (document.getElementById('bipolar-product-edit')) {
  const ProductHashId = window.BipolarProductId;
  ReactDOM.render(
    <BipolarProductEdit productHashId={ProductHashId}/>,
    document.getElementById('bipolar-product-edit')
  );
}