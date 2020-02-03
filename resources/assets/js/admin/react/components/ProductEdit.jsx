import ReactDOM from 'react-dom';
import React from 'react';
import axios from 'axios';
import get from 'lodash/get';
import swal from 'sweetalert2';
import { removeFromSimpleArray } from '../helpers';
import { EditorState, ContentState, convertToRaw } from 'draft-js';
import htmlToDraft from 'html-to-draftjs';
import draftToHtml from 'draftjs-to-html';
import { Editor } from 'react-draft-wysiwyg';
import ProductColors from './partials/ProductColors';
import ProductSizes from './partials/ProductSizes';
import ProductTypes from './partials/ProductTypes';

class BipolarProductEdit extends React.Component {
  constructor(props) {
    super(props);
    this.state = {
      product: {
        name: '',
        name_english: '',
        price: 0,
        weight: '',
        description: '',
        description_english: '',
        free_shipping: false,
        salient: false,
        previewUrl: '',
        shopUrl: '',
        selectedState: '',
        selectedColors: [],
        selectedSizes: [],
        selectedSubtypes: [],
      },
      // data for info
      colors: [],
      sizes: [],
      types: [],
      productStates: [],
      // data for editors
      editorState: EditorState.createEmpty(),
      editorStateEnglish: EditorState.createEmpty(),
    };
  }

  handleInputChange = event => {
    this.setState({
      product: {
        ...this.state.product,
        [event.target.name]: event.target.value,
      },
    });
  };

  handleSalientChange = event => {
    this.setState({
      product: {
        ...this.state.product,
        salient: event.target.checked,
      },
    });
  };

