import React, { Component } from 'react';
import ReactDOM from 'react-dom';
import axios from 'axios';
import { removeFromSimpleArray } from '../helpers';
import ProductColors from './partials/ProductColors';
import ProductSizes from './partials/ProductSizes';
import ProductTypes from './partials/ProductTypes';
import { EditorState, convertToRaw } from 'draft-js';
import { Editor } from 'react-draft-wysiwyg';
import draftToHtml from 'draftjs-to-html';
import GraphqlAdmin from '../../graphql-admin';
import { ILabel } from '@interfaces/ILabel';
import { IColor } from '@interfaces/IColor';
import { ISize } from '@interfaces/ISize';
import { IState } from '@interfaces/IState';
import BinarySelector from './partials/BinarySelector';

interface State {
  name: string;
  name_english: string;
  price: number;
  description: string;
  description_english: string;
  weight: string;
  free_shipping: boolean;
  is_showroom_sale: boolean;
  salient: boolean;
  colors: IColor[];
  selectedColors: string[];
  sizes: ISize[];
  selectedSizes: string[];
  types: string[];
  selectedSubtypes: string[];
  productStates: IState[];
  selectedState: string;
  labels: ILabel[];
  labelSelected: string;
  editorState: EditorState;
  editorStateEnglish: EditorState;
}

class BipolarProductNew extends Component<any, State> {
  state: State = {
    name: '',
    name_english: '',
    price: 1,
    description: '',
    description_english: '',
    weight: '',
    free_shipping: false,
    is_showroom_sale: false,
    salient: false,
    // Colors info
    colors: [],
    selectedColors: [],
    // Other info
    labels: [],
    labelSelected: '',
    sizes: [],
    selectedSizes: [],
    types: [],
    selectedSubtypes: [],
    productStates: [],
    selectedState: '',
    editorState: EditorState.createEmpty(),
    editorStateEnglish: EditorState.createEmpty(),
  };

  handleInputChange = event => {
    this.setState({ ...this.state, [event.target.name]: event.target.value });
  };

  handleSalientChange = (value: boolean) => this.setState({ salient: value });

  handleColorChange = event => {
    const colorHashId = event.target.value;
    let selected = this.state.selectedColors;

    if (event.target.checked) {
      selected.push(colorHashId);
    } else {
      selected = removeFromSimpleArray(selected, colorHashId);
    }

    return this.setState({ selectedColors: selected });
  };

  handleSizeChange = event => {
    const sizeHashId = event.target.value;
    let selected = this.state.selectedSizes;

    if (event.target.checked) {
      selected.push(sizeHashId);
    } else {
      selected = removeFromSimpleArray(selected, sizeHashId);
    }

    return this.setState({ selectedSizes: selected });
  };

  handleSubtypeChange = event => {
    const subtypeHashId = event.target.value;
    let selected = this.state.selectedSubtypes;

    if (event.target.checked) {
      selected.push(subtypeHashId);
    } else {
      selected = removeFromSimpleArray(selected, subtypeHashId);
    }

    return this.setState({ selectedSubtypes: selected });
  };

  handleProductStateChange = event => {
    this.setState({ selectedState: event.target.value });
  };

  onLabelStateChange = event =>
    this.setState({ labelSelected: event.target.value }, () =>
      console.log(this.state.labelSelected)
    );

  handleChangeFreeShipping = (value: boolean) => this.setState({ free_shipping: value });

  handleEditorDescription = editorState => {
    const htmlText = draftToHtml(convertToRaw(editorState.getCurrentContent()));
    this.setState({ editorState, description: htmlText });
  };

  handleEditorDescriptionEnglish = editorState => {
    const htmlText = draftToHtml(convertToRaw(editorState.getCurrentContent()));
    this.setState({ editorStateEnglish: editorState, description_english: htmlText });
  };

  handleHiddenShowroomChange = (value: boolean) => {
    this.setState({
      ...this.state,
      is_showroom_sale: value,
    });
  };

  handleSaveProduct = () => {
    axios
      .post('/ajax-admin/products', {
        name: this.state.name,
        name_english: this.state.name_english,
        price: this.state.price,
        weight: this.state.weight,
        description: this.state.description,
        description_english: this.state.description_english,
        free_shipping: this.state.free_shipping,
        is_showroom_sale: this.state.is_showroom_sale,
        salient: this.state.salient,
        colors: this.state.selectedColors,
        sizes: this.state.selectedSizes,
        subtypes: this.state.selectedSubtypes,
        state: this.state.selectedState,
        label: this.state.labelSelected,
      })
      .then(response => {
        const data = response.data;
        return response.status === 201
          ? (window.location.href = data['edit_route'])
          : alert('algo malo paso');
      });
  };

