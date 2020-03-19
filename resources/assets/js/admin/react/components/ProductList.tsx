import React, { Component } from 'react';
import ReactDOM from 'react-dom';
import axios from 'axios';
import swal from 'sweetalert2';
import { removeFromSimpleArray } from '../helpers';
import ProductRow from './partials/ProductRow';
import { IProduct } from '../../../interfaces/IProduct';
import { IState } from '../../../interfaces/IState';
import { IType } from '../../../interfaces/IType';
import GraphqlAdmin from '../../graphql-admin';
import BottomScrollListener from 'react-bottom-scroll-listener';

interface State {
  productsLoading: boolean;
  productsCurrentPage: number;
  productsLastPage: number;
  products: IProduct[];
  searchText: string;
  selectedProducts: string[];
  selectedMassiveAction: string;
  showFilters: boolean;
  statesForSelect: IState[];
  stateSelected: string;
  subtypesForSelect: IType[];
  subtypeSelected: string;
  creationDates: { value: string; name: string }[];
  creationDateSelected: string;
  months: string[];
  years: string[];
}

class BipolarProductList extends Component<any, State> {
  state: State = {
    productsLoading: true,
    productsCurrentPage: 1,
    productsLastPage: 99,
    products: [],
    searchText: '',
    selectedProducts: [],
    selectedMassiveAction: '',
    // Filter selects
    showFilters: false,
    statesForSelect: [],
    stateSelected: '',
    subtypesForSelect: [],
    subtypeSelected: '',
    creationDates: [],
    creationDateSelected: '',
    months: [
      'Enero',
      'Febrero',
      'Marzo',
      'Abril',
      'Mayo',
      'Junio',
      'Julio',
      'Agosto',
      'Setiembre',
      'Octubre',
      'Noviembre',
      'Diciembre',
    ],
    years: ['2016', '2017'],
  };

  handleDelete = productHashId => {
    swal({
      type: 'warning',
      title: '¿Desea descartar el producto?',
      text: 'El producto se pondrá en la lista de descartados',
      confirmButtonText: 'Sí, descartar',
      showCancelButton: true,
      cancelButtonText: 'No hacer nada',
    }).then(result => {
      if (result.value) {
        swal.showLoading();
        axios.delete(`/ajax-admin/products/remove/${productHashId}`).then(() => {
          swal({
            title: 'Descartado',
            type: 'success',
            toast: true,
            position: 'top-right',
            showConfirmButton: false,
            timer: 3000,
          });
          // this.getAllProducts();
        });
      }
    });
  };

  handleSearch = event => {
    this.setState({ searchText: event.target.value }, this.filterProducts);
  };

  handleStateChange = event => {
    this.setState({ stateSelected: event.target.value }, this.filterProducts);
  };

  handleSubtypeChange = event => {
    this.setState({ subtypeSelected: event.target.value }, this.filterProducts);
  };

  handleCreationDateChange = event => {
    this.setState({ creationDateSelected: event.target.value }, this.filterProducts);
  };

  handleProductSelect = event => {
    const productHashId = event.target.value;
    let selected = this.state.selectedProducts;

    if (event.target.checked) {
      selected.push(productHashId);
    } else {
      selected = removeFromSimpleArray(selected, productHashId);
    }

    return this.setState({ selectedProducts: selected });
  };

  handleSelectAllProducts = event => {
    // TODO: Send a "Selected all event" (as mutation)
    let allProductsIds = [];

    if (event.target.checked) {
      const productSource = this.state.products.length ? this.state.products : this.state.products;
      allProductsIds = productSource.map(product => product['hash_id']);
    }

    this.setState({ selectedProducts: [...allProductsIds] });
  };

