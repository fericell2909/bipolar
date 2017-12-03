import React from "react";
import ReactDOM from 'react-dom';
import axios from "axios";
import { get } from 'lodash';

export default class BipolarProductList extends React.Component {

  constructor() {
    super();
    this.state = {
      products: [],
    };
  }

  render() {

    let productsRender = [];
    if (this.state.products.length) {
      productsRender = this.state.products.map(product => {
        const badgesSubtypes = product['subtypes'].map(subtype => {
          return <span key={subtype['hash_id']} className="badge badge-dark">{subtype['name']}</span>
        });
        const firstImage = (product['firstImageUrl'] !== null) ? 
          <img src={product['firstImageUrl']} width="100" /> : '--';

        return (
          <tr key={product['hash_id']}>
            <td><input type="checkbox" /></td>
            <td>#</td>
            <td>{firstImage}</td>
            <td>{product['name']}</td>
            <td>{badgesSubtypes}</td>
            <td className="text-right">{product['price']}</td>
            <td><i>Por cambiar</i></td>
            <td>
              <a href={`/admin/products/${product['hash_id']}/edit`} className="btn btn-sm btn-dark btn-rounded">
                <i className="fa fa-pencil"/> Editar
              </a>
              <button href="#" className="btn btn-sm btn-dark btn-rounded">
                <i className="fa fa-close"/> Eliminar
              </button>
            </td>
          </tr>
        );
      });
    }

    return (
      <div className="row">
        <div className="col-md-12">
          <div className="white-box">
            <div className="row">
              <div className="col-md-11">
                <h3 className="box-title">Listar los productos</h3>
              </div>
              <div className="col-md-1">
                <a href="/admin/products/new" className="btn btn-dark btn-rounded">
                  <i className="fa fa-plus" /> Nuevo
                </a>
              </div>
            </div>
            <div className="row">
              <div className="col-md-9">
                <div className="form-group">
                  <label>Buscar producto</label>
                  <input type="text" className="form-control" />
                </div>
              </div>
              <div className="col-md-3">
                <div className="form-group">
                  <label>Acciones</label>
                  <select className="custom-select col-12">
                    <option value="1">Activar todos</option>
                    <option value="2">Desactivar todos</option>
                  </select>
                </div>
              </div>
            </div>
            <table className="table">
              <thead>
                <tr>
                  <th><input type="checkbox" /></th>
                  <th>#</th>
                  <th><i className="fa fa-photo" /></th>
                  <th>Nombre</th>
                  <th>Tipos</th>
                  <th className="text-right">Precio</th>
                  <th className="text-center">Estado</th>
                  <th>Acciones</th>
                </tr>
              </thead>
              <tbody>
                {productsRender.length ? productsRender : null}
              </tbody>
            </table>
          </div>
        </div>
      </div>
    );
  }

  getAllProducts() {
    axios.get('/ajax-admin/products')
      .then(response => {
        const products = response.data['data'];
        const formattedProducts = products.map(product => {
          return {
            ...product,
            firstImageUrl: get(product, 'photos.0.url', null),
          }
        });
        this.setState({ products: formattedProducts });
      });
  }

  componentDidMount() {
    this.getAllProducts();
  }
}

if (document.getElementById('bipolar-product-list')) {
  ReactDOM.render(
    <BipolarProductList />,
    document.getElementById('bipolar-product-list')
  );
}