  render() {
    const isInvalidForm =
      this.state.name.length === 0 ||
      this.state.price <= 0 ||
      this.state.selectedState.length === 0;
    const productStatesRender = this.state.productStates.map(state => (
      <option key={state.hash_id} value={state.hash_id}>
        {state.name}
      </option>
    ));
    const labelsOptions = this.state.labels.map(label => (
      <option key={label.hash_id} value={label.hash_id}>
        {label.name_es} / {label.name_en}
      </option>
    ));
    const { editorState, editorStateEnglish } = this.state;
    const toolbarEditor = {
      fontFamily: {
        options: ['GothamLight'],
      },
      fontSize: {
        options: [8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 24, 30, 36, 48],
      },
    };

    return (
      <div className="row">
        <div className="col-md-9">
          <div className="card">
            <div className="card-body">
              <div className="form-row">
                <div className="col-md-4">
                  <div className="form-group">
                    <label>Nombre</label>
                    <input
                      value={this.state.name}
                      onChange={this.handleInputChange}
                      name="name"
                      type="text"
                      className="form-control"
                      required
                    />
                  </div>
                </div>
                <div className="col-md-4">
                  <div className="form-group">
                    <label>Nombre (Inglés)</label>
                    <input
                      value={this.state.name_english}
                      onChange={this.handleInputChange}
                      name="name_english"
                      type="text"
                      className="form-control"
                      required
                    />
                  </div>
                </div>
                <div className="col-md-4">
                  <div className="form-group">
                    <label>Precio</label>
                    <input
                      value={this.state.price}
                      onChange={this.handleInputChange}
                      name="price"
                      type="number"
                      step="any"
                      className="form-control"
                      required
                    />
                  </div>
                </div>
              </div>
              <div className="form-group">
                <label>Descripción (Opcional)</label>
                <Editor
                  toolbar={toolbarEditor}
                  stripPastedStyles={true}
                  editorState={editorState}
                  onEditorStateChange={this.handleEditorDescription}
                  editorClassName="demo-editor-content"
                />
              </div>
              <div className="form-group">
                <label>Descripción en inglés (Opcional)</label>
                <Editor
                  toolbar={toolbarEditor}
                  stripPastedStyles={true}
                  editorState={editorStateEnglish}
                  onEditorStateChange={this.handleEditorDescriptionEnglish}
                  editorClassName="demo-editor-content"
                />
              </div>
              <div className="form-row">
                <div className="col-md-4">
                  <div className="form-group">
                    <label>Estado</label>
                    <select
                      className="custom-select col-12"
                      value={this.state.selectedState}
                      onChange={this.handleProductStateChange}
                      required>
                      <option value="" disabled>
                        Seleccione un estado
                      </option>
                      {productStatesRender.length ? productStatesRender : null}
                    </select>
                  </div>
                </div>
                <div className="col-md-4">
                  <div className="form-group">
                    <label>Peso (kg)</label>
                    <input
                      value={this.state.weight}
                      onChange={this.handleInputChange}
                      name="weight"
                      type="number"
                      step="any"
                      className="form-control"
                      placeholder="Opcional"
                      required
                    />
                  </div>
                </div>
                <div className="col-md-4">
                  <div className="form-group">
                    <label>Label (Opcional)</label>
                    <select
                      className="form-control"
                      value={this.state.labelSelected}
                      onChange={this.onLabelStateChange}>
                      <option value="">Ninguno</option>
                      {labelsOptions}
                    </select>
                  </div>
                </div>
              </div>
              <div className="row">
                <div className="col-md-4">
                  <BinarySelector
                    title="Envío gratuito"
                    optionSelected={this.state.free_shipping}
                    toggleFunction={this.handleChangeFreeShipping}
                  />
                </div>
                <div className="col-md-4">
                  <BinarySelector
                    title="Destacado"
                    optionSelected={this.state.salient}
                    toggleFunction={this.handleSalientChange}
                  />
                </div>
                <div className="col-md-4">
                  <BinarySelector
                    title="Showroom sale"
                    trueText="Sí, es privado"
                    falseText="No, es público"
                    optionSelected={this.state.salient}
                    toggleFunction={this.handleHiddenShowroomChange}
                  />
                </div>
              </div>
              <hr />
              <button
                onClick={this.handleSaveProduct}
                disabled={isInvalidForm}
                type="submit"
                className="btn btn-dark btn-rounded">
                Guardar e ir a subir fotos
              </button>
            </div>
          </div>
        </div>
        <div className="col-md-3">
          <ProductColors
            colors={this.state.colors}
            selected={this.state.selectedColors}
            toggleCheck={this.handleColorChange}
          />
          <ProductSizes
            sizes={this.state.sizes}
            selected={this.state.selectedSizes}
            toggleCheck={this.handleSizeChange}
          />
          <ProductTypes
            types={this.state.types}
            selected={this.state.selectedSubtypes}
            toggleCheck={this.handleSubtypeChange}
          />
        </div>
      </div>
    );
  }

  getAllInformation() {
    axios.all([axios.get('/ajax-admin/types')]).then(
      axios.spread(responseTypes => {
        this.setState({
          types: responseTypes.data['data'],
        });
      })
    );
  }

  async componentDidMount() {
    this.getAllInformation();
    const [responseLabels, responseColors, responseSizes, responseStates] = await Promise.all([
      GraphqlAdmin.getLabels(),
      GraphqlAdmin.getColors(),
      GraphqlAdmin.getSizes(),
      GraphqlAdmin.getStates(),
    ]);
    this.setState({
      labels: responseLabels.data.labels,
      colors: responseColors.data.colors,
      sizes: responseSizes.data.sizes,
      productStates: responseStates.data.states,
    });
  }
}

if (document.getElementById('bipolar-product-new')) {
  ReactDOM.render(<BipolarProductNew />, document.getElementById('bipolar-product-new'));
}