  handleMassiveSelection = event => {
    const optionSelected = event.target.value;

    if (this.state.selectedProducts.length === 0) {
      return swal('Error', 'Seleccione un producto o más para continuar', 'error');
    }

    return swal({
      title: 'Atención',
      text: `Se cambiará el estado de todos los ${this.state.selectedProducts.length} productos seleccionados`,
      type: 'warning',
      confirmButtonText: 'Sí, cambiar',
      showCancelButton: true,
      cancelButtonText: 'No hacer nada',
    }).then(result => {
      if (result.value) {
        const products = this.state.selectedProducts;
        let actionUrl;

        switch (optionSelected) {
          case 'change_published': {
            actionUrl = '/ajax-admin/products/state/published';
            break;
          }
          case 'change_draft': {
            actionUrl = '/ajax-admin/products/state/draft';
            break;
          }
          case 'change_pending': {
            actionUrl = '/ajax-admin/products/state/pending';
            break;
          }
          case 'change_reviewed': {
            actionUrl = '/ajax-admin/products/state/reviewed';
            break;
          }
          case 'activate_salient': {
            actionUrl = '/ajax-admin/products/salient/1';
            break;
          }
          case 'deactivate_salient': {
            actionUrl = '/ajax-admin/products/salient/0';
            break;
          }
          case 'activate_free': {
            actionUrl = '/ajax-admin/products/freeshipping/1';
            break;
          }
          case 'deactivate_free': {
            actionUrl = '/ajax-admin/products/freeshipping/0';
            break;
          }
          case 'dolar_price': {
            actionUrl = '/ajax-admin/products/dolar-price';
            break;
          }
        }

        /*
        axios
          .post(actionUrl, { products })
          .then(this.getAllProducts)
          .then(() => {
            swal({
              title: 'Hecho',
              type: 'success',
              toast: true,
              position: 'top-right',
              showConfirmButton: false,
              timer: 5000,
            });
            this.setState({ selectedProducts: [] });
          });
          */
      }
    });
  };

  toggleFilters = () => {
    this.setState({ showFilters: !this.state.showFilters });
  };

  filterProducts = () => {
    let products = this.state.products;

    if (this.state.searchText.length > 0) {
      products = products.filter(product => {
        return product.name.search(this.state.searchText) !== -1;
      });
    }

    if (this.state.stateSelected.length > 0) {
      products = products.filter(product => {
        return (product?.state?.hash_id ?? null) === this.state.stateSelected;
      });
    }

    if (this.state.subtypeSelected.length > 0) {
      products = products.filter(product => {
        let hasSubtypes = product.subtypes.filter(subtype => {
          return subtype['hash_id'] === this.state.subtypeSelected;
        });

        return hasSubtypes.length > 0;
      });
    }

    if (this.state.creationDateSelected.length > 0) {
      products = products.filter(product => {
        return product['created_at_month_year'] === this.state.creationDateSelected;
      });
    }

    // TODO: filter in the backend
    // this.setState({ filteredProducts: products });
  };

  getProducts = async () => {
    this.setState({ productsLoading: true });

    if (this.state.productsCurrentPage + 1 >= this.state.productsLastPage) {
      return;
    }
    const response = await GraphqlAdmin.getPaginatedProducts(this.state.productsCurrentPage);
    const products = response.data.products_pagination.data;
    const currentPage = response.data.products_pagination.current_page;
    const lastPage = response.data.products_pagination.last_page;

    this.setState({
      products: [...this.state.products, ...products],
      productsCurrentPage: currentPage,
      productsLastPage: lastPage,
      productsLoading: false,
    });
  };

  async componentDidMount() {
    const creationDates = [];
    for (let indexYear = 0; indexYear < this.state.years.length; indexYear++) {
      for (let indexMonth = 0; indexMonth < this.state.months.length; indexMonth++) {
        creationDates.push({
          value: `${indexMonth + 1}-${this.state.years[indexYear]}`,
          name: `${this.state.months[indexMonth]} ${this.state.years[indexYear]}`,
        });
      }
    }

    await this.getProducts();
    const responseStates = await GraphqlAdmin.getStates();

    this.setState({
      statesForSelect: [...responseStates.data.states],
      productsLoading: false,
    });

    return axios.all([axios.get('/ajax-admin/types')]).then(
      axios.spread(responseTypes => {
        this.setState({
          subtypesForSelect: responseTypes.data['data'],
          creationDates,
        });
      })
    );
  }