  handleColorChange = event => {
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
      },
    });
  };

  handleSizeChange = event => {
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
      },
    });
  };

  handleSubtypeChange = event => {
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
      },
    });
  };

  handleEditorDescription = editorState => {
    const htmlText = draftToHtml(convertToRaw(editorState.getCurrentContent()));
    this.setState({
      editorState,
      product: {
        ...this.state.product,
        description: htmlText,
      },
    });
  };

  handleEditorDescriptionEnglish = editorState => {
    const htmlText = draftToHtml(convertToRaw(editorState.getCurrentContent()));
    this.setState({
      editorStateEnglish: editorState,
      product: {
        ...this.state.product,
        description_english: htmlText,
      },
    });
  };

  handleUpdateProduct = event => {
    event.preventDefault();

    axios
      .put(`/ajax-admin/products/${this.props.productHashId}`, {
        name: this.state.product.name,
        name_english: this.state.product.name_english,
        price: this.state.product.price,
        weight: this.state.product.weight,
        description: this.state.product.description,
        description_english: this.state.product.description_english,
        free_shipping: this.state.product.free_shipping,
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
          return setTimeout(() => (window.location.href = data['edit_route']), 3000);
        }

        return alert('algo malo paso');
      });
  };

  handleChangeFreeShipping = event => {
    this.setState({
      product: {
        ...this.state.product,
        free_shipping: event.target.checked,
      },
    });
  };

  handleProductStateChange = event => {
    this.setState({
      product: {
        ...this.state.product,
        selectedState: event.target.value,
      },
    });
  };

  render() {
    const isInvalidForm =
      this.state.product.name.length === 0 ||
      this.state.product.price <= 0 ||
      this.state.product.selectedState.length === 0;

    const productStatesRender = this.state.productStates.map(state => {
      return (
        <option key={state['hash_id']} value={state['hash_id']}>
          {state['name']}
        </option>
      );
    });

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
              <form onSubmit={this.handleUpdateProduct}>
                <div className="form-row">
                  <div className="col-md-4">
                    <div className="form-group">
                      <label>Nombre</label>
                      <input
                        value={this.state.product.name}
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
                        value={this.state.product.name_english}
                        onChange={this.handleInputChange}
                        name="name_english"
                        className="form-control"
                        type="text"
                        required
                      />
                    </div>
                  </div>
                  <div className="col-md-4">
                    <div className="form-group">
                      <label>Precio</label>
                      <input
                        value={this.state.product.price}
                        onChange={this.handleInputChange}
                        name="price"
                        type="number"
                        className="form-control"
                        required
                      />
                    </div>
                  </div>
                </div>
                <div className="form-row">
                  <div className="col-6">
                    <div className="input-group mb-3">
                      <div className="input-group-prepend">
                        <span className="input-group-text">URL Shop</span>
                      </div>
                      <input
                        type="text"
                        value={this.state.product.shopUrl}
                        className="form-control"
                        readOnly={true}
                      />
                    </div>
                  </div>
                  <div className="col-6">
                    <div className="input-group mb-3">
                      <div className="input-group-prepend">
                        <span className="input-group-text">URL Preview</span>
                      </div>
                      <input
                        type="text"
                        value={this.state.product.previewUrl}
                        className="form-control"
                        readOnly={true}
                      />
                    </div>
                  </div>
                </div>
                <div className="form-group">
                  <label>Descripción (Opcional)</label>
                  <Editor
                    toolbar={toolbarEditor}
                    stripPastedStyles={true}
                    editorState={this.state.editorState}
                    onEditorStateChange={this.handleEditorDescription}
                    editorClassName="demo-editor-content"
                  />
                </div>
                <div className="form-group">
                  <label>Descripción en inglés (Opcional)</label>
                  <Editor
                    toolbar={toolbarEditor}
                    stripPastedStyles={true}
                    editorState={this.state.editorStateEnglish}
                    onEditorStateChange={this.handleEditorDescriptionEnglish}
                    editorClassName="demo-editor-content"
                  />
                </div>
                <div className="form-row">
                  <div className="col-md-6">
                    <div className="form-group">
                      <label>Estado</label>
                      <select
                        className="custom-select col-12"
                        value={this.state.product.selectedState}
                        onChange={this.handleProductStateChange}
                        required>
                        <option value="" disabled>
                          Seleccione un estado
                        </option>
                        {productStatesRender.length ? productStatesRender : null}
                      </select>
                    </div>
                  </div>
                  <div className="col-md-6">
                    <div className="form-group">
                      <label>Peso (kg)</label>
                      <input
                        value={this.state.product.weight}
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
                </div>
                <div className="form-row">
                  <div className="col-md-3">
                    <label className="checkbox-inline">
                      <input
                        checked={this.state.product.free_shipping}
                        onChange={this.handleChangeFreeShipping}
                        type="checkbox"
                      />
                      Envío gratuito
                    </label>
                  </div>
                  <div className="col-md-3">
                    <label className="checkbox-inline">
                      <input
                        checked={this.state.product.salient}
                        onChange={this.handleSalientChange}
                        type="checkbox"
                      />
                      Destacado
                    </label>
                  </div>
                </div>
                <hr />
                <button disabled={isInvalidForm} type="submit" className="btn btn-dark btn-rounded">
                  Actualizar e ir a subir fotos
                </button>
              </form>
            </div>
          </div>
        </div>
        <div className="col-md-3">
          <ProductColors
            colors={this.state.colors}
            selected={this.state.product.selectedColors}
            toggleCheck={this.handleColorChange}
          />
          <ProductSizes
            sizes={this.state.sizes}
            selected={this.state.product.selectedSizes}
            toggleCheck={this.handleSizeChange}
          />
          <ProductTypes
            types={this.state.types}
            selected={this.state.product.selectedSubtypes}
            toggleCheck={this.handleSubtypeChange}
          />
        </div>
      </div>
    );
  }

  getAllInformation() {
    axios
      .all([
        axios.get('/ajax-admin/colors'),
        axios.get('/ajax-admin/sizes'),
        axios.get('/ajax-admin/types'),
        axios.get('/ajax-admin/states'),
        axios.get(`/ajax-admin/products/${this.props.productHashId}`),
      ])
      .then(
        axios.spread(
          (responseColors, responseSizes, responseTypes, responseStates, responseProduct) => {
            const product = responseProduct.data['data'];
            const productInState = { ...this.state.product };

            productInState.name = product.name;
            productInState.name_english = product.name_english;
            productInState.price = product.price;
            productInState.weight = product.weight !== null ? product.weight : '';
            productInState.description = product.description !== null ? product.description : '';
            productInState.description_english =
              product.description_english !== null ? product.description_english : '';
            productInState.free_shipping = product['free_shipping'];
            productInState.salient = product['is_salient'] !== null;
            productInState.shopUrl = product['shop_route'];
            productInState.previewUrl = product['preview_route'];
            productInState.selectedState = get(product, 'state.hash_id', '');
            productInState.selectedColors = product.colors.map(color => color['hash_id']);
            productInState.selectedSubtypes = product.subtypes.map(subtype => subtype['hash_id']);
            productInState.selectedSizes = product.sizes.map(size => size['hash_id']);

            let contentBlock,
              contentBlockEnglish = null;
            let { editorState, editorStateEnglish } = this.state;
            if (product.description !== null) {
              contentBlock = htmlToDraft(product.description);
              const contentState = ContentState.createFromBlockArray(contentBlock.contentBlocks);
              editorState = EditorState.createWithContent(contentState);
            }
            if (product.description_english !== null) {
              contentBlockEnglish = htmlToDraft(product.description_english);
              const contentStateEnglish = ContentState.createFromBlockArray(
                contentBlockEnglish.contentBlocks
              );
              editorStateEnglish = EditorState.createWithContent(contentStateEnglish);
            }

            this.setState({
              product: { ...productInState },
              colors: responseColors.data['data'],
              sizes: responseSizes.data['data'],
              types: responseTypes.data['data'],
              productStates: responseStates.data['data'],
              editorState,
              editorStateEnglish,
            });
          }
        )
      );
  }

  componentDidMount() {
    this.getAllInformation();
  }
}

if (document.getElementById('bipolar-product-edit')) {
  const ProductHashId = window.BipolarProductId;
  ReactDOM.render(
    <BipolarProductEdit productHashId={ProductHashId} />,
    document.getElementById('bipolar-product-edit')
  );
}
