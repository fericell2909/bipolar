import React from 'react';
import ReactDOM from 'react-dom';
import axios from 'axios';
import {existInArray, removeFromSimpleArray} from '../helpers';
import swal from 'sweetalert2';

export default class BipolarProductNew extends React.Component {

  constructor() {
    super();
    this.state = {
      name: '',
      price: 1,
      description: '',
      salient: false,
      // Colors info
      colors: [],
      selectedColors: [],
      searchedColors: [],
      textSearchColors: '',
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
    this.handleSearchColors = this.handleSearchColors.bind(this);
    this.handleSaveProduct = this.handleSaveProduct.bind(this);
    this.handleSubtypeChange = this.handleSubtypeChange.bind(this);
    this.handleProductStateChange = this.handleProductStateChange.bind(this);
  }

  handleInputChange(event) {
    this.setState({[event.target.name]: event.target.value});
  }

  handleSalientChange(event) {
    this.setState({salient: event.target.checked});
  }

  handleSearchColors(event) {
    const search = event.target.value.toLowerCase();

    if (search.length === 0) {
      return this.setState({
        searchedColors: [],
        textSearchColors: '',
      });
    }

    const filtered = this.state.colors.filter(color => color.name.toLowerCase().search(search) !== -1);

    return this.setState({
      searchedColors: filtered,
      textSearchColors: search,
    })
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

  handleSaveProduct() {
    if (this.state.name.length === 0) {
      return swal('Faltan campos', 'El campo nombre es obligatorio', 'error');
    }

    axios.post('/ajax-admin/products', {
      name: this.state.name,
      price: this.state.price,
      description: this.state.description,
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
    let colors = (this.state.searchedColors.length === 0 && this.state.textSearchColors.length === 0)
      ? [...this.state.colors]
      : [...this.state.searchedColors];

    const colorsRender = colors.map(color => {
      const isSelected = existInArray(this.state.selectedColors, color['hash_id']);
      return (
        <div key={color['hash_id']} className="checkbox">
          <label><input type="checkbox" checked={isSelected} value={color['hash_id']}
                        onChange={this.handleColorChange}/>{color['name']}</label>
        </div>
      );
    });

    const sizesRender = this.state.sizes.map(size => {
      const isSelected = existInArray(this.state.selectedSizes, size['hash_id']);
      return (
        <div key={size['hash_id']} className="checkbox">
          <label><input type="checkbox" checked={isSelected} value={size['hash_id']}
                        onChange={this.handleSizeChange}/>{size['name']}</label>
        </div>
      );
    });

    const typesRender = this.state.types.map(type => {
      let subtypes = [];
      if (type['subtypes']) {
        subtypes = type['subtypes'].map(subtype => {
          const isSelected = existInArray(this.state.selectedSubtypes, subtype['hash_id']);
          return (
            <div key={subtype['hash_id']} className="checkbox">
              <label><input type="checkbox" checked={isSelected} value={subtype['hash_id']}
                            onChange={this.handleSubtypeChange}/>{subtype['name']}</label>
            </div>
          );
        });
      }

      return (
        <div key={type['hash_id']}>
          <div className="panel panel-inverse">
            <div className="panel-heading">Tipo de {type['name']}</div>
          </div>
          <div className="panel-wrapper collapse in">
            <div className="panel-body">
              {subtypes.length ? subtypes : 'No hay subtipos'}
            </div>
          </div>
        </div>
      );
    });

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
                  <input value={this.state.name} onChange={this.handleInputChange} name="name" type="text"
                         className="form-control" required/>
                </div>
              </div>
              <div className="col-md-6">
                <div className="form-group">
                  <label>Precio</label>
                  <input value={this.state.price} onChange={this.handleInputChange} name="price" type="number"
                         className="form-control"/>
                </div>
              </div>
            </div>
            <div className="form-group">
              <label>Descripción (Opcional)</label>
              <textarea value={this.state.description} onChange={this.handleInputChange} name="description"
                        className="form-control" rows="7"/>
            </div>
            <div className="row">
              <div className="col-md-6">
                <div className="form-group">
                  <label>Estado</label>
                  <select className="form-control" value={this.state.selectedState} onChange={this.handleProductStateChange}>
                    <option value="" disabled>Seleccione un estado</option>
                    {productStatesRender.length ? productStatesRender : null}
                  </select>
                </div>
              </div>
              <div className="col-md-5">
                <label className="checkbox-inline"
                       checked={this.state.salient}
                       onChange={this.handleSalientChange}><input type="checkbox"/>
                  Destacado
                </label>
              </div>
            </div>
            <hr/>
            <button onClick={this.handleSaveProduct} className="btn btn-dark btn-rounded">
              Guardar e ir a subir fotos
            </button>
          </div>
        </div>
        <div className="col-md-3">
          <div className="white-box">
            <div className="panel panel-inverse">
              <div className="panel-heading">Colores</div>
            </div>
            <div className="panel-wrapper collapse in">
              <div className="panel-body">
                <input value={this.state.textSearchColors} onChange={this.handleSearchColors} type="text"
                       className="form-control" placeholder="Buscar color"/>
                {colorsRender.length ? colorsRender : 'No hay colores'}
              </div>
            </div>
            {typesRender.length ? typesRender : 'No hay tipos'}
            <div className="panel panel-inverse">
              <div className="panel-heading">Tallas</div>
            </div>
            <div className="panel-wrapper collapse in">
              <div className="panel-body">
                {sizesRender.length ? sizesRender : 'No hay tallas'}
              </div>
            </div>
          </div>
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