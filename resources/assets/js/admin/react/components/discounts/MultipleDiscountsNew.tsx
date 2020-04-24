import React, { Fragment } from 'react';
import ReactDOM from 'react-dom';
import ReactSelect from 'react-select';
import Animated from 'react-select/lib/animated';
import moment from 'moment';
import Datetime from 'react-datetime';
import 'react-datetime/css/react-datetime.css';
import MultipleDiscountList from './MultipleDiscountsList';
import GraphqlAdmin from '../../../graphql-admin';
import { IDiscountTask } from '@interfaces/IDiscountTask';
import { gql } from 'apollo-boost';
import { IProduct } from '@interfaces/IProduct';
import { ISubtype } from '@interfaces/ISubtype';

class MultipleDiscountsNew extends React.Component {
  state = {
    showErrorMessage: false,
    // data from ajax
    productsCopy: [],
    products: [],
    subtypes: [],
    types: [],
    tasks: [],
    // selected from selects
    selectedSubtypes: [],
    selectedTypes: [],
    selectedProducts: [],
    // form data
    name: '',
    qtyDiscountPEN: 0,
    qtyDiscountUSD: 0,
    beginDate: moment().format('DD/MM/YYYY'),
    endDate: moment().format('DD/MM/YYYY'),
  };

  handleUpdateSubtype = values => this.setState({ selectedSubtypes: values });

  handleUpdateType = values => this.setState({ selectedTypes: values });

  handleUpdateProducts = values => this.setState({ selectedProducts: values });

  handleChangeBeginDate = date => {
    this.setState({ beginDate: date.format('DD/MM/YYYY') });
  };

  handleChangeEndDate = date => {
    this.setState({ endDate: date.format('DD/MM/YYYY') });
  };

  handleChangeDiscountPEN = event => this.setState({ qtyDiscountPEN: event.target.value });

  handleChangeDiscountUSD = event => this.setState({ qtyDiscountUSD: event.target.value });

  handleNameChange = event => this.setState({ name: event.target.value });

  handleSaveDiscount = async event => {
    event.preventDefault();
    const selectedSubtypes = this.state.selectedSubtypes;
    const selectedProducts = this.state.selectedProducts;

    if (selectedSubtypes.length === 0 && selectedProducts.length === 0) {
      return this.setState({ showErrorMessage: true });
    }

    let variables: {} = {
      name: this.state.name,
      begin: this.state.beginDate,
      end: this.state.endDate,
      discountPEN: this.state.qtyDiscountPEN,
      discountUSD: this.state.qtyDiscountUSD,
    };

    if (this.state.selectedProducts.length) {
      variables = {
        ...variables,
        products: this.state.selectedProducts.map(option => option.value),
      };
    }

    if (this.state.selectedSubtypes.length) {
      variables = {
        ...variables,
        subtypes: this.state.selectedSubtypes.map(option => option.value),
      };
    }

    await GraphqlAdmin.mutation(
      gql`
        mutation DiscountTaskCreation(
          $name: String!
          $begin: String!
          $end: String!
          $products: [String]
          $subtypes: [String]
          $discountPEN: Int
          $discountUSD: Int
        ) {
          discount_task_creation(
            name: $name
            begin: $begin
            end: $end
            is_2x1: false
            products: $products
            subtypes: $subtypes
            discount_pen: $discountPEN
            discount_usd: $discountUSD
          ) {
            hash_id
          }
        }
      `,
      variables
    )
      .catch(console.warn)
      .then(() => {
        this.getTasks();
        this.setState({ name: '', selectedSubtypes: [], selectedProducts: [] });
      });
  };

  filterProductsWithDiscount = product => {
    if (
      product['discount_pen'] &&
      product['discount_usd'] &&
      product['price_pen_discount'] &&
      product['price_usd_discount'] &&
      product['begin_discount'] &&
      product['end_discount']
    ) {
      return true;
    }
  };

  getTasks = async () => {
    const { data } = await GraphqlAdmin.query<{ discount_tasks: IDiscountTask[] }>(gql`
      query {
        discount_tasks(filters: { is_2x1: false }) {
          hash_id
          name
          begin
          end
          discount_pen
          discount_usd
          is_2x1
          available
          executed
          edit_route
          products_model {
            hash_id
            fullname
          }
          subtypes_model {
            hash_id
            name_es
          }
        }
      }
    `);
    this.setState({ tasks: [...data.discount_tasks] });
  };

  getProducts = async () => {
    const { data } = await GraphqlAdmin.query<{ products: IProduct[] }>(gql`
      query {
        products {
          hash_id
          fullname
          price_pen
          price_usd
          colors {
            name
          }
        }
      }
    `);
    this.setState({ products: [...data.products], productsCopy: [...data.products] });
  };

  getData = async () => {
    const { data } = await GraphqlAdmin.query<{ subtypes: ISubtype[] }>(gql`
      query {
        subtypes {
          hash_id
          name_en
          name_es
        }
      }
    `);

    this.setState({ subtypes: [...data.subtypes] });
  };

