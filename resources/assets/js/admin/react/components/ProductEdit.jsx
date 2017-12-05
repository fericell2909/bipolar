import ReactDOM from "react-dom";
import React from 'react';
import axios from "axios";
import {removeFromSimpleArray} from "../helpers";
import ProductColors from "./partials/ProductColors";
import ProductSizes from "./partials/ProductSizes";
import ProductTypes from "./partials/ProductTypes";

export default class BipolarProductEdit extends React.Component {

  constructor() {
    super();
    this.state = {
      product: {
        name: "",
        price: 0,
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

    this.handleColorChange = this.handleColorChange.bind(this);
    this.handleSizeChange = this.handleSizeChange.bind(this);
    this.handleSubtypeChange = this.handleSubtypeChange.bind(this);
  }

  handleInputChange(event) {
    this.setState({[event.target.name]: event.target.value});
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

  render() {
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

if (document.getElementById('bipolar-product-edit')) {
  const ProductHashId = window.BipolarProductId;
  ReactDOM.render(
    <BipolarProductEdit productHashId={ProductHashId}/>,
    document.getElementById('bipolar-product-edit')
  );
}