import React from 'react';
import ReactDOM from 'react-dom';
import axios from 'axios';
import get from 'lodash/get';
import isEmpty from 'lodash/isEmpty';
import moment from 'moment';
import Datetime from 'react-datetime';
import * as swal from 'sweetalert2';

class BipolarProductMassivePublication extends React.Component {
  state = {
    products: [],
    originalProducts: [],
    selectedProducts: [],
    searchText: '',
    loading: true,
    beginDate: moment().format('DD/MM/YYYY'),
  };

  getAllProducts = async () => {
    const response = await axios.get('/ajax-admin/products', {
      params: {
        states: ['preview', 'review', 'waiting'],
      },
    });
    const products = get(response, 'data.data', []);
    const formattedProducts = products.map(product => {
      return {
        ...product,
        firstImageUrl: get(product, 'photos.0.url', null),
        publishDate: product['publish_date']
          ? moment(product['publish_date']).format('DD-MM-YYYY HH:mm')
          : null,
      };
    });
    this.setState({
      products: formattedProducts,
      originalProducts: formattedProducts,
    });
  };

  handleChangeBeginDate = date => this.setState({ beginDate: date.format('DD/MM/YYYY') });

  handleSearchProduct = event => {
    const searchText = event.target.value;
    const searchedProducts = this.state.originalProducts.filter(product => {
      return product.fullname.toLowerCase().includes(searchText.toLowerCase());
    });

    this.setState({ searchText, products: searchedProducts });
  };

  pickProduct = product => {
    const { selectedProducts } = this.state;

    if (
      selectedProducts.filter(pickedProduct => pickedProduct['hash_id'] === product['hash_id'])
        .length === 0
    ) {
      selectedProducts.push(product);
    }

    this.setState({ selectedProducts });
  };

  unpickProduct = productHashId => {
    console.log(productHashId);
    let { selectedProducts } = this.state;
    selectedProducts = selectedProducts.filter(product => product['hash_id'] !== productHashId);
    this.setState({ selectedProducts });
  };

  updatePublishDate = product => {
    return swal({
      title: '¿Cambiar fecha de publicación?',
      showCancelButton: true,
      confirmButtonColor: '#000',
      cancelButtonColor: '#000',
      confirmButtonText: 'Sí, cambiar',
    }).then(async result => {
      if (result.value) {
        // await axios.put(`/ajax-admin/discount-tasks/${taskId}`, { available }).catch(console.warn);
        swal({
          title: 'Actualizado',
          type: 'success',
          toast: true,
          position: 'top-right',
          showConfirmButton: false,
          timer: 3000,
        });
        this.getAllProducts();
      }
    });
  };

  mapProduct = (product, picked = false) => {
    const image =
      product['firstImageUrl'] !== null ? <img src={product['firstImageUrl']} width="100" /> : '--';
    const state = isEmpty(product['state']) ? (
      '--'
    ) : (
      <span className={`badge text-white badge-${product['state']['color']}`}>
        {product['state']['name']}
      </span>
    );
    const button = picked ? (
      <button
        onClick={() => this.unpickProduct(product['hash_id'])}
        className="btn btn-sm btn-dark-outline btn-rounded">
        <span>Quitar</span>
      </button>
    ) : (
      <button onClick={() => this.pickProduct(product)} className="btn btn-sm btn-dark btn-rounded">
        <span>Escoger</span>
      </button>
    );

    return (
      <tr key={product['hash_id']}>
        <td className="align-middle text-center">{image}</td>
        <td className="align-middle">{product['fullname']} {state}</td>
        <td className="align-middle">{product['publishDate']}</td>
        <td className="align-middle">{button}</td>
      </tr>
    );
  };

  async componentDidMount() {
    await this.getAllProducts();
    await this.setState({ loading: false });
  }

  render() {
    const findedProductsList = this.state.products.map(product => this.mapProduct(product));
    const pickedProductList = this.state.selectedProducts.map(product =>
      this.mapProduct(product, true)
    );

    return (
      <div className="row">
        <div className="col-md-7">
          <div className="card">
            <div className="card-header">Seleccionar recomendados</div>
            <div className="card-body">
              <div className="input-group mb-3">
                <input
                  className="form-control"
                  type="text"
                  placeholder="Buscar productos"
                  onChange={this.handleSearchProduct}
                />
              </div>
              <div className="table-responsive">
                <table className="table table-hover color-table dark-table">
                  <thead>
                    <tr>
                      <th className="text-center">
                        <i className="fas fa-fw fa-image" />
                      </th>
                      <th>Nombre</th>
                      <th>Publicación</th>
                      <th>Acciones</th>
                    </tr>
                  </thead>
                  <tbody>
                    {findedProductsList.length > 0 ? (
                      findedProductsList
                    ) : (
                      <tr>
                        <td colSpan="5">No se encontraron productos</td>
                      </tr>
                    )}
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
        <div className="col-md-5">
          <div className="card">
            <div className="card-header">Seleccionados para modificar</div>
            <div className="card-body">
              <div className="input-group mb-3">
                <Datetime
                  dateFormat="DD/MM/YYYY"
                  inputProps={{ className: 'form-control' }}
                  onChange={this.handleChangeBeginDate}
                  timeFormat={false}
                  value={this.state.beginDate}
                  defaultValue={this.state.beginDate}
                />
                <div className="input-group-append">
                  <button onClick={this.updatePublishDate} className="btn btn-dark">
                    Aplicar
                  </button>
                </div>
              </div>
              <div className="table-responsive">
                <table className="table table-hover color-table dark-table">
                  <thead>
                    <tr>
                      <th className="text-center">
                        <i className="fas fa-fw fa-image" />
                      </th>
                      <th>Nombre</th>
                      <th>Publicación</th>
                      <th>Acciones</th>
                    </tr>
                  </thead>
                  <tbody>{pickedProductList}</tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    );
  }
}

if (document.getElementById('bipolar-product-massive')) {
  ReactDOM.render(
    <BipolarProductMassivePublication />,
    document.getElementById('bipolar-product-massive')
  );
}