  render() {
    const productsSource = this.state.products;
    const subtypes = this.state.subtypesForSelect.map(type => {
      return type.subtypes.map(subtype => {
        return (
          <option key={subtype['hash_id']} value={subtype['hash_id']}>
            {subtype['name']}
          </option>
        );
      });
    });

    const filters = (
      <div className="row">
        <div className="col-md-3">
          <div className="form-group">
            <label>Filtrar por estado publicación</label>
            <select
              value={this.state.stateSelected}
              onChange={this.handleStateChange}
              className="custom-select col-12">
              <option value="">Todos</option>
              {this.state.statesForSelect.map(state => {
                return (
                  <option key={state.hash_id} value={state.hash_id}>
                    {state.name}
                  </option>
                );
              })}
            </select>
          </div>
        </div>
        <div className="col-md-3">
          <div className="form-group">
            <label>Filtrar por tipo</label>
            <select
              value={this.state.subtypeSelected}
              onChange={this.handleSubtypeChange}
              className="custom-select col-12">
              <option value="">Todos</option>
              {subtypes}
            </select>
          </div>
        </div>
        <div className="col-md-3">
          <div className="form-group">
            <label>Filtrar por fecha de creación</label>
            <select
              value={this.state.creationDateSelected}
              onChange={this.handleCreationDateChange}
              className="custom-select col-12">
              <option value="">Todos</option>
              {this.state.creationDates.map(creationDate => {
                return (
                  <option key={creationDate.value} value={creationDate.value}>
                    {creationDate.name}
                  </option>
                );
              })}
            </select>
          </div>
        </div>
      </div>
    );

    const productsRender = productsSource.map((product, id) => {
      return (
        <ProductRow
          key={id.toString()}
          selectedProducts={this.state.selectedProducts}
          hashId={product.hash_id}
          imageUrl={product.first_photo_url}
          name={product.fullname}
          subtypes={product.subtypes}
          price={product.price_pen}
          priceDolar={product.price_dolar}
          discountPEN={product.discount_pen}
          discountUSD={product.discount_usd}
          priceDiscountPEN={product.price_pen_discount}
          priceDiscountUSD={product.price_usd_discount}
          state={product.state}
          freeShipping={product.free_shipping}
          isShowroomSale={product.is_showroom_sale}
          isSalient={product.is_salient}
          previewUrl={product.route_preview}
          clickDelete={this.handleDelete}
          clickProductSelect={this.handleProductSelect}
        />
      );
    });

    return (
      <BottomScrollListener onBottom={() => this.getProducts()}>
        <div className="row">
          <div className="col-md-12">
            <div className="card">
              <div className="card-body">
                <div className="row">
                  <div className="col-md-9">
                    <label className="control-label">Buscar producto</label>
                    <div className="input-group">
                      <div className="input-group-prepend">
                        <button className="btn btn-dark btn-sm" onClick={this.toggleFilters}>
                          <i className="fas fa-fw fa-filter" /> Filtros
                        </button>
                      </div>
                      <input
                        value={this.state.searchText}
                        onChange={this.handleSearch}
                        type="text"
                        className="form-control"
                      />
                    </div>
                  </div>
                  <div className="col-md-3">
                    <div className="form-group">
                      <label>Acciones (pendiente)</label>
                      <select
                        value={this.state.selectedMassiveAction}
                        onChange={this.handleMassiveSelection}
                        className="custom-select col-12">
                        <option value="" disabled>
                          Seleccione
                        </option>
                        <optgroup label="Estado publicación">
                          <option value="change_published">Cambiar a activo (Publicado)</option>
                          <option value="change_draft">Cambiar a borrador</option>
                          <option value="change_pending">Cambiar a pendiente de revisión</option>
                          <option value="change_reviewed">Cambiar a revisado</option>
                        </optgroup>
                        <optgroup label="Destacado">
                          <option value="activate_salient">Activar destacado</option>
                          <option value="deactivate_salient">Desactivar destacado</option>
                        </optgroup>
                        <optgroup label="Envío gratuito">
                          <option value="activate_free">Activar envío gratuito</option>
                          <option value="deactivate_free">Desactivar envío gratuito</option>
                        </optgroup>
                        <optgroup label="Precio">
                          <option value="dolar_price">Asignar precio en dólares</option>
                        </optgroup>
                      </select>
                    </div>
                  </div>
                </div>
                {this.state.showFilters ? filters : null}
                <div className="table-responsive">
                  <table className="table table-hover color-table dark-table">
                    <thead>
                      <tr>
                        <th className="align-middle">
                          <input
                            type="checkbox"
                            checked={productsSource.length === this.state.selectedProducts.length}
                            onChange={this.handleSelectAllProducts}
                          />
                        </th>
                        <th className="align-middle text-center">
                          <i className="fas fa-fw fa-image" />
                        </th>
                        <th>Nombre</th>
                        <th>Tipos</th>
                        <th className="align-middle text-right">Precio (S/)</th>
                        <th className="align-middle text-right">Precio ($)</th>
                        <th className="align-middle text-center">Descuento (PEN/USD)</th>
                        <th className="align-middle text-right">Desc. (PEN/USD)</th>
                        <th className="align-middle text-center">Estado</th>
                        <th>Acciones</th>
                      </tr>
                    </thead>
                    <tbody>{productsRender.length ? productsRender : null}</tbody>
                    {this.state.productsLoading ? (
                      <tfoot>
                        <tr>
                          <td className="text-center" colSpan={10}>
                            <strong>Loading...</strong>
                          </td>
                        </tr>
                      </tfoot>
                    ) : null}
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </BottomScrollListener>
    );
  }
}

if (document.getElementById('bipolar-product-list')) {
  ReactDOM.render(<BipolarProductList />, document.getElementById('bipolar-product-list'));
}
