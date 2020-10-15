import React, { Fragment } from 'react';
import ReactDOM from 'react-dom';
import ReactSelect from 'react-select';
import Animated from 'react-select/animated';
import moment from 'moment';
import Datetime from 'react-datetime';
import swal from 'sweetalert2';
import 'react-datetime/css/react-datetime.css';
import PremiumLinksList from './PremiumLinksList';
import GraphqlAdmin from '../../../graphql-admin';
import { IPremiumLink } from '@interfaces/IPremiumLink';
import { gql } from 'apollo-boost';
import { IProduct } from '@interfaces/IProduct';

class PremiumLinksNew extends React.Component {
  state = {
    showErrorMessage: false,
    // data from ajax
    productsCopy: [],
    products: [],
    links: [],
    // selected from selects
    selectedProducts: [],
    // form data
    name: '',
    endDate: moment().format('DD/MM/YYYY'),
  };

  handleUpdateSubtype = values => this.setState({ selectedSubtypes: values });

  handleUpdateType = values => this.setState({ selectedTypes: values });

  handleUpdateProducts = values => this.setState({ selectedProducts: values });


  handleChangeEndDate = date => {
    this.setState({ endDate: date.format('DD/MM/YYYY') });
  };


  handleNameChange = event => this.setState({ name: event.target.value });

  messageValidate( message, type) {
    
    swal({
      title: message,
      type: type,
      toast: false,
      position: 'center',
      showConfirmButton: true,
    });


  }

  Validate(val) { 
    
    if (val === '' || val.length <= 0 || val.trim() === '') {
    
      return false;
  
    } else {

      return true;
    
    }
  
  }

  clean() {
    

    this.setState({  name: '' , end : '' });
 
  }
  

  handleSavePremiumLink = async event => {
    event.preventDefault();

    if (!(this.Validate(this.state.name))) {
      
      this.messageValidate('Debe Ingresar un Nombre Descriptivo', 'warning');
      return false;
    }

    const selectedProducts = this.state.selectedProducts;

    if (selectedProducts.length === 0) {
      return this.setState({ showErrorMessage: true });
    }

    let variables: {} = {
      name: this.state.name,
      end: this.state.endDate,
    };

    if (this.state.selectedProducts.length) {
      variables = {
        ...variables,
        products: this.state.selectedProducts.map(option => option.value),
      };
    }

    swal({
      title: 'Procesando ...',
      toast: true,
      position: 'top-right',
      showConfirmButton: false,
      onOpen: () => swal.showLoading(),
    });

    await GraphqlAdmin.mutation(
      gql`
        mutation DiscountTaskCreation(
          $name: String!
          $end: String!
          $products: [String]
        ) {
          premium_link_creation(
            name: $name
            end: $end
            products: $products
          ) {
            hash_id
          }
        }
      `,
      variables
    )
      .catch(console.warn)
      .then(() => {
        this.clean();
      
        swal.close();
       
      }).finally(() => {
        this.messageValidate('Datos Registrados correctamente.', 'success');
        this.getLinks();
        this.setState({ name: '', selectedProducts: [] });
      });
    
    
  };

  getLinks = async () => {

    swal({
      title: 'Cargando Registros...',
      toast: true,
      position: 'top-right',
      showConfirmButton: false,
      onOpen: () => swal.showLoading(),
    });


    const { data } = await GraphqlAdmin.query<{ premium_links: IPremiumLink[]}>(
      gql`
      query {
        premium_links{
            uuid
            hash_id
            name
            end
            edit_route
            preview_route
            available
            products_model {
              hash_id
              fullname
            }
          }
      }
    `,
    );

    this.setState({ links: [...data.premium_links] });

    swal.close();

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

  componentDidMount() {
    this.getProducts();
    this.getLinks();
  }

  render() {

    const errorMessage = this.state.showErrorMessage ? (
      <div className="alert alert-danger">Por favor llene todos los campos necesarios</div>
    ) : null;

    const optionProducts = this.state.productsCopy.length
      ? this.state.productsCopy.map(product => {
          return {
            value: product.hash_id,
            label: `${product.fullname} - PEN: ${product.price_pen} / USD: ${product.price_usd}`,
          };
        })
      : [];
    
    return (
      <Fragment>
        <div className="card">
          <div className="card-body">
            {errorMessage}
            <form onSubmit={this.handleSavePremiumLink}>
              <div className="row">
                <div className="col-md">
                  <div className="form-group">
                      <label>Nombre descriptivo</label>
                      <input
                        type="text"
                        onChange={this.handleNameChange}
                        value={this.state.name}
                        className="form-control"
                        placeholder="Ej: Enlace Premium Cyber Day"
                        maxLength={250}
                        required
                      />
                  </div>
                </div>
                <div className="col-md">
                  <div className="form-group">
                    <label>Fecha Límite </label>
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
                    <label>Aplicar a productos</label>
                    <ReactSelect
                      components={Animated}
                      onChange={this.handleUpdateProducts}
                      value={this.state.selectedProducts}
                      options={optionProducts}
                      isMulti
                      closeMenuOnSelect={false}
                    />
                  </div>
                </div>
              </div>
              <button type="submit" className="btn btn-sm btn-dark btn-rounded">
                Crear Enlace Premium
              </button>
            </form>
          </div>
        </div>
        <PremiumLinksList links={this.state.links} onUpdateLinks={this.getLinks} />
      </Fragment>
    );
  }
}

if (document.getElementById('bipolar-product-premium-links')) {
  ReactDOM.render(
    <PremiumLinksNew />,
    document.getElementById('bipolar-product-premium-links')
  );
}