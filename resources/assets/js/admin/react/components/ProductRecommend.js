import React, {Component} from 'react';
import ReactDOM from 'react-dom';
import {isEnterKey} from '../helpers';
import {get} from 'lodash';
import axios from 'axios';

export default class BipolarProductRecommended extends Component {

    constructor(props) {
        super(props);
        this.state = {
            findedProducts: [],
            recommendedProducts: [],
            showSuccessMessage: false,
        };

        this.searchProduct = this.searchProduct.bind(this);
        this.getRecommendeds = this.getRecommendeds.bind(this);
    }

    searchProduct(event) {
        if (isEnterKey(event) === false) {
            return;
        }

        const searchText = event.target.value;

        axios.get(`/ajax-admin/products/search?search=${searchText}`)
            .then(({data}) => {
                const products = data['products'];
                this.setState({
                    findedProducts: products,
                });
            })
            .catch(error => console.error(error));
    }

    getRecommendeds() {
        axios.get(`/ajax-admin/products/${this.props.productHashId}/recommendeds`)
            .then(({data}) => {
                const recommendeds = data['recommendeds'];
                this.setState({
                    recommendedProducts: recommendeds,
                });
            })
            .catch(error => console.error(error));
    }

    saveRecommended(productHashId) {
        axios.post(`/ajax-admin/products/${this.props.productHashId}/recommendeds/${productHashId}`)
            .then(({data}) => {
                if (data['success'] === true) {
                    this.setState({
                        findedProducts: [],
                        showSuccessMessage: true,
                    });
                    this.getRecommendeds();
                    setTimeout(() => this.setState({showSuccessMessage : false}), 5000);
                }
            })
            .catch(error => console.log(error))
    }

    removeRecommended(productHashId) {
        axios.delete(`/ajax-admin/products/${this.props.productHashId}/recommendeds/${productHashId}`)
            .then(({data}) => {
                if (data['success'] === true) {
                    this.setState({showSuccessMessage: true});
                    this.getRecommendeds();
                    setTimeout(() => this.setState({showSuccessMessage : false}), 5000);
                }
            })
            .catch(error => console.log(error))
    }

    render() {
        const findedProducts = this.state.findedProducts;
        const findedProductsList = findedProducts.map(product => {
            const firstPhotoUrl = get(product, 'photos[0].url', null);

            return <tr key={product["hash_id"]}>
                <td>#</td>
                <td>
                  {firstPhotoUrl !== null ? (
                    <img srcSet={firstPhotoUrl} width="100" />
                  ) : (
                    "Sin fotos"
                  )}
                </td>
                <td>{product["name"]}</td>
                <td>{product["price"]}</td>
                <td>
                    <button className="btn btn-sm btn-dark btn-rounded" 
                        onClick={() => this.saveRecommended(product['hash_id'])}>
                        Recomendar
                    </button>
                </td>
              </tr>;
        });

        const recommendeds = this.state.recommendedProducts;
        const recommendedList = recommendeds.map(product => {
            const firstPhotoUrl = get(product, 'photos[0].url', null);

            return <tr key={product["hash_id"]}>
                <td>#</td>
                <td>
                {firstPhotoUrl !== null ? (
                    <img srcSet={firstPhotoUrl} width="100" />
                ) : (
                    "Sin fotos"
                )}
                </td>
                <td>{product["name"]}</td>
                <td>{product["price"]}</td>
                <td>
                <button className="btn btn-sm btn-dark btn-rounded" 
                    onClick={() => this.removeRecommended(product['hash_id'])}>
                    Remover
                </button>
                </td>
            </tr>;
        });

        const seeMessage = this.state.showSuccessMessage;
        const message = seeMessage === true ? <div className="col-md-12">
              <div className="alert alert-success">Guardado</div>
            </div> : null;

        const content = <div className="row">
        {message}
        <div className="col-md-6">
          <div className="white-box">
            <h3 className="box-title">Seleccionar recomendados</h3>
            <div className="input-group">
              <input className="form-control" type="text" placeholder="Buscar otros productos" onKeyPress={this.searchProduct} />
              <span className="input-group-btn">
                <button className="btn btn-sm btn-dark btn-rounded">
                  Limpiar
                </button>
              </span>
            </div>
            <table className="table table-responsive">
              <thead>
                <tr>
                  <th>#</th>
                  <th>
                    <i className="fa fa-photo"/>
                  </th>
                  <th>Nombre</th>
                  <th>Precio</th>
                  <th>Acciones</th>
                </tr>
              </thead>
              <tbody>
                {findedProductsList.length > 0 ? (
                  findedProductsList
                ) : (
                  <tr><td colSpan="5">No se encontraron productos</td></tr>
                )}
              </tbody>
            </table>
          </div>
        </div>
        <div className="col-md-6">
          <div className="white-box">
            <h3 className="box-title">Lista de recomendados</h3>
            <table className="table table-responsive">
              <thead>
                <tr>
                  <th>#</th>
                  <th>
                    <i className="fa fa-photo"/>
                  </th>
                  <th>Nombre</th>
                  <th>Precio</th>
                  <th>Acciones</th>
                </tr>
              </thead>
              <tbody>
                {recommendedList.length > 0 ? (
                  recommendedList
                ) : (
                  <tr><td colSpan="5">No hay productos sugeridos</td></tr>
                )}
              </tbody>
            </table>
          </div>
        </div>
      </div>;

        return content;
    }

    componentDidMount() {
        this.getRecommendeds();
    }
}

if (document.getElementById('bipolar-product-recommended')) {
    const ProductHashId = window.BipolarProductId;
    ReactDOM.render(
        <BipolarProductRecommended productHashId={ProductHashId}/>,
        document.getElementById('bipolar-product-recommended')
    );
}