  componentDidMount() {
    this.getProducts();
    this.getTasks();
    this.getData();
  }

  render() {
    const optionProducts = this.state.productsCopy.length
      ? this.state.productsCopy.map(product => {
          return {
            value: product.hash_id,
            label: `${product.fullname} - PEN: ${product.price_pen} / USD: ${product.price_usd}`,
          };
        })
      : [];
    const optionSubtypes = this.state.subtypes.length
      ? this.state.subtypes.map(product => {
          return { value: product.hash_id, label: product.name_es };
        })
      : [];

    const errorMessage = this.state.showErrorMessage ? (
      <div className="alert alert-danger">Por favor llene todos los campos necesarios</div>
    ) : null;

    return (
      <Fragment>
        <div className="card">
          <div className="card-body">
            {errorMessage}
            <form onSubmit={this.handleSaveDiscount}>
              <div className="row">
                <div className="col-md">
                  <div className="form-group">
                    <label>Porcentaje descuento soles</label>
                    <div className="input-group">
                      <input
                        value={this.state.qtyDiscountPEN}
                        onChange={this.handleChangeDiscountPEN}
                        type="number"
                        max={100}
                        className="form-control"
                        required
                      />
                      <div className="input-group-append">
                        <span className="input-group-text">
                          <i className="fas fa-fw fa-percent" />
                        </span>
                      </div>
                    </div>
                    <span className="help-block">
                      <small>0: Sin descuento, >= 0: Aplica descuento</small>
                    </span>
                  </div>
                </div>
                <div className="col-md">
                  <div className="form-group">
                    <label>Porcentaje descuento dólares</label>
                    <div className="input-group">
                      <input
                        value={this.state.qtyDiscountUSD}
                        onChange={this.handleChangeDiscountUSD}
                        type="number"
                        max={100}
                        className="form-control"
                        required
                      />
                      <div className="input-group-append">
                        <span className="input-group-text">
                          <i className="fas fa-fw fa-percent" />
                        </span>
                      </div>
                    </div>
                    <span className="help-block">
                      <small>0: Sin descuento, >= 0: Aplica descuento</small>
                    </span>
                  </div>
                </div>
                <div className="col-md">
                  <div className="form-group">
                    <label>Inicio de descuento</label>
                    <Datetime
                      dateFormat="DD/MM/YYYY"
                      onChange={this.handleChangeBeginDate}
                      timeFormat={false}
                      defaultValue={this.state.beginDate}
                    />
                  </div>
                </div>
                <div className="col-md">
                  <div className="form-group">
                    <label>Fin de descuento</label>
                    <Datetime
                      dateFormat="DD/MM/YYYY"
                      onChange={this.handleChangeEndDate}
                      timeFormat={false}
                      defaultValue={this.state.endDate}
                    />
                  </div>
                </div>
              </div>
              <div className="row">
                <div className="col-md">
                  <div className="form-group">
                    <label>Nombre descriptivo</label>
                    <input
                      type="text"
                      onChange={this.handleNameChange}
                      value={this.state.name}
                      className="form-control"
                      placeholder="Ej: Descuentos Cyber Day"
                      maxLength={250}
                      required
                    />
                  </div>
                </div>
                <div className="col-md">
                  <div className="form-group">
                    <label>Aplicar a tipos</label>
                    <input
                      type="text"
                      className="form-control"
                      placeholder="Deshabilitado, línea oculta en el código"
                      disabled={true}
                    />
                  </div>
                </div>
                <div className="col-md">
                  <div className="form-group">
                    <label>Aplicar a subtipos</label>
                    <ReactSelect
                      components={Animated}
                      onChange={this.handleUpdateSubtype}
                      options={optionSubtypes}
                      value={this.state.selectedSubtypes}
                      isMulti
                      closeMenuOnSelect={false}
                    />
                    <span className="help-block">
                      <small>
                        <strong>Cuidado:</strong> Esta opción aplicará el descuento a TODOS los
                        productos que sean del subtipo
                      </small>
                    </span>
                  </div>
                </div>
                <div className="col-md">
                  <div className="form-group">
                    <label>Aplicar a productos</label>
                    <ReactSelect
                      components={Animated}
                      onChange={this.handleUpdateProducts}
                      options={optionProducts}
                      value={this.state.selectedProducts}
                      isMulti
                      closeMenuOnSelect={false}
                    />
                  </div>
                </div>
              </div>
              <button type="submit" className="btn btn-sm btn-dark btn-rounded">
                Crear tarea
              </button>
            </form>
          </div>
        </div>
        <div className="alert alert-info">
          Disponible: Los descuentos estarán disponibles para aplicarse automáticamente, Ejecutada:
          el descuento ya fue activado.
        </div>
        <MultipleDiscountList tasks={this.state.tasks} onUpdateTasks={this.getTasks} />
      </Fragment>
    );
  }
}

if (document.getElementById('bipolar-product-multiple-discounts')) {
  ReactDOM.render(
    <MultipleDiscountsNew />,
    document.getElementById('bipolar-product-multiple-discounts')
  );
}
