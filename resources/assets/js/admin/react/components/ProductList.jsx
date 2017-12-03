import React from "react";
import ReactDOM from 'react-dom';
import axios from "axios";
import { get } from 'lodash';
import swal from 'sweetalert2';
import { existInArray, removeFromSimpleArray } from '../helpers';

export default class BipolarProductList extends React.Component {

  constructor() {
    super();
    this.state = {
      products: [],
      filteredProducts: [],
      searchText: '',
      selectedProducts: [],
    };

    this.handleSearch = this.handleSearch.bind(this);
    this.handleProductSelect = this.handleProductSelect.bind(this);
    this.handleSelectAllProducts = this.handleSelectAllProducts.bind(this);
  }

  handleDelete(productHashId) {
    swal({
      type: 'warning',
      title: '¿Desea eliminar el producto?',
      confirmButtonText: 'Sí, eliminar',
      showCancelButton: true,
      cancelButtonText: 'No hacer nada',
    }).then(result => {
      if (result.value) {
        swal.showLoading();
        axios.delete(`/ajax-admin/products/${productHashId}`)
          .then(() => {
            swal({
              title: 'Eliminado',
              type: 'success',
              toast: true,
              position: 'top-right',
              showConfirmButton: false,
              timer: 3000,
            });
            this.getAllProducts();
          });
      }
    });
  }

  handleSearch(event) {
    const searchText = event.target.value;
    const filteredProducts = this.state.products.filter(product => {
      return product.name.search(searchText) !== -1;
    });

    this.setState({ searchText, filteredProducts });
  }

  handleProductSelect(event) {
    const productHashId = event.target.value;
    let selected = this.state.selectedProducts;

    if (event.target.checked) {
        selected.push(productHashId);
    } else {
        selected = removeFromSimpleArray(selected, productHashId);
    }

    return this.setState({ selectedProducts: selected });
  }

  handleSelectAllProducts(event) {
    let allProductsIds = [];
    
    if (event.target.checked) { 
      allProductsIds = this.state.products.map(product => product['hash_id']);
    }

    this.setState({ selectedProducts: [...allProductsIds] });
  }

  render() {

    let productsRender = [];
    const productsSource = (this.state.searchText.length > 0) ? [...this.state.filteredProducts] : [...this.state.products];

    productsRender = productsSource.map(product => {
      const badgesSubtypes = product['subtypes'].map(subtype => {
        return <span key={subtype['hash_id']} className="badge badge-dark">{subtype['name']}</span>
      });
      const firstImage = (product['firstImageUrl'] !== null) ? 
        <img src={product['firstImageUrl']} width="100" /> : '--';
      const isSelected = existInArray(this.state.selectedProducts, product['hash_id']);

      return (
        <tr key={product['hash_id']}>
          <td><input type="checkbox" checked={isSelected} value={product['hash_id']} onChange={this.handleProductSelect} /></td>
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
            <button onClick={() => this.handleDelete(product['hash_id'])} className="btn btn-sm btn-dark btn-rounded">
              <i className="fa fa-close"/> Eliminar
            </button>
          </td>
        </tr>
      );
    });

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
                  <input value={this.state.searchText} onChange={this.handleSearch} type="text" className="form-control" />
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
                  <th><input type="checkbox" onChange={this.handleSelectAllProducts} /></th>
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