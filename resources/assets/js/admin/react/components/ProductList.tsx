import React, { Component } from 'react';
import ReactDOM from 'react-dom';
import axios from 'axios';
import swal from 'sweetalert2';
import { removeFromSimpleArray } from '../helpers';
import ProductRow from './partials/ProductRow';
import { IProduct } from '@interfaces/IProduct';
import { IState } from '@interfaces/IState';
import { IType } from '@interfaces/IType';
import GraphqlAdmin from '../../graphql-admin';
import BottomScrollListener from 'react-bottom-scroll-listener';
import { toastLoading, toastSuccess } from '../../modals';
import _debounce from 'lodash/debounce';

interface State {
  productsCurrentPage: number;
  productsLastPage: number;
  products: IProduct[];
  selectedProducts: string[];
  selectedMassiveAction: string;
  showFilters: boolean;
  statesForSelect: IState[];
  subtypesForSelect: IType[];
  creationDates: { value: string; name: string }[];
  months: string[];
  years: string[];
  filterProductsBy: {
    search?: string;
    state?: string | undefined;
    subtype?: string | undefined;
    creationDate: string | undefined;
  };
}

class BipolarProductList extends Component<any, State> {
  state: State = {
    productsCurrentPage: 1,
    productsLastPage: 99,
    products: [],
    selectedProducts: [],
    selectedMassiveAction: '',
    // Filter selects
    filterProductsBy: {
      search: undefined,
      state: undefined,
      subtype: undefined,
      creationDate: undefined,
    },
    showFilters: false,
    statesForSelect: [],
    subtypesForSelect: [],
    creationDates: [],
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
    years: ['2016', '2017', '2018', '2019', '2020'],
  };

  debouncedFn: any;

  searchInput = React.createRef<HTMLInputElement>();

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
        axios.delete(`/ajax-admin/products/remove/${productHashId}`).then(async () => {
          swal({
            title: 'Descartado',
            type: 'success',
            toast: true,
            position: 'top-right',
            showConfirmButton: false,
            timer: 3000,
          });
          this.refetchAllProducts();
        });
      }
    });
  };

  handleSearch = event => {
    event.persist();
    if (!this.debouncedFn) {
      this.debouncedFn = _debounce(() => {
        let search = event.target.value;
        this.setState(
          { filterProductsBy: { ...this.state.filterProductsBy, search } },
          this.refetchAllProducts
        );
      }, 1500);
    }
    this.debouncedFn();
  };

  handleStateChange = event => {
    this.setState(
      { filterProductsBy: { ...this.state.filterProductsBy, state: event.target.value } },
      this.refetchAllProducts
    );
  };

  handleSubtypeChange = event => {
    this.setState(
      { filterProductsBy: { ...this.state.filterProductsBy, subtype: event.target.value } },
      this.refetchAllProducts
    );
  };

  handleCreationDateChange = event => {
    this.setState(
      {
        filterProductsBy: { ...this.state.filterProductsBy, creationDate: event.target.value },
      },
      this.refetchAllProducts
    );
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

  handleMassiveSelection = event => {
    const operationSelected = event.target.value;

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
    }).then(async result => {
      if (result.value) {
        const productsHashIds = this.state.selectedProducts;
        const { data } = await GraphqlAdmin.updateProducts(productsHashIds, operationSelected);
        toastSuccess(
          `${data.products_update.map(product => product.fullname).join(', ')} actualizados`
        );
        this.refetchAllProducts();
      }
    });
  };

  toggleFilters = () => {
    this.setState({ showFilters: !this.state.showFilters });
  };

  refetchAllProducts = async () => {
    await this.cleanProducts();
    await this.getProducts();
  };

  cleanProducts = async () =>
    this.setState({ productsCurrentPage: 1, products: [], selectedProducts: [] });

  getProductsQuery = async () => {
    if (
      this.state.productsCurrentPage !== 1 &&
      this.state.productsCurrentPage + 1 >= this.state.productsLastPage
    ) {
      return;
    }
    const { data } = await GraphqlAdmin.getPaginatedProducts(this.state.productsCurrentPage, {
      ...this.state.filterProductsBy,
      creation_date: this.state.filterProductsBy.creationDate,
    });
    const products = data.products_pagination.data;
    const currentPage = data.products_pagination.current_page;
    const lastPage = data.products_pagination.last_page;

    this.setState({
      products: [...this.state.products, ...products],
      productsCurrentPage: currentPage + 1,
      productsLastPage: lastPage,
    });
  };

  getProducts = () => toastLoading(this.getProductsQuery);

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
    const { data } = await GraphqlAdmin.getStates();

    this.setState({ statesForSelect: [...data.states] });

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
              value={this.state.filterProductsBy.state}
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
              value={this.state.filterProductsBy.subtype}
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
              value={this.state.filterProductsBy.creationDate}
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
                        ref={this.searchInput}
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
                        <th className="align-middle" />
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
