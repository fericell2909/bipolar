import React from 'react';
import ReactDOM from 'react-dom';
import get from 'lodash/get';
import isEmpty from 'lodash/isEmpty';
import axios from 'axios';
import swal from 'sweetalert2';

export default class BipolarProductRecommended extends React.Component<any, any> {
  constructor(props) {
    super(props);
    this.state = {
      products: [],
      originalProducts: [],
      recommendedProducts: [],
      searchText: '',
    };
  }

  handleSearchProduct = event => {
    const searchText = event.target.value;
    const searchedProducts = this.state.originalProducts.filter(product => {
      return product.name.search(searchText) !== -1;
    });

    this.setState({ searchText, products: searchedProducts });
  };

  handleSaveRecommended(productHashId) {
    swal({
      title: 'Desea asignar este producto como recomendado',
      type: 'question',
      confirmButtonText: 'Asignar y guardar',
      showCancelButton: true,
      cancelButtonText: 'No hacer nada',
    }).then(result => {
      if (result.value) {
        axios
          .post(`/ajax-admin/products/${this.props.productHashId}/recommendeds/${productHashId}`)
          .then(({ data }) => {
            if (data['success'] === true) {
              swal({
                title: 'Guardado',
                type: 'success',
                toast: true,
                position: 'top-right',
                showConfirmButton: false,
                timer: 3000,
              });
              this.getRecommendeds();
            }
          })
          .catch(error => console.log(error));
      }
    });
  }

  handleRemoveRecommended = productHashId => {
    swal({
      title: 'Desea remover este producto de recomendados',
      type: 'question',
      confirmButtonText: 'Remover y guardar',
      showCancelButton: true,
      cancelButtonText: 'No hacer nada',
    }).then(result => {
      if (result.value) {
        axios
          .delete(`/ajax-admin/products/${this.props.productHashId}/recommendeds/${productHashId}`)
          .then(({ data }) => {
            if (data['success'] === true) {
              swal({
                title: 'Guardado',
                type: 'success',
                toast: true,
                position: 'top-right',
                showConfirmButton: false,
                timer: 3000,
              });
              this.getRecommendeds();
            }
          })
          .catch(error => console.log(error));
      }
    });
  };

  render() {
    const findedProductsList = this.state.products.map(product => {
      return (
        <tr key={product['hash_id']}>
          <td className="align-middle">{product['id']}</td>
          <td className="align-middle text-center">
            {product['firstImageUrl'] !== null ? (
              <img src={product['firstImageUrl']} width="100" />
            ) : (
              '--'
            )}
          </td>
          <td className="align-middle">{product['name']}</td>
          <td className="align-middle">
            {isEmpty(product['state']) ? (
              '--'
            ) : (
              <span className={`badge badge-${product['state']['color']}`}>
                {product['state']['name']}
              </span>
            )}
          </td>
          <td className="align-middle">
            <button
              className="btn btn-sm btn-dark btn-rounded"
              onClick={() => this.handleSaveRecommended(product['hash_id'])}>
              Recomendar
            </button>
          </td>
        </tr>
      );
    });

    const recommendedList = this.state.recommendedProducts.map(product => {
      return (
        <tr key={product['hash_id']}>
          <td className="align-middle">#</td>
          <td className="align-middle text-center">
            {product['firstImageUrl'] !== null ? (
              <img src={product['firstImageUrl']} width="100" />
            ) : (
              'Sin fotos'
            )}
          </td>
          <td className="align-middle">{product['name']}</td>
          <td className="align-middle">
            {isEmpty(product['state']) ? (
              '--'
            ) : (
              <span className={`badge badge-${product['state']['color']}`}>
                {product['state']['name']}
              </span>
            )}
          </td>
          <td className="align-middle">
            <button
              className="btn btn-sm btn-dark btn-rounded"
              onClick={() => this.handleRemoveRecommended(product['hash_id'])}>
              Remover
            </button>
          </td>
        </tr>
      );
    });

    const content = (
      <div className="row">
        <div className="col-md">
          <div className="card">
            <div className="card-header">Seleccionar recomendados</div>
            <div className="card-body">
              <div className="input-group mb-3">
                <input
                  className="form-control"
                  type="text"
                  value={this.state.searchText}
                  placeholder="Buscar otros productos"
                  onChange={this.handleSearchProduct}
                />
                <div className="input-group-append">
                  <button onClick={this.handleSearchProduct} className="btn btn-sm btn-dark">
                    Buscar
                  </button>
                </div>
              </div>
              <table className="table table-hover color-table dark-table">
                <thead>
                  <tr>
                    <th>#</th>
                    <th className="text-center">
                      <i className="fas fa-fw fa-image" />
                    </th>
                    <th>Nombre</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                  </tr>
                </thead>
                <tbody>
                  {findedProductsList.length > 0 ? (
                    findedProductsList
                  ) : (
                    <tr>
                      <td colSpan={5}>No se encontraron productos</td>
                    </tr>
                  )}
                </tbody>
              </table>
            </div>
          </div>
        </div>
        <div className="col-md">
          <div className="card">
            <div className="card-header">Lista de recomendados</div>
            <div className="card-body">
              <table className="table table-hover color-table dark-table">
                <thead>
                  <tr>
                    <th>#</th>
                    <th className="text-center">
                      <i className="fas fa-fw fa-image" />
                    </th>
                    <th>Nombre</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                  </tr>
                </thead>
                <tbody>
                  {recommendedList.length > 0 ? (
                    recommendedList
                  ) : (
                    <tr>
                      <td className="text-center" colSpan={5}>
                        No hay productos sugeridos
                      </td>
                    </tr>
                  )}
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    );

    return content;
  }

  getAllProducts = () => {
    axios.get('/ajax-admin/products').then(response => {
      const products = response.data['data'];
      const formattedProducts = products.map(product => {
        return {
          ...product,
          firstImageUrl: get(product, 'photos.0.url', null),
        };
      });

      this.setState({
        products: formattedProducts,
        originalProducts: formattedProducts,
      });
    });
  };

  getRecommendeds = () => {
    axios
      .get(`/ajax-admin/products/${this.props.productHashId}/recommendeds`)
      .then(response => {
        const recommendeds = response.data['data'];
        const formattedRecommendeds = recommendeds.map(product => {
          return {
            ...product,
            firstImageUrl: get(product, 'photos.0.url', null),
          };
        });

        this.setState({
          recommendedProducts: formattedRecommendeds,
        });
      })
      .catch(error => console.error(error));
  };

  componentDidMount() {
    this.getRecommendeds();
    this.getAllProducts();
  }
}

if (document.getElementById('bipolar-product-recommended')) {
  const ProductHashId = (window as any).BipolarProductId;
  ReactDOM.render(
    <BipolarProductRecommended productHashId={ProductHashId} />,
    document.getElementById('bipolar-product-recommended')
  );
}
